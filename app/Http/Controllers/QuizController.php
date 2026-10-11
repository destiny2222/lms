<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use App\Services\RewardService;
use App\Services\WhatsappService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class QuizController extends Controller
{
    public function show(string $courseSlug, int $quizId): View|RedirectResponse
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $quiz = Quiz::with(['questions', 'lesson'])->where('course_id', $course->id)->findOrFail($quizId);

        /** @var User $user */
        $user = Auth::user();

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (! $enrollment) {
            return redirect()->route('courses.show', $course->slug)
                ->with('warning', 'Please enroll in this course first.');
        }

        $enrollment->touchActivity();

        $previousAttempts = QuizAttempt::where('enrollment_id', $enrollment->id)
            ->where('quiz_id', $quiz->id)
            ->latest()
            ->get();

        $isPassed = $previousAttempts->where('is_passed', true)->isNotEmpty();

        return view('student.quiz', compact('course', 'quiz', 'enrollment', 'previousAttempts', 'isPassed'));
    }

    public function submit(Request $request, string $courseSlug, int $quizId, WhatsappService $whatsapp, RewardService $rewardService): RedirectResponse
    {
        $course = Course::with(['lessons', 'quizzes'])->where('slug', $courseSlug)->firstOrFail();
        $quiz = Quiz::with(['questions'])->where('course_id', $course->id)->findOrFail($quizId);

        /** @var User $user */
        $user = Auth::user();

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $submittedAnswers = $request->input('answers', []);
        $totalQuestions = $quiz->questions->count();
        $correctCount = 0;

        foreach ($quiz->questions as $question) {
            $userChoice = $submittedAnswers[$question->id] ?? null;
            if ($userChoice !== null && (int) $userChoice === (int) $question->correct_answer_index) {
                $correctCount++;
            }
        }

        $scorePercentage = $totalQuestions > 0 ? (int) round(($correctCount / $totalQuestions) * 100) : 100;
        $isPassed = $scorePercentage >= $quiz->pass_percentage;

        // Save Attempt
        QuizAttempt::create([
            'enrollment_id' => $enrollment->id,
            'quiz_id' => $quiz->id,
            'score_percentage' => $scorePercentage,
            'is_passed' => $isPassed,
            'answers' => $submittedAnswers,
            'attempted_at' => now(),
        ]);

        $enrollment->touchActivity();

        if (! $isPassed) {
            return back()->with('error', "You scored {$scorePercentage}% (Needed: {$quiz->pass_percentage}%). Review the lessons and try again!");
        }

        // Passed! If this is the final exam or all lessons are completed:
        $isFinalExam = is_null($quiz->lesson_id);
        $allLessonsCompleted = $enrollment->progress_percentage >= 100;

        if ($isFinalExam || $allLessonsCompleted) {
            $enrollment->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            $certificate = Certificate::firstOrCreate(
                ['enrollment_id' => $enrollment->id],
                ['issued_at' => now()]
            );

            // Send celebration via WhatsApp
            $whatsapp->sendCompletionCongratulation($enrollment);

            // Check if student unlocked 10-badge milestone reward
            $rewardService->checkAndUnlockMilestone($enrollment->user);

            return redirect()->route('certificates.verify', $certificate->share_token)
                ->with('success', "🎉 Outstanding! You passed with {$scorePercentage}% and earned your official Certification Badge!");
        }

        // Passed intermediate test along the way
        if ($quiz->lesson) {
            $nextLesson = $quiz->lesson->nextLesson();
            if ($nextLesson) {
                return redirect()->route('student.lesson.show', [$course->slug, $nextLesson->slug])
                    ->with('success', "Passed with {$scorePercentage}%! Proceeding to next lesson.");
            }
        }

        return redirect()->route('student.dashboard')
            ->with('success', "Congratulations! Quiz passed with {$scorePercentage}%.");
    }
}
