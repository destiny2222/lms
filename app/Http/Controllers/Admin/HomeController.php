<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\WhatsappMessage;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the Admin Dashboard overview.
     */
    public function index(): View
    {
        $stats = [
            'total_students' => User::count(),
            'total_courses' => Course::count(),
            'total_enrollments' => Enrollment::count(),
            'total_certificates' => Certificate::count(),
            'whatsapp_messages' => WhatsappMessage::count(),
        ];

        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->latest()
            ->limit(8)
            ->get();

        $recentCourses = Course::withCount(['enrollments', 'lessons'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.index', compact('stats', 'recentEnrollments', 'recentCourses'));
    }
}
