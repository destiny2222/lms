<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Services\WhatsappService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StudentDashboardController extends Controller
{
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $enrollments = Enrollment::with(['course.lessons', 'certificate'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $completedCount = $enrollments->where('status', 'completed')->count();
        $inProgressCount = $enrollments->where('status', '!=', 'completed')->count();
        $certificates = $enrollments->pluck('certificate')->filter();

        return view('student.dashboard', compact('user', 'enrollments', 'completedCount', 'inProgressCount', 'certificates'));
    }

    public function catalog(): View
    {
        $courses = Course::with(['tutor', 'lessons'])
            ->where('status', 'published')
            ->latest()
            ->paginate(9);

        return view('frontend.courses', compact('courses'));
    }

    public function courseDetail(string $slug): View
    {
        $course = Course::with(['tutor', 'lessons.quiz', 'quizzes'])
            ->where('slug', $slug)
            ->firstOrFail();

        $enrollment = Auth::check()
            ? Enrollment::where('user_id', Auth::id())->where('course_id', $course->id)->first()
            : null;

        return view('frontend.course-detail', compact('course', 'enrollment'));
    }

    public function enroll(Course $course, WhatsappService $whatsapp): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $enrollment = Enrollment::firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $course->id,
            ],
            [
                'enrolled_at' => now(),
                'deadline_at' => now()->addDays(30),
                'status' => 'enrolled',
            ]
        );

        // Trigger WhatsApp welcome message
        $whatsapp->sendEnrollmentWelcome($enrollment);

        $firstLesson = $course->lessons()->orderBy('sort_order', 'asc')->first();

        if ($firstLesson) {
            return redirect()->route('student.lesson.show', [$course->slug, $firstLesson->slug])
                ->with('success', "Enrolled in {$course->title}! Let's start with Lesson 1.");
        }

        return redirect()->route('student.dashboard')
            ->with('success', "Enrolled in {$course->title}!");
    }
}
