<?php

namespace App\Services;

use App\Models\Course;
use App\Models\DataReward;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\WhatsappMessage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    protected ?string $token;

    protected ?string $phoneNumberId;

    protected string $apiVersion;

    public function __construct()
    {
        $this->token = config('services.meta.whatsapp_token', env('META_WHATSAPP_TOKEN'));
        $this->phoneNumberId = config('services.meta.whatsapp_phone_number_id', env('META_WHATSAPP_PHONE_NUMBER_ID'));
        $this->apiVersion = config('services.meta.api_version', env('META_WHATSAPP_API_VERSION', 'v21.0'));
    }

    /**
     * Send a direct text message to a WhatsApp number.
     */
    public function sendTextMessage(string $phone, string $body, ?User $user = null, string $triggerType = 'system'): WhatsappMessage
    {
        $formattedPhone = $this->formatPhoneNumber($phone);

        $whatsappMsg = WhatsappMessage::create([
            'user_id' => $user?->id,
            'direction' => 'outbound',
            'phone_number' => $formattedPhone,
            'message_type' => 'text',
            'message_body' => $body,
            'trigger_type' => $triggerType,
            'status' => 'queued',
        ]);

        if (empty($this->token) || empty($this->phoneNumberId)) {
            // Live credentials not set yet — log and record as sent for seamless dev/testing
            Log::info("[WhatsApp Bot (Simulated)] Outbound to {$formattedPhone}: {$body}");
            $whatsappMsg->update([
                'status' => 'sent',
                'meta_message_id' => 'sim_'.uniqid(),
            ]);

            return $whatsappMsg;
        }

        try {
            $response = Http::withToken($this->token)
                ->post("https://graph.facebook.com/{$this->apiVersion}/{$this->phoneNumberId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'recipient_type' => 'individual',
                    'to' => $formattedPhone,
                    'type' => 'text',
                    'text' => [
                        'preview_url' => true,
                        'body' => $body,
                    ],
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $metaMsgId = $data['messages'][0]['id'] ?? null;
                $whatsappMsg->update([
                    'status' => 'sent',
                    'meta_message_id' => $metaMsgId,
                ]);
            } else {
                Log::error('[WhatsApp Bot] Meta API Error: '.$response->body());
                $whatsappMsg->update([
                    'status' => 'failed',
                    'error_message' => $response->body(),
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('[WhatsApp Bot] Exception: '.$e->getMessage());
            $whatsappMsg->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }

        return $whatsappMsg;
    }

    /**
     * Send interactive message with quick reply action buttons.
     */
    public function sendInteractiveButtons(string $phone, string $bodyText, array $buttons, ?User $user = null, string $triggerType = 'bot_action'): WhatsappMessage
    {
        $formattedPhone = $this->formatPhoneNumber($phone);

        $whatsappMsg = WhatsappMessage::create([
            'user_id' => $user?->id,
            'direction' => 'outbound',
            'phone_number' => $formattedPhone,
            'message_type' => 'interactive',
            'message_body' => $bodyText,
            'trigger_type' => $triggerType,
            'status' => 'queued',
        ]);

        if (empty($this->token) || empty($this->phoneNumberId)) {
            Log::info("[WhatsApp Bot (Simulated Buttons)] Outbound to {$formattedPhone}: {$bodyText} | Buttons: ".json_encode($buttons));
            $whatsappMsg->update([
                'status' => 'sent',
                'meta_message_id' => 'sim_'.uniqid(),
            ]);

            return $whatsappMsg;
        }

        try {
            $formattedButtons = [];
            foreach (array_slice($buttons, 0, 3) as $btn) {
                $formattedButtons[] = [
                    'type' => 'reply',
                    'reply' => [
                        'id' => $btn['id'],
                        'title' => mb_substr($btn['title'], 0, 20),
                    ],
                ];
            }

            $response = Http::withToken($this->token)
                ->post("https://graph.facebook.com/{$this->apiVersion}/{$this->phoneNumberId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'recipient_type' => 'individual',
                    'to' => $formattedPhone,
                    'type' => 'interactive',
                    'interactive' => [
                        'type' => 'button',
                        'body' => ['text' => $bodyText],
                        'action' => ['buttons' => $formattedButtons],
                    ],
                ]);

            if ($response->successful()) {
                $whatsappMsg->update([
                    'status' => 'sent',
                    'meta_message_id' => $response->json()['messages'][0]['id'] ?? null,
                ]);
            } else {
                $whatsappMsg->update([
                    'status' => 'failed',
                    'error_message' => $response->body(),
                ]);
            }
        } catch (\Throwable $e) {
            $whatsappMsg->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }

        return $whatsappMsg;
    }

    /**
     * Send Course Enrollment Welcome reminder.
     */
    public function sendEnrollmentWelcome(Enrollment $enrollment): void
    {
        $user = $enrollment->user;
        if (empty($user->phone) || ! $user->whatsapp_opted_in) {
            return;
        }

        $course = $enrollment->course;
        $firstLesson = $course->lessons()->orderBy('sort_order', 'asc')->first();
        $lessonUrl = $firstLesson ? route('student.lesson.show', [$course->slug, $firstLesson->slug]) : route('student.dashboard');

        $message = "👋 Hello {$user->name}!\n\n".
            "🎉 You have successfully enrolled in *{$course->title}*!\n\n".
            "Ready to start? Lesson 1 is waiting for you:\n".
            "👉 {$lessonUrl}\n\n".
            "💡 Remember: Watch the lessons, pass the quizzes, and claim your verified Certificate of Completion & Digital Badge!\n\n".
            'I will be your personal learning accountability bot. Reply *PROGRESS* anytime to check your status.';

        $this->sendTextMessage($user->phone, $message, $user, 'welcome_enrollment');
    }

    /**
     * Send reminder for student who hasn't started their enrolled course.
     */
    public function sendUnstartedReminder(Enrollment $enrollment): void
    {
        $user = $enrollment->user;
        if (empty($user->phone) || ! $user->whatsapp_opted_in) {
            return;
        }

        $course = $enrollment->course;
        $firstLesson = $course->lessons()->orderBy('sort_order', 'asc')->first();
        $lessonUrl = $firstLesson ? route('student.lesson.show', [$course->slug, $firstLesson->slug]) : route('student.dashboard');

        $message = "⏰ Friendly Reminder, {$user->name}!\n\n".
            "You enrolled in *{$course->title}* but haven't started watching yet.\n\n".
            "Invest just 15 minutes today to jump into Lesson 1:\n".
            "▶️ {$lessonUrl}\n\n".
            'Stay consistent, achieve your certificate! 🎓';

        $this->sendTextMessage($user->phone, $message, $user, 'reminder_unstarted');

        $enrollment->increment('reminder_count');
        $enrollment->update(['last_reminded_at' => now()]);
    }

    /**
     * Send reminder for student who has been inactive or has lessons remaining.
     */
    public function sendIncompleteReminder(Enrollment $enrollment): void
    {
        $user = $enrollment->user;
        if (empty($user->phone) || ! $user->whatsapp_opted_in) {
            return;
        }

        $course = $enrollment->course;
        $progress = $enrollment->progress_percentage;

        // Find the next incomplete lesson
        $nextLesson = $course->lessons()
            ->whereNotIn('id', function ($query) use ($enrollment) {
                $query->select('lesson_id')
                    ->from('lesson_progress')
                    ->where('enrollment_id', $enrollment->id)
                    ->where('is_completed', true);
            })
            ->orderBy('sort_order', 'asc')
            ->first();

        $targetUrl = $nextLesson
            ? route('student.lesson.show', [$course->slug, $nextLesson->slug])
            : route('student.dashboard');

        $message = "🚀 Keep Going, {$user->name}!\n\n".
            "You are already *{$progress}% done* with *{$course->title}*!\n\n".
            "Don't lose momentum. Continue your next lesson today:\n".
            "👉 {$targetUrl}\n\n".
            'You are just a few steps away from your official Certification Badge! 🏅';

        $this->sendTextMessage($user->phone, $message, $user, 'reminder_incomplete');

        $enrollment->increment('reminder_count');
        $enrollment->update(['last_reminded_at' => now()]);
    }

    /**
     * Send Course Completion & Certification Badge Congratulation message.
     */
    public function sendCompletionCongratulation(Enrollment $enrollment): void
    {
        $user = $enrollment->user;
        if (empty($user->phone) || ! $user->whatsapp_opted_in) {
            return;
        }

        $certificate = $enrollment->certificate;
        $certUrl = $certificate ? route('certificates.verify', $certificate->share_token) : route('student.dashboard');

        $message = "🎊 CONGRATULATIONS, {$user->name}! 🏆\n\n".
            "You have officially completed *{$enrollment->course->title}* and passed your certification exam!\n\n".
            "📜 Certificate Number: *{$certificate?->certificate_number}*\n".
            "🎖️ View, download and share your official digital badge on LinkedIn & X:\n".
            "👉 {$certUrl}\n\n".
            'Proud of your dedication! Share it with your network! 🌟';

        $this->sendTextMessage($user->phone, $message, $user, 'congratulation');
    }

    /**
     * Send Bulk Announcement to multiple students/users.
     */
    public function sendBulkAnnouncement(Collection $users, string $announcementText, ?string $announcementTitle = null): int
    {
        $count = 0;
        foreach ($users as $user) {
            if (! empty($user->phone) && $user->whatsapp_opted_in) {
                $personalized = '📢 *Announcement: '.($announcementTitle ?? 'LMS Notice')."*\n\n".
                    "Hello {$user->name},\n\n".
                    $announcementText."\n\n".
                    '— LMS Administration Team';

                $this->sendTextMessage($user->phone, $personalized, $user, 'bulk_announcement');
                $count++;
            }
        }

        return $count;
    }

    /**
     * Send celebration when student reaches 10 badges milestone unlocking 1 Month Free Data Subscription.
     */
    public function sendDataMilestoneUnlocked(User $user, DataReward $reward): void
    {
        if (empty($user->phone) || ! $user->whatsapp_opted_in) {
            return;
        }

        $claimUrl = route('student.dashboard');

        $message = "🏆 EXTRAORDINARY ACHIEVEMENT, {$user->name}! 🌟\n\n".
            "You have completed *10 courses* and earned *10 Verified Digital Badges*!\n\n".
            "🎁 As a reward for your relentless learning, you have unlocked:\n".
            "*1 MONTH FREE DATA SUBSCRIPTION* 📶⚡\n\n".
            "Claim your mobile data reward now:\n".
            "👉 {$claimUrl}\n\n".
            'Select your preferred network (MTN, Airtel, Glo, or 9mobile) and enter your phone number to get credited! 🚀';

        $this->sendTextMessage($user->phone, $message, $user, 'milestone_reward_unlocked');
    }

    /**
     * Send confirmation when admin fulfills/credits the student's 1-month data subscription.
     */
    public function sendDataRewardFulfilled(DataReward $reward): void
    {
        $user = $reward->user;
        $targetPhone = $reward->phone_number ?? $user->phone;

        if (empty($targetPhone) || ! $user->whatsapp_opted_in) {
            return;
        }

        $notes = $reward->admin_notes ? "\nReference / Note: *{$reward->admin_notes}*\n" : '';

        $message = "🎉 BOOM! YOUR FREE DATA IS READY, {$user->name}! 📲⚡\n\n".
            "Your *1 Month Free Data Subscription* has been credited!\n\n".
            "📡 Network: *{$reward->network_provider}*\n".
            "📱 Phone Number: *{$reward->phone_number}*{$notes}\n\n".
            'Thank you for being an exceptional learner. Keep acquiring skills and breaking boundaries! 🎓✨';

        $this->sendTextMessage($targetPhone, $message, $user, 'milestone_reward_fulfilled');
    }

    /**
     * Standardize phone number format for WhatsApp (E.164, without leading plus or symbols).
     */
    public function formatPhoneNumber(string $phone): string
    {
        $cleaned = preg_replace('/[^0-9]/', '', $phone);

        // If number begins with 0 and is 11 digits (e.g. Nigerian / UK local), assume international prefix or keep as is
        return $cleaned;
    }
}
