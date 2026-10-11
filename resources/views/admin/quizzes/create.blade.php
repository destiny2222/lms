@extends('layouts.admin')

@section('page_title', 'Create Quiz')

@section('content')
<div class="container-fluid p-0" style="max-width: 900px;">

    <!-- Top Breadcrumb -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-0 text-uppercase" style="letter-spacing: 0.6px; font-size: 1.15rem;">Create Quiz</h4>
            <p class="text-muted text-xs mb-0">Set up a new knowledge check or certification final exam</p>
        </div>
        <div class="text-sm text-muted">
            <a href="{{ route('admin.quizzes.index') }}" class="text-secondary text-decoration-none fw-medium">Quizzes</a> &bull; <span class="text-primary fw-semibold">Create</span>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
            <ul class="mb-0 text-xs">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
        <form action="{{ route('admin.quizzes.store') }}" method="POST">
            @csrf

            <div class="row g-4">
                <!-- Course -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-dark text-xs">Target Course <span class="text-danger">*</span></label>
                    <select name="course_id" id="courseSelect" class="form-select text-sm rounded-3" required onchange="updateLessonOptions(this.value)">
                        <option value="">Select a Course...</option>
                        @foreach($courses as $c)
                            <option value="{{ $c->id }}" {{ old('course_id', $selectedCourseId) == $c->id ? 'selected' : '' }}>
                                {{ $c->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Scope -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-dark text-xs">Quiz Scope / Placement</label>
                    <select name="lesson_id" id="lessonSelect" class="form-select text-sm rounded-3">
                        <option value="">Course Final Exam (No specific lesson)</option>
                    </select>
                    <div class="form-text text-xs">Attach to a single lesson or leave empty as the course final exam.</div>
                </div>

                <!-- Quiz Title -->
                <div class="col-12">
                    <label class="form-label fw-semibold text-dark text-xs">Quiz Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control text-sm rounded-3" placeholder="e.g. Module 1 Knowledge Check: Foundations of Righteousness" value="{{ old('title') }}" required>
                </div>

                <!-- Description -->
                <div class="col-12">
                    <label class="form-label fw-semibold text-dark text-xs">Instructions / Overview (Optional)</label>
                    <textarea name="description" rows="3" class="form-control text-sm rounded-3" placeholder="Describe the focus of this quiz or instructions for students...">{{ old('description') }}</textarea>
                </div>

                <!-- Pass Percentage -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-dark text-xs">Pass Percentage (%) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" name="pass_percentage" class="form-control text-sm rounded-3" min="1" max="100" value="{{ old('pass_percentage', 70) }}" required>
                        <span class="input-group-text bg-light text-muted text-xs">%</span>
                    </div>
                    <div class="form-text text-xs">Score required to pass and unlock next lessons/certificate.</div>
                </div>

                <!-- Time Limit -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-dark text-xs">Time Limit (Minutes)</label>
                    <div class="input-group">
                        <input type="number" name="time_limit_minutes" class="form-control text-sm rounded-3" min="1" max="300" placeholder="15" value="{{ old('time_limit_minutes', 15) }}">
                        <span class="input-group-text bg-light text-muted text-xs">Minutes</span>
                    </div>
                    <div class="form-text text-xs">Leave blank or empty for unlimited duration.</div>
                </div>

                <div class="col-12 d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-outline-secondary rounded-pill px-4 text-xs">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 text-xs fw-semibold shadow-sm">
                        Create &amp; Continue to Question Builder <i class="ri-arrow-right-line ms-1"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>

<script>
    const courseLessonsMap = {
        @foreach($courses as $c)
            {{ $c->id }}: [
                @foreach($c->lessons as $l)
                    { id: {{ $l->id }}, title: {!! json_encode($l->title) !!}, order: {{ $l->sort_order }} },
                @endforeach
            ],
        @endforeach
    };

    const preselectedLesson = {{ json_encode($selectedLessonId) }};

    function updateLessonOptions(courseId) {
        const lessonSelect = document.getElementById('lessonSelect');
        if (!lessonSelect) return;

        lessonSelect.innerHTML = '<option value="">Course Final Exam (No specific lesson)</option>';

        if (courseId && courseLessonsMap[courseId]) {
            courseLessonsMap[courseId].forEach(lesson => {
                const opt = document.createElement('option');
                opt.value = lesson.id;
                opt.textContent = `Lesson ${lesson.order}: ${lesson.title}`;
                if (preselectedLesson && preselectedLesson == lesson.id) {
                    opt.selected = true;
                }
                lessonSelect.appendChild(opt);
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const initialCourse = document.getElementById('courseSelect')?.value;
        if (initialCourse) {
            updateLessonOptions(initialCourse);
        }
    });
</script>
@endsection
