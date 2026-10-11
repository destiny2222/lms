@extends('layouts.admin')

@section('page_title', 'Quizzes & Assessments')

@section('content')
<div class="container-fluid p-0">

    <!-- Top Page Header matching Larkon Breadcrumb / Title Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-0 text-uppercase" style="letter-spacing: 0.6px; font-size: 1.15rem;">Quizzes &amp; Assessments</h4>
            <p class="text-muted text-xs mb-0">Create and manage multiple-choice questions, passing scores, and answer keys</p>
        </div>
        <div class="text-sm text-muted">
            <span class="text-secondary fw-medium">Admin</span> &bull; <span class="text-primary fw-semibold">Quizzes</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert" style="background-color: #ecfdf5; color: #065f46;">
            <i class="ri-checkbox-circle-fill fs-5 text-success"></i>
            <div class="fw-medium text-sm">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="ri-information-fill fs-5 text-info"></i>
            <div class="fw-medium text-sm">{{ session('info') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Top Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Total Quizzes</span>
                    <div class="w-8 h-8 rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-questionnaire-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ \App\Models\Quiz::count() }}</h3>
                <span class="text-muted text-xs mt-1 d-block">Configured in curriculum</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Total Questions</span>
                    <div class="w-8 h-8 rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-question-answer-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ \App\Models\QuizQuestion::count() }}</h3>
                <span class="text-muted text-xs mt-1 d-block">Questions with answer keys</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Student Attempts</span>
                    <div class="w-8 h-8 rounded-circle bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-user-follow-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ \App\Models\QuizAttempt::count() }}</h3>
                <span class="text-muted text-xs mt-1 d-block">Recorded submissions</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Pass Rate</span>
                    <div class="w-8 h-8 rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-checkbox-circle-line fs-5"></i>
                    </div>
                </div>
                @php
                    $totalAttempts = \App\Models\QuizAttempt::count();
                    $passedAttempts = \App\Models\QuizAttempt::where('is_passed', true)->count();
                    $rate = $totalAttempts > 0 ? round(($passedAttempts / $totalAttempts) * 100) : 100;
                @endphp
                <h3 class="fw-bold text-dark mb-0">{{ $rate }}%</h3>
                <span class="text-muted text-xs mt-1 d-block">{{ $passedAttempts }} passed attempts</span>
            </div>
        </div>
    </div>

    <!-- Main Card matching Larkon "All Product List" -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white larkon-main-card">
        
        <!-- Card Header: Title + Create Button + Filters -->
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <h5 class="fw-bold text-dark mb-0 fs-16">All Quizzes List</h5>
                <span class="badge bg-light text-muted border text-xs px-2 py-1 rounded-pill">{{ $quizzes->total() }} Total</span>
            </div>
            
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <!-- Search and Filters -->
                <form method="GET" action="{{ route('admin.quizzes.index') }}" class="d-flex align-items-center gap-2 flex-wrap m-0">
                    <div class="input-group input-group-sm" style="width: 220px;">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="ri-search-line"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Search quiz..." value="{{ request('search') }}">
                    </div>

                    <select name="course_id" class="form-select form-select-sm bg-light" style="width: 180px;" onchange="this.form.submit()">
                        <option value="">All Courses</option>
                        @foreach($courses as $c)
                            <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>
                                {{ Str::limit($c->title, 25) }}
                            </option>
                        @endforeach
                    </select>

                    <select name="type" class="form-select form-select-sm bg-light" style="width: 150px;" onchange="this.form.submit()">
                        <option value="">All Scopes</option>
                        <option value="final_exam" {{ request('type') == 'final_exam' ? 'selected' : '' }}>Final Exams</option>
                        <option value="lesson_quiz" {{ request('type') == 'lesson_quiz' ? 'selected' : '' }}>Lesson Quizzes</option>
                    </select>

                    @if(request()->anyFilled(['search', 'course_id', 'type']))
                        <a href="{{ route('admin.quizzes.index') }}" class="btn btn-sm btn-outline-secondary" title="Clear Filters">
                            <i class="ri-refresh-line"></i>
                        </a>
                    @endif
                </form>

                <!-- Create Quiz Button triggering Modal -->
                <button type="button" class="btn btn-larkon-add shadow-sm" data-bs-toggle="modal" data-bs-target="#createQuizModal">
                    <i class="ri-add-line fs-5"></i> Create Quiz
                </button>
            </div>
        </div>

        <!-- Table Responsive Container -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 larkon-table">
                <thead>
                    <tr>
                        <th style="min-width: 260px;" class="ps-4">Quiz Title &amp; Details</th>
                        <th style="min-width: 220px;">Attached Curriculum</th>
                        <th style="min-width: 120px;" class="text-center">Questions</th>
                        <th style="min-width: 130px;">Pass Standard</th>
                        <th style="min-width: 120px;">Time Limit</th>
                        <th style="min-width: 120px;" class="text-center">Attempts</th>
                        <th style="min-width: 140px;" class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quizzes as $quiz)
                        <tr>
                            <!-- Title & Description -->
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="w-10 h-10 rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px;">
                                        <i class="ri-questionnaire-fill fs-5"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.quizzes.builder', $quiz->id) }}" class="fw-semibold text-dark text-decoration-none d-block mb-0.5 text-truncate" style="max-width: 280px;" title="{{ $quiz->title }}">
                                            {{ $quiz->title }}
                                        </a>
                                        @if($quiz->description)
                                            <span class="text-muted text-xs d-block text-truncate" style="max-width: 280px;">{{ $quiz->description }}</span>
                                        @else
                                            <span class="text-muted text-xs d-block italic">No description</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Attached Curriculum -->
                            <td>
                                <div class="min-w-0">
                                    <a href="{{ route('admin.courses.lessons', $quiz->course_id) }}" class="text-dark fw-medium text-xs d-block text-truncate" style="max-width: 240px;">
                                        <i class="ri-book-2-line text-primary me-1"></i>{{ $quiz->course->title ?? 'Course deleted' }}
                                    </a>
                                    @if($quiz->lesson)
                                        <span class="badge bg-light text-secondary border rounded-pill px-2 py-0.5 text-xs mt-1 d-inline-block">
                                            <i class="ri-play-circle-line me-1"></i> Lesson: {{ Str::limit($quiz->lesson->title, 25) }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2 py-0.5 text-xs mt-1 d-inline-block">
                                            <i class="ri-award-fill me-1"></i> Course Final Exam
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Questions Count -->
                            <td class="text-center">
                                <a href="{{ route('admin.quizzes.builder', $quiz->id) }}" class="badge {{ $quiz->questions_count > 0 ? 'bg-primary-subtle text-primary border border-primary-subtle' : 'bg-danger-subtle text-danger' }} rounded-pill px-2.5 py-1 text-decoration-none fw-semibold">
                                    {{ $quiz->questions_count }} {{ Str::plural('Question', $quiz->questions_count) }}
                                </a>
                            </td>

                            <!-- Pass Standard -->
                            <td>
                                <div class="fw-semibold text-dark fs-13">{{ $quiz->pass_percentage }}%</div>
                                <span class="text-muted text-xs d-block">Passing Score</span>
                            </td>

                            <!-- Time Limit -->
                            <td>
                                @if($quiz->time_limit_minutes)
                                    <span class="text-dark fs-13 fw-medium"><i class="ri-timer-line text-secondary me-1"></i>{{ $quiz->time_limit_minutes }} mins</span>
                                @else
                                    <span class="text-muted text-xs">No time limit</span>
                                @endif
                            </td>

                            <!-- Student Attempts -->
                            <td class="text-center">
                                <a href="{{ route('admin.quizzes.attempts', $quiz->id) }}" class="badge bg-light text-secondary border rounded-pill px-2.5 py-1 text-decoration-none">
                                    {{ $quiz->attempts_count }} {{ Str::plural('Attempt', $quiz->attempts_count) }}
                                </a>
                            </td>

                            <!-- Actions -->
                            <td class="text-end pe-4">
                                <div class="d-inline-flex align-items-center gap-2">
                                    <!-- 1. Builder / Manage Questions -->
                                    <a href="{{ route('admin.quizzes.builder', $quiz->id) }}" class="quiz-action-btn quiz-action-builder" title="Setup Questions & Answer Keys">
                                        <i class="ri-list-check-3"></i>
                                    </a>

                                    <!-- 2. View Attempts -->
                                    <a href="{{ route('admin.quizzes.attempts', $quiz->id) }}" class="quiz-action-btn quiz-action-attempts" title="View Student Results & Attempts">
                                        <i class="ri-bar-chart-2-line"></i>
                                    </a>

                                    <!-- 3. Delete Quiz Modal Trigger -->
                                    <button type="button" class="quiz-action-btn quiz-action-delete" data-bs-toggle="modal" data-bs-target="#deleteQuizModal{{ $quiz->id }}" title="Delete Quiz">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade text-start" id="deleteQuizModal{{ $quiz->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                            <div class="modal-body p-4 text-center">
                                                <div class="rounded-circle bg-danger-subtle text-danger d-inline-flex align-items-center justify-content-center mb-3 fs-3" style="width: 54px; height: 54px;">
                                                    <i class="ri-delete-bin-line"></i>
                                                </div>
                                                <h5 class="fw-bold text-dark mb-1">Delete Quiz?</h5>
                                                <p class="text-muted text-xs mb-3">
                                                    Are you sure you want to delete <strong>"{{ $quiz->title }}"</strong>? All its {{ $quiz->questions_count }} questions and student attempt history will be permanently deleted.
                                                </p>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button type="button" class="btn btn-light rounded-pill px-3 text-xs" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger rounded-pill px-3 text-xs fw-semibold">Yes, Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                                        <i class="ri-questionnaire-line fs-2 text-muted"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-1">No quizzes found</h5>
                                    <p class="text-muted text-xs mb-3">Create your first quiz or knowledge check to test disciples' learning.</p>
                                    <button type="button" class="btn btn-larkon-add shadow-sm" data-bs-toggle="modal" data-bs-target="#createQuizModal">
                                        <i class="ri-add-line fs-5"></i> Create Quiz
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($quizzes->hasPages())
            <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span class="text-xs text-muted">
                    Showing {{ $quizzes->firstItem() ?? 0 }} to {{ $quizzes->lastItem() ?? 0 }} of {{ $quizzes->total() }} quizzes
                </span>
                <div>
                    {{ $quizzes->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>

</div>

<!-- Modal: Create New Quiz -->
<div class="modal fade" id="createQuizModal" tabindex="-1" aria-labelledby="createQuizModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="ri-questionnaire-fill"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark fs-16" id="createQuizModalLabel">Create New Quiz / Assessment</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.quizzes.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Course Selection -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark text-xs">Course <span class="text-danger">*</span></label>
                            <select name="course_id" id="modalCourseSelect" class="form-select text-sm rounded-3" required onchange="updateLessonOptions(this.value)">
                                <option value="">Select a Course...</option>
                                @foreach($courses as $c)
                                    <option value="{{ $c->id }}" {{ old('course_id', request('course_id')) == $c->id ? 'selected' : '' }}>
                                        {{ $c->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Scope: Lesson or Final Exam -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark text-xs">Quiz Scope / Placement</label>
                            <select name="lesson_id" id="modalLessonSelect" class="form-select text-sm rounded-3">
                                <option value="">Course Final Exam (No specific lesson)</option>
                                <!-- Populated dynamically by JS -->
                            </select>
                            <div class="form-text text-xs">Choose a specific lesson for a Knowledge Check, or leave empty for the Course Final Exam.</div>
                        </div>

                        <!-- Quiz Title -->
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark text-xs">Quiz Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control text-sm rounded-3" placeholder="e.g. Lesson 2 Knowledge Check or Masterclass Final Certification Exam" value="{{ old('title') }}" required>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark text-xs">Instructions / Description (Optional)</label>
                            <textarea name="description" rows="2" class="form-control text-sm rounded-3" placeholder="Explain the quiz requirements, rules, or biblical focus...">{{ old('description') }}</textarea>
                        </div>

                        <!-- Pass Percentage -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark text-xs">Pass Percentage (%) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="pass_percentage" class="form-control text-sm rounded-3" min="1" max="100" value="{{ old('pass_percentage', 70) }}" required>
                                <span class="input-group-text bg-light text-muted text-xs">%</span>
                            </div>
                            <div class="form-text text-xs">Minimum score required to pass (Default: 70%).</div>
                        </div>

                        <!-- Time Limit -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark text-xs">Time Limit (Minutes)</label>
                            <div class="input-group">
                                <input type="number" name="time_limit_minutes" class="form-control text-sm rounded-3" min="1" max="300" placeholder="15" value="{{ old('time_limit_minutes', 15) }}">
                                <span class="input-group-text bg-light text-muted text-xs">Mins</span>
                            </div>
                            <div class="form-text text-xs">Leave blank or 0 for unlimited time.</div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-3 text-xs" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 text-xs fw-semibold shadow-sm">
                        Create &amp; Setup Questions <i class="ri-arrow-right-line ms-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Course to Lessons dictionary for dynamic dropdown
    const courseLessonsMap = {
        @foreach($courses as $c)
            {{ $c->id }}: [
                @foreach($c->lessons as $l)
                    { id: {{ $l->id }}, title: {!! json_encode($l->title) !!}, order: {{ $l->sort_order }} },
                @endforeach
            ],
        @endforeach
    };

    function updateLessonOptions(courseId) {
        const lessonSelect = document.getElementById('modalLessonSelect');
        if (!lessonSelect) return;

        lessonSelect.innerHTML = '<option value="">Course Final Exam (No specific lesson)</option>';

        if (courseId && courseLessonsMap[courseId]) {
            courseLessonsMap[courseId].forEach(lesson => {
                const opt = document.createElement('option');
                opt.value = lesson.id;
                opt.textContent = `Lesson ${lesson.order}: ${lesson.title}`;
                lessonSelect.appendChild(opt);
            });
        }
    }

    // Auto-populate on load if course is already selected
    document.addEventListener('DOMContentLoaded', function() {
        const initialCourse = document.getElementById('modalCourseSelect')?.value;
        if (initialCourse) {
            updateLessonOptions(initialCourse);
        }
    });
</script>

<style>
    /* Card Container */
    .larkon-main-card {
        border: 1px solid #edf2f7 !important;
        border-radius: 12px !important;
        background-color: #ffffff;
    }

    /* Table Base */
    .larkon-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }
    .larkon-table thead th {
        background-color: #f8fafc;
        color: #64748b;
        font-size: 12.5px;
        font-weight: 600;
        text-transform: none;
        letter-spacing: 0.2px;
        padding: 14px 16px;
        border-bottom: 1px solid #edf2f7;
        white-space: nowrap;
    }
    .larkon-table tbody td {
        padding: 16px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 13.5px;
    }
    .larkon-table tbody tr:hover td {
        background-color: #fafbfc;
    }
    .larkon-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Action Buttons Design */
    .quiz-action-btn {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
        font-size: 17px;
        cursor: pointer;
        padding: 0;
        line-height: 1;
        outline: none;
    }
    .quiz-action-btn:hover {
        transform: translateY(-2px);
    }

    /* 1. Setup Questions / Answer Key (Brand Blue) */
    .quiz-action-builder {
        background-color: #eff6ff;
        border-color: #dbeafe;
        color: #2563eb;
    }
    .quiz-action-builder:hover {
        background-color: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    /* 2. Student Results / Analytics (Purple) */
    .quiz-action-attempts {
        background-color: #f5f3ff;
        border-color: #ede9fe;
        color: #7c3aed;
    }
    .quiz-action-attempts:hover {
        background-color: #7c3aed;
        border-color: #7c3aed;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    /* 3. Delete Quiz (Rose / Red) */
    .quiz-action-delete {
        background-color: #fef2f2;
        border-color: #fee2e2;
        color: #dc2626;
    }
    .quiz-action-delete:hover {
        background-color: #dc2626;
        border-color: #dc2626;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }
</style>
@endsection
