<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use App\Models\QuizAttempt;
use App\Models\User;
use App\Services\RewardService;
use App\Services\WhatsappService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StudentDashboardController extends Controller
{
    public function index(RewardService $rewardService): View
    {
        /** @var User $user */
        $user = Auth::user();

        $enrollments = Enrollment::with([
            'course.lessons.quiz',
            'course.quizzes',
            'certificate',
            'lessonProgress',
            'quizAttempts.quiz',
        ])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $completedCount = $enrollments->where('status', 'completed')->count();
        $inProgressCount = $enrollments->where('status', '!=', 'completed')->count();
        $certificates = $enrollments->pluck('certificate')->filter();

        $milestoneProgress = $rewardService->getMilestoneProgress($user);

        $totalLessons = $enrollments->sum(fn ($e) => $e->course->lessons->count());
        $completedLessons = $enrollments->sum(fn ($e) => $e->completedLessonsCount());
        $overallProgress = $totalLessons > 0 ? (int) round(($completedLessons / $totalLessons) * 100) : 0;

        $quizAttempts = QuizAttempt::whereHas('enrollment', fn ($q) => $q->where('user_id', $user->id))->get();
        $averageQuizScore = $quizAttempts->isNotEmpty() ? (int) round($quizAttempts->avg('score_percentage')) : 0;
        $passedQuizzesCount = $quizAttempts->where('is_passed', true)->count();

        // 7-day study activity trend
        $activityDays = collect(range(6, 0))->map(function ($daysAgo) use ($user) {
            $date = now()->subDays($daysAgo)->toDateString();
            $count = LessonProgress::whereHas('enrollment', fn ($q) => $q->where('user_id', $user->id))
                ->whereDate('completed_at', $date)
                ->where('is_completed', true)
                ->count();

            return [
                'day' => now()->subDays($daysAgo)->format('D'),
                'count' => $count,
            ];
        });

        $enrolledCourseIds = $enrollments->pluck('course_id');
        $availableCourses = Course::where('status', 'published')
            ->whereNotIn('id', $enrolledCourseIds)
            ->take(3)
            ->get();

        $courseAnalysis = $enrollments->map(function ($enrollment) {
            $course = $enrollment->course;
            $progress = $enrollment->progressPercentage();
            $quizAttempts = $enrollment->quizAttempts;
            $quizAvg = $quizAttempts->isNotEmpty() ? (int) round($quizAttempts->avg('score_percentage')) : 0;

            return [
                'id' => $enrollment->id,
                'title' => Str::limit($course->title, 20),
                'full_title' => $course->title,
                'progress' => $progress,
                'quiz_avg' => $quizAvg,
                'status' => $enrollment->status,
                'has_certificate' => ! is_null($enrollment->certificate),
                'certificate_token' => $enrollment->certificate?->share_token,
                'certificate_number' => $enrollment->certificate?->certificate_number,
            ];
        });

        return view('student.dashboard', compact(
            'user',
            'enrollments',
            'completedCount',
            'inProgressCount',
            'certificates',
            'milestoneProgress',
            'totalLessons',
            'completedLessons',
            'overallProgress',
            'averageQuizScore',
            'passedQuizzesCount',
            'activityDays',
            'availableCourses',
            'courseAnalysis'
        ));
    }

    public function myCourses(Request $request): View
    {
        /** @var User $user */
        $user = Auth::user();

        $query = Enrollment::with([
            'course.lessons.quiz',
            'course.tutor',
            'certificate',
            'lessonProgress',
        ])
            ->where('user_id', $user->id);

        $filter = $request->get('filter', 'all');
        if ($filter === 'completed') {
            $query->where('status', 'completed');
        } elseif ($filter === 'in_progress') {
            $query->where('status', '!=', 'completed');
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('course', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('subtitle', 'like', "%{$search}%");
            });
        }

        $enrollments = $query->latest()->paginate(9)->withQueryString();

        $allEnrollments = Enrollment::where('user_id', $user->id)->get();
        $totalCount = $allEnrollments->count();
        $completedCount = $allEnrollments->where('status', 'completed')->count();
        $inProgressCount = $totalCount - $completedCount;
        $totalCertificates = Certificate::whereHas('enrollment', fn ($q) => $q->where('user_id', $user->id))->count();

        return view('student.my-courses', compact(
            'enrollments',
            'totalCount',
            'completedCount',
            'inProgressCount',
            'totalCertificates',
            'filter'
        ));
    }

    public function catalog(Request $request): View
    {
        $query = Course::with(['tutor', 'lessons', 'enrollments'])
            ->where('status', 'published');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('subtitle', 'like', "%{$search}%");
            });
        }

        if ($request->filled('level') && $request->input('level') !== 'all') {
            $query->where('level', $request->input('level'));
        }

        $courses = $query->latest()->paginate(9)->withQueryString();

        return view('frontend.courses', compact('courses'));
    }

    public function courseDetail(string $slug): View
    {
        $course = Course::with(['tutor', 'lessons.quiz', 'quizzes', 'enrollments'])
            ->where('slug', $slug)
            ->firstOrFail();

        $enrollment = Auth::check()
            ? Enrollment::where('user_id', Auth::id())->where('course_id', $course->id)->first()
            : null;

        $relatedCourses = Course::with(['tutor', 'lessons', 'enrollments'])
            ->where('id', '!=', $course->id)
            ->where('status', 'published')
            ->take(6)
            ->get();

        return view('frontend.course-detail', compact('course', 'enrollment', 'relatedCourses'));
    }

    public function enroll(Course $course, WhatsappService $whatsapp): RedirectResponse
    {
        /** @var User $user */
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
