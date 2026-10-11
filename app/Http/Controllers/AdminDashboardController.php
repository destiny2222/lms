<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\WhatsappMessage;
use App\Services\WhatsappService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalStudents = User::role('student')->count();
        $totalCourses = Course::count();
        $totalCertificates = Certificate::count();
        $totalWhatsappMessages = WhatsappMessage::count();

        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->latest()
            ->take(6)
            ->get();

        $recentCertificates = Certificate::with(['enrollment.user', 'enrollment.course'])
            ->latest()
            ->take(5)
            ->get();

        $recentWhatsapp = WhatsappMessage::with('user')
            ->latest()
            ->take(6)
            ->get();

        return view('dash.dashboard', compact(
            'totalStudents',
            'totalCourses',
            'totalCertificates',
            'totalWhatsappMessages',
            'recentEnrollments',
            'recentCertificates',
            'recentWhatsapp'
        ));
    }

    /**
     * WhatsApp Bot Control Center & Broadcast Center.
     */
    public function whatsapp(): View
    {
        $messages = WhatsappMessage::with('user')
            ->latest()
            ->paginate(15);

        $students = User::role('student')->whereNotNull('phone')->get();
        $courses = Course::where('status', 'published')->get();

        $stats = [
            'total' => WhatsappMessage::count(),
            'outbound' => WhatsappMessage::where('direction', 'outbound')->count(),
            'inbound' => WhatsappMessage::where('direction', 'inbound')->count(),
            'reminders' => WhatsappMessage::whereIn('trigger_type', ['reminder_unstarted', 'reminder_incomplete'])->count(),
        ];

        return view('admin.whatsapp.index', compact('messages', 'students', 'courses', 'stats'));
    }

    /**
     * Send Bulk WhatsApp Message / Announcement.
     */
    public function sendBulkWhatsapp(Request $request, WhatsappService $whatsapp): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:1000'],
            'recipient_group' => ['required', 'in:all_students,course_students,custom_number'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'custom_phone' => ['nullable', 'string'],
        ]);

        if ($validated['recipient_group'] === 'custom_number') {
            if (empty($validated['custom_phone'])) {
                return back()->with('error', 'Please enter a valid phone number for direct test message.');
            }
            $whatsapp->sendTextMessage(
                $validated['custom_phone'],
                '📢 *'.($validated['title'] ?? 'LMS Notice')."*\n\n".$validated['message'],
                null,
                'bulk_announcement'
            );

            return back()->with('success', "Test WhatsApp message sent to {$validated['custom_phone']}.");
        }

        if ($validated['recipient_group'] === 'course_students' && ! empty($validated['course_id'])) {
            $users = User::whereHas('enrollments', function ($q) use ($validated) {
                $q->where('course_id', $validated['course_id']);
            })->whereNotNull('phone')->get();
        } else {
            $users = User::role('student')->whereNotNull('phone')->get();
        }

        if ($users->isEmpty()) {
            return back()->with('warning', 'No students found with registered phone numbers in this group.');
        }

        $sentCount = $whatsapp->sendBulkAnnouncement($users, $validated['message'], $validated['title'] ?? null);

        return back()->with('success', "Broadcast successfully queued and dispatched to {$sentCount} students via WhatsApp!");
    }

    /**
     * Trigger automated reminder routine manually.
     */
    public function triggerReminders(): RedirectResponse
    {
        Artisan::call('lms:send-whatsapp-reminders');
        $output = Artisan::output();

        return back()->with('success', 'Automated WhatsApp follow-up cycle executed! '.trim($output));
    }
}
