<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Services\WhatsappService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LessonPlayerController extends Controller
{
    public function show(string $courseSlug, string $lessonSlug): View|RedirectResponse
    {
        $course = Course::with(['lessons.quiz'])->where('slug', $courseSlug)->firstOrFail();
        $lesson = $course->lessons()->where('slug', $lessonSlug)->firstOrFail();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ensure enrollment
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('courses.show', $course->slug)
                ->with('warning', 'Please enroll in this course to access the video lessons.');
        }

        // Sequential Access Check
        if (!$enrollment->canAccessLesson($lesson)) {
            return redirect()->route('student.dashboard')
                ->with('warning', 'Please complete the preceding lessons before unlocking this lesson.');
        }

        // Touch enrollment activity
        $enrollment->touchActivity();

        // Get progress for this lesson
        $progress = LessonProgress::firstOrCreate(
            ['enrollment_id' => $enrollment->id, 'lesson_id' => $lesson->id],
            ['is_completed' => false]
        );

        $allLessons = $course->lessons()->orderBy('sort_order', 'asc')->get();
        $completedLessonIds = $enrollment->lessonProgress()
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();

        $quiz = $lesson->quiz;
        $isQuizPassed = $quiz ? $quiz->isPassedBy($enrollment) : true;

        return view('student.lesson-player', compact(
            'course',
            'lesson',
            'enrollment',
            'progress',
            'allLessons',
            'completedLessonIds',
            'quiz',
            'isQuizPassed'
        ));
    }

    public function complete(string $courseSlug, string $lessonSlug, WhatsappService $whatsapp): RedirectResponse
    {
        $course = Course::with(['lessons.quiz', 'quizzes'])->where('slug', $courseSlug)->firstOrFail();
        $lesson = $course->lessons()->where('slug', $lessonSlug)->firstOrFail();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->firstOrFail();

        // Mark lesson progress completed
        LessonProgress::updateOrCreate(
            ['enrollment_id' => $enrollment->id, 'lesson_id' => $lesson->id],
            [
                'is_completed' => true,
                'watched_seconds' => $lesson->video_duration_minutes * 60,
                'completed_at' => now(),
            ]
        );

        $enrollment->touchActivity();

        // If this lesson has an attached quiz that is NOT yet passed, go straight to it
        if ($lesson->quiz && !$lesson->quiz->isPassedBy($enrollment)) {
            return redirect()->route('student.quiz.show', [$course->slug, $lesson->quiz->id])
                ->with('info', "Great job watching the lesson! Now complete the knowledge check to continue.");
        }

        // Check if there is a next lesson
        $nextLesson = $lesson->nextLesson();
        if ($nextLesson) {
            return redirect()->route('student.lesson.show', [$course->slug, $nextLesson->slug])
                ->with('success', "Lesson completed! Moving to next lesson: {$nextLesson->title}");
        }

        // All lessons done! Check for final course exam
        $finalExam = $course->finalExam();
        if ($finalExam && !$finalExam->isPassedBy($enrollment)) {
            return redirect()->route('student.quiz.show', [$course->slug, $finalExam->id])
                ->with('success', "You've finished all lessons! Pass the Final Certification Exam to get your badge.");
        }

        // All lessons + final exam completed: finalize course completion & certificate
        $this->awardCertificate($enrollment, $whatsapp);

        return redirect()->route('certificates.verify', $enrollment->certificate->share_token)
            ->with('success', "🎉 Congratulations! You have completed {$course->title} and earned your official Certificate and Badge!");
    }

    protected function awardCertificate(Enrollment $enrollment, WhatsappService $whatsapp): void
    {
        $enrollment->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        $certificate = Certificate::firstOrCreate(
            ['enrollment_id' => $enrollment->id],
            [
                'issued_at' => now(),
            ]
        );

        // Send WhatsApp congratulations
        $whatsapp->sendCompletionCongratulation($enrollment);
    }
}
