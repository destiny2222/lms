<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of all disciples and students.
     */
    public function index(Request $request): View
    {
        $courses = Course::orderBy('title')->get();

        $query = User::with([
            'enrollments.course',
            'enrollments.certificate',
        ])->withCount(['enrollments']);

        // Search by name, email, or phone
        if ($request->filled('search')) {
            $term = '%'.$request->input('search').'%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('phone', 'like', $term);
            });
        }

        // Filter by course
        if ($request->filled('course_id')) {
            $courseId = $request->integer('course_id');
            $query->whereHas('enrollments', function ($q) use ($courseId) {
                $q->where('course_id', $courseId);
            });
        }

        // Filter by status (active learners, completed graduates, certified)
        if ($request->filled('filter')) {
            if ($request->input('filter') === 'completed') {
                $query->whereHas('enrollments', fn ($q) => $q->where('status', 'completed'));
            } elseif ($request->input('filter') === 'certified') {
                $query->whereHas('enrollments.certificate');
            } elseif ($request->input('filter') === 'in_progress') {
                $query->whereHas('enrollments', fn ($q) => $q->where('status', 'enrolled'));
            }
        }

        $students = $query->latest()->paginate(15)->withQueryString();

        // Calculate KPI stats
        $stats = [
            'total_students' => User::count(),
            'active_enrolled' => User::whereHas('enrollments')->count(),
            'graduates' => User::whereHas('enrollments', fn ($q) => $q->where('status', 'completed'))->count(),
            'total_enrollments' => Enrollment::count(),
        ];

        return view('admin.students.index', compact('students', 'courses', 'stats'));
    }

    /**
     * Display the specified student's full learning profile.
     */
    public function show(User $user): View
    {
        $user->load([
            'enrollments.course.lessons',
            'enrollments.certificate',
            'enrollments.quizAttempts.quiz',
            'enrollments.lessonProgress',
        ]);

        return view('admin.students.show', compact('user'));
    }
}
