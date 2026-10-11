<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizController extends Controller
{
    /**
     * Display a listing of all quizzes.
     */
    public function index(Request $request): View
    {
        $courses = Course::with(['lessons' => function ($query) {
            $query->orderBy('sort_order');
        }])->orderBy('title')->get();

        $query = Quiz::with(['course', 'lesson'])
            ->withCount(['questions', 'attempts']);

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->integer('course_id'));
        }

        if ($request->filled('type')) {
            if ($request->input('type') === 'final_exam') {
                $query->whereNull('lesson_id');
            } elseif ($request->input('type') === 'lesson_quiz') {
                $query->whereNotNull('lesson_id');
            }
        }

        if ($request->filled('search')) {
            $searchTerm = '%'.$request->input('search').'%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm)
                    ->orWhereHas('course', function ($cq) use ($searchTerm) {
                        $cq->where('title', 'like', $searchTerm);
                    });
            });
        }

        $quizzes = $query->latest()->paginate(15)->withQueryString();

        return view('admin.quizzes.index', compact('quizzes', 'courses'));
    }

    /**
     * Show form to create a new quiz.
     */
    public function create(Request $request): View
    {
        $courses = Course::with(['lessons' => function ($query) {
            $query->orderBy('sort_order');
        }])->orderBy('title')->get();

        $selectedCourseId = $request->integer('course_id') ?: null;
        $selectedLessonId = $request->integer('lesson_id') ?: null;

        return view('admin.quizzes.create', compact('courses', 'selectedCourseId', 'selectedLessonId'));
    }

    /**
     * Store a newly created quiz.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'lesson_id' => ['nullable', 'exists:lessons,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'pass_percentage' => ['required', 'integer', 'min:1', 'max:100'],
            'time_limit_minutes' => ['nullable', 'integer', 'min:1', 'max:300'],
        ]);

        // If lesson_id is provided, verify it belongs to the selected course
        if (! empty($validated['lesson_id'])) {
            $lesson = Lesson::where('id', $validated['lesson_id'])
                ->where('course_id', $validated['course_id'])
                ->first();

            if (! $lesson) {
                return back()->withErrors(['lesson_id' => 'The selected lesson does not belong to this course.'])->withInput();
            }

            // Check if lesson already has a quiz
            $existing = Quiz::where('lesson_id', $lesson->id)->first();
            if ($existing) {
                return redirect()->route('admin.quizzes.builder', $existing->id)
                    ->with('info', 'This lesson already has a quiz. You can manage its questions here.');
            }
        }

        $quiz = Quiz::create([
            'course_id' => $validated['course_id'],
            'lesson_id' => ! empty($validated['lesson_id']) ? $validated['lesson_id'] : null,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'pass_percentage' => (int) $validated['pass_percentage'],
            'time_limit_minutes' => ! empty($validated['time_limit_minutes']) ? (int) $validated['time_limit_minutes'] : null,
        ]);

        return redirect()->route('admin.quizzes.builder', $quiz->id)
            ->with('success', "Quiz '{$quiz->title}' created successfully! Now you can add questions and answers.");
    }

    /**
     * Show the interactive Quiz & Questions Builder.
     */
    public function builder(Quiz $quiz): View
    {
        $quiz->load([
            'course',
            'lesson',
            'questions',
            'attempts',
        ]);

        $courses = Course::with(['lessons' => function ($query) {
            $query->orderBy('sort_order');
        }])->orderBy('title')->get();

        return view('admin.quizzes.builder', compact('quiz', 'courses'));
    }

    /**
     * Update quiz settings.
     */
    public function update(Request $request, Quiz $quiz): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'lesson_id' => ['nullable', 'exists:lessons,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'pass_percentage' => ['required', 'integer', 'min:1', 'max:100'],
            'time_limit_minutes' => ['nullable', 'integer', 'min:1', 'max:300'],
        ]);

        if (! empty($validated['lesson_id'])) {
            $lesson = Lesson::where('id', $validated['lesson_id'])
                ->where('course_id', $validated['course_id'])
                ->first();

            if (! $lesson) {
                return back()->withErrors(['lesson_id' => 'The selected lesson does not belong to this course.'])->withInput();
            }

            // Check if another quiz already occupies this lesson
            $existing = Quiz::where('lesson_id', $lesson->id)
                ->where('id', '!=', $quiz->id)
                ->first();

            if ($existing) {
                return back()->withErrors(['lesson_id' => 'Another quiz is already attached to this lesson.'])->withInput();
            }
        }

        $quiz->update([
            'course_id' => $validated['course_id'],
            'lesson_id' => ! empty($validated['lesson_id']) ? $validated['lesson_id'] : null,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'pass_percentage' => (int) $validated['pass_percentage'],
            'time_limit_minutes' => ! empty($validated['time_limit_minutes']) ? (int) $validated['time_limit_minutes'] : null,
        ]);

        return back()->with('success', 'Quiz settings updated successfully!');
    }

    /**
     * Delete a quiz and all associated questions & attempts.
     */
    public function destroy(Quiz $quiz): RedirectResponse
    {
        $title = $quiz->title;
        $quiz->delete();

        return redirect()->route('admin.quizzes.index')
            ->with('success', "Quiz '{$title}' and its questions were deleted successfully.");
    }

    /**
     * Store a new question with multiple-choice options and correct answer.
     */
    public function storeQuestion(Request $request, Quiz $quiz): RedirectResponse
    {
        $request->validate([
            'question' => ['required', 'string', 'max:2000'],
            'options' => ['required', 'array', 'min:2', 'max:10'],
            'options.*' => ['required', 'string', 'max:500'],
            'correct_answer_index' => ['required', 'integer', 'min:0'],
            'explanation' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:1'],
        ]);

        $options = array_values(array_filter($request->input('options', []), function ($val) {
            return trim((string) $val) !== '';
        }));

        if (count($options) < 2) {
            return back()->withErrors(['options' => 'Please provide at least 2 non-empty answer options.'])->withInput();
        }

        $correctIndex = (int) $request->input('correct_answer_index');
        if ($correctIndex < 0 || $correctIndex >= count($options)) {
            return back()->withErrors(['correct_answer_index' => 'Please select a valid correct answer from the provided options.'])->withInput();
        }

        $nextSortOrder = $request->filled('sort_order')
            ? (int) $request->input('sort_order')
            : (int) $quiz->questions()->max('sort_order') + 1;

        $quiz->questions()->create([
            'question' => $request->input('question'),
            'options' => $options,
            'correct_answer_index' => $correctIndex,
            'explanation' => $request->input('explanation') ?: null,
            'sort_order' => $nextSortOrder,
        ]);

        return back()->with('success', 'Question and answer options added successfully!');
    }

    /**
     * Update an existing question and its options.
     */
    public function updateQuestion(Request $request, Quiz $quiz, QuizQuestion $question): RedirectResponse
    {
        if ($question->quiz_id !== $quiz->id) {
            abort(404);
        }

        $request->validate([
            'question' => ['required', 'string', 'max:2000'],
            'options' => ['required', 'array', 'min:2', 'max:10'],
            'options.*' => ['required', 'string', 'max:500'],
            'correct_answer_index' => ['required', 'integer', 'min:0'],
            'explanation' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:1'],
        ]);

        $options = array_values(array_filter($request->input('options', []), function ($val) {
            return trim((string) $val) !== '';
        }));

        if (count($options) < 2) {
            return back()->withErrors(['options' => 'Please provide at least 2 non-empty answer options.'])->withInput();
        }

        $correctIndex = (int) $request->input('correct_answer_index');
        if ($correctIndex < 0 || $correctIndex >= count($options)) {
            return back()->withErrors(['correct_answer_index' => 'Please select a valid correct answer from the provided options.'])->withInput();
        }

        $sortOrder = $request->filled('sort_order')
            ? (int) $request->input('sort_order')
            : $question->sort_order;

        $question->update([
            'question' => $request->input('question'),
            'options' => $options,
            'correct_answer_index' => $correctIndex,
            'explanation' => $request->input('explanation') ?: null,
            'sort_order' => $sortOrder,
        ]);

        return back()->with('success', 'Question updated successfully!');
    }

    /**
     * Delete a question from a quiz.
     */
    public function destroyQuestion(Quiz $quiz, QuizQuestion $question): RedirectResponse
    {
        if ($question->quiz_id !== $quiz->id) {
            abort(404);
        }

        $question->delete();

        return back()->with('success', 'Question removed successfully.');
    }

    /**
     * View student attempts and scores for a quiz.
     */
    public function attempts(Quiz $quiz): View
    {
        $quiz->load(['course', 'lesson', 'questions']);

        $attempts = QuizAttempt::with(['enrollment.user'])
            ->where('quiz_id', $quiz->id)
            ->latest('attempted_at')
            ->paginate(20);

        return view('admin.quizzes.attempts', compact('quiz', 'attempts'));
    }
}
