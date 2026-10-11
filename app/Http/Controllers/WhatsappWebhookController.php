<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\WhatsappMessage;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class WhatsappWebhookController extends Controller
{
    public function __construct(protected WhatsappService $whatsappService)
    {
    }

    /**
     * Webhook verification for Meta WhatsApp Cloud API.
     */
    public function verify(Request $request): Response
    {
        $verifyToken = config('services.meta.verify_token', env('META_WHATSAPP_VERIFY_TOKEN', 'lms_webhook_secret_token'));

        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        if ($mode === 'subscribe' && $token === $verifyToken) {
            Log::info('[WhatsApp Webhook] Verification successful');
            return response($challenge, 200)->header('Content-Type', 'text/plain');
        }

        Log::warning('[WhatsApp Webhook] Verification failed token mismatch');
        return response('Forbidden', 403);
    }

    /**
     * Handle incoming events and two-way conversations from WhatsApp users.
     */
    public function handle(Request $request)
    {
        $payload = $request->all();
        Log::info('[WhatsApp Inbound Payload]', $payload);

        $entry = $payload['entry'][0] ?? null;
        $changes = $entry['changes'][0]['value'] ?? null;
        $messages = $changes['messages'] ?? [];

        if (empty($messages)) {
            // Might be a status update (delivered, read)
            return response()->json(['status' => 'acknowledged']);
        }

        foreach ($messages as $msg) {
            $from = $msg['from'] ?? null;
            if (!$from) {
                continue;
            }

            $msgType = $msg['type'] ?? 'text';
            $body = '';

            if ($msgType === 'text') {
                $body = trim($msg['text']['body'] ?? '');
            } elseif ($msgType === 'interactive') {
                $body = $msg['interactive']['button_reply']['id'] ?? $msg['interactive']['list_reply']['id'] ?? '';
            }

            // Find associated user by phone
            $user = User::where('phone', 'LIKE', '%' . substr($from, -10))->first();

            // Record inbound message
            WhatsappMessage::create([
                'user_id' => $user?->id,
                'direction' => 'inbound',
                'phone_number' => $from,
                'message_type' => $msgType,
                'message_body' => $body,
                'meta_message_id' => $msg['id'] ?? null,
                'trigger_type' => 'user_message',
                'status' => 'delivered',
            ]);

            // Two-way Bot Response Logic
            $this->processBotResponse($from, $body, $user);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Process conversational bot replies based on user intent.
     */
    protected function processBotResponse(string $phone, string $text, ?User $user): void
    {
        $upper = strtoupper(trim($text));

        // 1. Check PROGRESS
        if (str_contains($upper, 'PROGRESS') || str_contains($upper, 'STATUS')) {
            if (!$user) {
                $this->whatsappService->sendTextMessage(
                    $phone,
                    "👋 Welcome to LMS Bot! We couldn't find an account matching your phone number. Please register at: " . route('register')
                );
                return;
            }

            $enrollments = $user->enrollments()->with('course')->get();
            if ($enrollments->isEmpty()) {
                $this->whatsappService->sendTextMessage(
                    $phone,
                    "Hi {$user->name}, you are not enrolled in any courses yet! Browse available courses here: " . route('courses.index')
                );
                return;
            }

            $reply = "📊 *Your LMS Learning Progress:*\n\n";
            foreach ($enrollments as $enr) {
                $statusIcon = $enr->status === 'completed' ? '✅' : ($enr->hasStarted() ? '⏳' : '🆕');
                $reply .= "• *{$enr->course->title}*\n";
                $reply .= "  Status: {$statusIcon} " . ucfirst($enr->status) . " ({$enr->progress_percentage}%)\n\n";
            }
            $reply .= "Reply *NEXT* to get the link to your next lesson!";

            $this->whatsappService->sendTextMessage($phone, $reply, $user, 'bot_reply');
            return;
        }

        // 2. Check NEXT LESSON
        if (str_contains($upper, 'NEXT') || str_contains($upper, 'LESSON')) {
            if (!$user) {
                $this->whatsappService->sendTextMessage($phone, "Please log in to your account to view your lessons: " . route('login'));
                return;
            }

            $enrollment = $user->enrollments()->where('status', '!=', 'completed')->latest()->first();
            if (!$enrollment) {
                $this->whatsappService->sendTextMessage($phone, "You've completed all your current courses! 🏆 Check out new courses here: " . route('courses.index'));
                return;
            }

            $course = $enrollment->course;
            $nextLesson = $course->lessons()
                ->whereNotIn('id', function ($query) use ($enrollment) {
                    $query->select('lesson_id')
                        ->from('lesson_progress')
                        ->where('enrollment_id', $enrollment->id)
                        ->where('is_completed', true);
                })
                ->orderBy('sort_order', 'asc')
                ->first();

            if ($nextLesson) {
                $url = route('student.lesson.show', [$course->slug, $nextLesson->slug]);
                $reply = "▶️ *Up Next in {$course->title}:*\n\n" .
                    "*{$nextLesson->title}*\n" .
                    "⏱️ Duration: {$nextLesson->video_duration_minutes} mins\n\n" .
                    "Watch online now: {$url}";
            } else {
                $finalExam = $course->finalExam();
                $url = $finalExam ? route('student.quiz.show', [$course->slug, $finalExam->id]) : route('student.dashboard');
                $reply = "🎯 You have watched all lessons in *{$course->title}*!\n\nTake the final certification exam to claim your certificate:\n👉 {$url}";
            }

            $this->whatsappService->sendTextMessage($phone, $reply, $user, 'bot_reply');
            return;
        }

        // 3. Check CERTIFICATE / BADGE
        if (str_contains($upper, 'CERTIFICATE') || str_contains($upper, 'BADGE')) {
            if (!$user) {
                $this->whatsappService->sendTextMessage($phone, "Please log in to view your certificates: " . route('login'));
                return;
            }

            $completed = $user->enrollments()->where('status', 'completed')->with('certificate', 'course')->get();
            if ($completed->isEmpty()) {
                $this->whatsappService->sendTextMessage($phone, "You have not earned any certificates yet. Complete a course and pass the exam to get certified! 🎓");
                return;
            }

            $reply = "🎓 *Your Verified Certificates & Badges:*\n\n";
            foreach ($completed as $enr) {
                if ($enr->certificate) {
                    $reply .= "🏆 *{$enr->course->title}*\n";
                    $reply .= "Cert #: {$enr->certificate->certificate_number}\n";
                    $reply .= "View Badge & Share: " . route('certificates.verify', $enr->certificate->share_token) . "\n\n";
                }
            }

            $this->whatsappService->sendTextMessage($phone, $reply, $user, 'bot_reply');
            return;
        }

        // 4. Check COURSES
        if (str_contains($upper, 'COURSE') || str_contains($upper, 'CATALOG')) {
            $courses = Course::where('status', 'published')->take(3)->get();
            $reply = "📚 *Available Authority Courses:*\n\n";
            foreach ($courses as $c) {
                $reply .= "• *{$c->title}* ({$c->duration_hours} hrs)\n";
                $reply .= "  👉 " . route('courses.show', $c->slug) . "\n\n";
            }
            $reply .= "Enroll for free today!";

            $this->whatsappService->sendTextMessage($phone, $reply, $user, 'bot_reply');
            return;
        }

        // 5. Default Help Menu
        $name = $user ? " " . $user->name : "";
        $helpMessage = "🤖 *Hello{$name}! I am your LMS Learning Assistant.*\n\n" .
            "You can reply with any of the following:\n\n" .
            "• *PROGRESS* — Check your enrolled courses & progress percentage\n" .
            "• *NEXT* — Get the link to your next video lesson\n" .
            "• *CERTIFICATE* — Access your digital badge & certificate link\n" .
            "• *COURSES* — Discover new courses\n\n" .
            "Visit the platform: " . route('home');

        $this->whatsappService->sendTextMessage($phone, $helpMessage, $user, 'bot_help');
    }
}
