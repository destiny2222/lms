@extends('layouts.admin')

@section('page_title', 'Quiz Builder: ' . $quiz->title)

@section('content')
<div class="container-fluid p-0">

    <!-- Top Breadcrumb & Page Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <div class="text-xs text-muted mb-1">
                <a href="{{ route('admin.quizzes.index') }}" class="text-secondary text-decoration-none">Quizzes</a>
                &bull; <a href="{{ route('admin.courses.lessons', $quiz->course_id) }}" class="text-secondary text-decoration-none">{{ $quiz->course->title ?? 'Course' }}</a>
                &bull; <span class="text-primary fw-semibold">Question Builder</span>
            </div>
            <h4 class="fw-bold text-dark mb-0 fs-20">{{ $quiz->title }}</h4>
            @if($quiz->description)
                <p class="text-muted text-xs mb-0 mt-0.5">{{ $quiz->description }}</p>
            @endif
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <button type="button" class="btn btn-outline-secondary rounded-pill text-xs px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#editQuizModal">
                <i class="ri-settings-3-line me-1"></i> Quiz Settings
            </button>
            <a href="{{ route('admin.quizzes.attempts', $quiz->id) }}" class="btn btn-outline-primary rounded-pill text-xs px-3 shadow-sm">
                <i class="ri-bar-chart-2-line me-1"></i> Attempts ({{ $quiz->attempts->count() }})
            </a>
            <button type="button" class="btn btn-larkon-add shadow-sm" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                <i class="ri-add-line fs-5"></i> Add Question
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert" style="background-color: #ecfdf5; color: #065f46;">
            <i class="ri-checkbox-circle-fill fs-5 text-success"></i>
            <div class="fw-medium text-sm">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
            <div class="fw-bold text-xs mb-1">Please correct the following errors:</div>
            <ul class="mb-0 text-xs ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Quiz Highlights Bar -->
    <div class="row g-3 mb-4">
        <!-- Scope / Placement -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <span class="text-muted text-xs text-uppercase fw-semibold mb-1 d-block">Scope &amp; Placement</span>
                @if($quiz->lesson)
                    <div class="fw-bold text-dark fs-14 text-truncate" title="{{ $quiz->lesson->title }}">
                        Lesson {{ $quiz->lesson->sort_order }}: {{ $quiz->lesson->title }}
                    </div>
                    <span class="badge bg-light text-secondary border rounded-pill px-2 py-0.5 text-xs mt-1">Lesson Knowledge Check</span>
                @else
                    <div class="fw-bold text-dark fs-14">Course Final Exam</div>
                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2 py-0.5 text-xs mt-1">Certification Qualifier</span>
                @endif
            </div>
        </div>

        <!-- Total Questions -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <span class="text-muted text-xs text-uppercase fw-semibold mb-1 d-block">Questions Configured</span>
                <div class="d-flex align-items-baseline gap-2">
                    <h3 class="fw-bold text-dark mb-0">{{ $quiz->questions->count() }}</h3>
                    <span class="text-muted text-xs">Total items</span>
                </div>
                <span class="text-muted text-xs mt-1 d-block">Multiple choice format</span>
            </div>
        </div>

        <!-- Pass Mark -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <span class="text-muted text-xs text-uppercase fw-semibold mb-1 d-block">Passing Benchmark</span>
                <div class="d-flex align-items-baseline gap-2">
                    <h3 class="fw-bold text-primary mb-0">{{ $quiz->pass_percentage }}%</h3>
                    <span class="text-muted text-xs">Required</span>
                </div>
                <span class="text-muted text-xs mt-1 d-block">Automated grading</span>
            </div>
        </div>

        <!-- Time Limit -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <span class="text-muted text-xs text-uppercase fw-semibold mb-1 d-block">Time Limit</span>
                <div class="d-flex align-items-baseline gap-2">
                    <h3 class="fw-bold text-dark mb-0">{{ $quiz->time_limit_minutes ? $quiz->time_limit_minutes.'m' : 'None' }}</h3>
                    <span class="text-muted text-xs">{{ $quiz->time_limit_minutes ? 'Countdown timer' : 'Self-paced' }}</span>
                </div>
                <span class="text-muted text-xs mt-1 d-block">Per student attempt</span>
            </div>
        </div>
    </div>

    <!-- Questions List Section -->
    <div class="card border-0 shadow-sm rounded-3 bg-white mb-4">
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <h5 class="fw-bold text-dark mb-0 fs-16">Questions &amp; Answer Keys</h5>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill text-xs px-2.5 py-0.5">
                    {{ $quiz->questions->count() }} {{ Str::plural('Question', $quiz->questions->count()) }}
                </span>
            </div>

            <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                <i class="ri-add-line me-1"></i> Add Question
            </button>
        </div>

        <div class="card-body p-4">
            @forelse($quiz->questions as $index => $question)
                <div class="border rounded-4 p-4 mb-4 bg-white question-card position-relative shadow-sm" style="border-color: #e2e8f0 !important;">
                    
                    <!-- Top Question Header -->
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary rounded-pill px-3 py-1 fs-12 fw-bold">
                                Question {{ $index + 1 }}
                            </span>
                            <span class="text-muted text-xs">
                                Sort Order: #{{ $question->sort_order }}
                            </span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex align-items-center gap-1.5">
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-1 text-xs" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editQuestionModal{{ $question->id }}"
                                    title="Edit Question & Choices">
                                <i class="ri-pencil-line me-1"></i> Edit
                            </button>

                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1 text-xs"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteQuestionModal{{ $question->id }}"
                                    title="Delete Question">
                                <i class="ri-delete-bin-line me-1"></i> Delete
                            </button>
                        </div>
                    </div>

                    <!-- Question Text -->
                    <div class="fs-15 fw-semibold text-dark mb-3 lh-base">
                        {{ $question->question }}
                    </div>

                    <!-- Options Grid / List -->
                    <div class="row g-2 mb-3">
                        @php
                            $optionsList = is_array($question->options) ? $question->options : json_decode($question->options, true) ?? [];
                            $alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                        @endphp

                        @foreach($optionsList as $optIdx => $optionText)
                            @php
                                $isCorrect = ((int) $question->correct_answer_index === (int) $optIdx);
                            @endphp
                            <div class="col-md-6">
                                <div class="p-2.5 rounded-3 border d-flex align-items-center justify-content-between gap-2 h-100 {{ $isCorrect ? 'bg-success-subtle border-success' : 'bg-light border-light-subtle' }}">
                                    <div class="d-flex align-items-center gap-2.5 min-w-0">
                                        <div class="w-6 h-6 rounded-circle d-flex align-items-center justify-content-center text-xs fw-bold flex-shrink-0 {{ $isCorrect ? 'bg-success text-white' : 'bg-white text-secondary border' }}" style="width: 26px; height: 26px;">
                                            {{ $alphabet[$optIdx] ?? ($optIdx + 1) }}
                                        </div>
                                        <span class="text-sm {{ $isCorrect ? 'fw-bold text-success-emphasis' : 'text-dark' }} text-break">
                                            {{ $optionText }}
                                        </span>
                                    </div>

                                    @if($isCorrect)
                                        <span class="badge bg-success text-white rounded-pill px-2 py-1 text-xs flex-shrink-0">
                                            <i class="ri-check-line me-0.5"></i> Correct Key
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Explanation (if present) -->
                    @if($question->explanation)
                        <div class="p-2.5 rounded-3 bg-light border-0 d-flex align-items-start gap-2 text-xs text-muted">
                            <i class="ri-lightbulb-line text-warning fs-5 flex-shrink-0 mt-0.5"></i>
                            <div>
                                <span class="fw-semibold text-dark d-block">Explanation / Study Reference:</span>
                                {{ $question->explanation }}
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Modal: Edit Question {{ $question->id }} -->
                <div class="modal fade text-start" id="editQuestionModal{{ $question->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="modal-header bg-light border-bottom px-4 py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="ri-pencil-fill"></i>
                                    </div>
                                    <h5 class="modal-title fw-bold text-dark fs-16">Edit Question #{{ $index + 1 }}</h5>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form action="{{ route('admin.quizzes.questions.update', [$quiz->id, $question->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body p-4">
                                    <!-- Question Text -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark text-xs">Question Text <span class="text-danger">*</span></label>
                                        <textarea name="question" rows="3" class="form-control text-sm rounded-3" required>{{ old('question', $question->question) }}</textarea>
                                    </div>

                                    <!-- Options Container -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label fw-semibold text-dark text-xs mb-0">Answer Choices &amp; Correct Key <span class="text-danger">*</span></label>
                                            <span class="text-xs text-muted">Select the radio button for the correct answer</span>
                                        </div>

                                        <div id="editOptionsContainer_{{ $question->id }}">
                                            @foreach($optionsList as $optIdx => $optVal)
                                                <div class="input-group mb-2 option-row">
                                                    <div class="input-group-text bg-white">
                                                        <input class="form-check-input mt-0" type="radio" name="correct_answer_index" value="{{ $optIdx }}" {{ (int) $question->correct_answer_index === $optIdx ? 'checked' : '' }} required title="Mark as correct answer">
                                                    </div>
                                                    <span class="input-group-text bg-light text-xs fw-bold px-2.5">{{ $alphabet[$optIdx] ?? ($optIdx + 1) }}</span>
                                                    <input type="text" name="options[]" class="form-control text-sm" value="{{ $optVal }}" required placeholder="Option text...">
                                                    @if(count($optionsList) > 2)
                                                        <button type="button" class="btn btn-outline-danger" onclick="removeOptionRow(this, {{ $question->id }})" title="Remove Option">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill text-xs mt-1" onclick="addOptionRow({{ $question->id }})">
                                            <i class="ri-add-line me-1"></i> Add Another Choice
                                        </button>
                                    </div>

                                    <!-- Explanation -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark text-xs">Explanation / Biblical Reference (Optional)</label>
                                        <textarea name="explanation" rows="2" class="form-control text-sm rounded-3" placeholder="Explain why this answer is correct or quote scripture...">{{ old('explanation', $question->explanation) }}</textarea>
                                    </div>

                                    <!-- Sort Order -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold text-dark text-xs">Sort Order</label>
                                            <input type="number" name="sort_order" class="form-control text-sm rounded-3" value="{{ old('sort_order', $question->sort_order) }}" min="1">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill px-3 text-xs" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 text-xs fw-semibold shadow-sm">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal: Delete Question {{ $question->id }} -->
                <div class="modal fade text-start" id="deleteQuestionModal{{ $question->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="modal-body p-4 text-center">
                                <div class="rounded-circle bg-danger-subtle text-danger d-inline-flex align-items-center justify-content-center mb-3 fs-3" style="width: 54px; height: 54px;">
                                    <i class="ri-delete-bin-line"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1">Delete Question {{ $index + 1 }}?</h5>
                                <p class="text-muted text-xs mb-3">
                                    Are you sure you want to delete this question? This action cannot be undone.
                                </p>
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-light rounded-pill px-3 text-xs" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('admin.quizzes.questions.destroy', [$quiz->id, $question->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded-pill px-3 text-xs fw-semibold">Yes, Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="text-center py-5">
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                        <i class="ri-questionnaire-line fs-2 text-muted"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">No questions added yet</h5>
                    <p class="text-muted text-xs mb-3">Add multiple-choice questions to establish the grading key for this quiz.</p>
                    <button type="button" class="btn btn-larkon-add shadow-sm" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                        <i class="ri-add-line fs-5"></i> Add First Question
                    </button>
                </div>
            @endforelse
        </div>
    </div>

</div>

<!-- Modal: Add New Question -->
<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="ri-question-fill"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark fs-16" id="addQuestionModalLabel">Add Question &amp; Answer Options</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.quizzes.questions.store', $quiz->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <!-- Question Text -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark text-xs">Question <span class="text-danger">*</span></label>
                        <textarea name="question" rows="3" class="form-control text-sm rounded-3" placeholder="e.g. According to Romans 8, what can separate believers from the love of God?" required>{{ old('question') }}</textarea>
                    </div>

                    <!-- Choices Container -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-semibold text-dark text-xs mb-0">Answer Choices &amp; Correct Key <span class="text-danger">*</span></label>
                            <span class="text-xs text-muted"><i class="ri-radio-button-line me-1 text-primary"></i>Check radio for correct answer</span>
                        </div>

                        <div id="newOptionsContainer">
                            <!-- Choice 0 -->
                            <div class="input-group mb-2 option-row">
                                <div class="input-group-text bg-white">
                                    <input class="form-check-input mt-0" type="radio" name="correct_answer_index" value="0" checked required title="Mark as correct answer">
                                </div>
                                <span class="input-group-text bg-light text-xs fw-bold px-2.5">A</span>
                                <input type="text" name="options[]" class="form-control text-sm" placeholder="Option A text..." required>
                            </div>

                            <!-- Choice 1 -->
                            <div class="input-group mb-2 option-row">
                                <div class="input-group-text bg-white">
                                    <input class="form-check-input mt-0" type="radio" name="correct_answer_index" value="1" required title="Mark as correct answer">
                                </div>
                                <span class="input-group-text bg-light text-xs fw-bold px-2.5">B</span>
                                <input type="text" name="options[]" class="form-control text-sm" placeholder="Option B text..." required>
                            </div>

                            <!-- Choice 2 -->
                            <div class="input-group mb-2 option-row">
                                <div class="input-group-text bg-white">
                                    <input class="form-check-input mt-0" type="radio" name="correct_answer_index" value="2" required title="Mark as correct answer">
                                </div>
                                <span class="input-group-text bg-light text-xs fw-bold px-2.5">C</span>
                                <input type="text" name="options[]" class="form-control text-sm" placeholder="Option C text..." required>
                                <button type="button" class="btn btn-outline-danger" onclick="removeOptionRow(this)" title="Remove Option">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>

                            <!-- Choice 3 -->
                            <div class="input-group mb-2 option-row">
                                <div class="input-group-text bg-white">
                                    <input class="form-check-input mt-0" type="radio" name="correct_answer_index" value="3" required title="Mark as correct answer">
                                </div>
                                <span class="input-group-text bg-light text-xs fw-bold px-2.5">D</span>
                                <input type="text" name="options[]" class="form-control text-sm" placeholder="Option D text..." required>
                                <button type="button" class="btn btn-outline-danger" onclick="removeOptionRow(this)" title="Remove Option">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill text-xs mt-1" onclick="addNewOptionRow()">
                            <i class="ri-add-line me-1"></i> Add Another Choice
                        </button>
                    </div>

                    <!-- Explanation -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark text-xs">Explanation / Biblical Context (Optional)</label>
                        <textarea name="explanation" rows="2" class="form-control text-sm rounded-3" placeholder="e.g. Romans 8:38-39 declares neither death nor life, neither angels nor demons can separate us...">{{ old('explanation') }}</textarea>
                        <div class="form-text text-xs">Displayed to students during review or study feedback.</div>
                    </div>

                    <!-- Sort Order -->
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark text-xs">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control text-sm rounded-3" value="{{ $quiz->questions->count() + 1 }}" min="1">
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-3 text-xs" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 text-xs fw-semibold shadow-sm">
                        <i class="ri-check-line me-1"></i> Add Question
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Edit Quiz Settings -->
<div class="modal fade" id="editQuizModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="ri-settings-3-fill"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark fs-16">Edit Quiz Settings</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.quizzes.update', $quiz->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark text-xs">Course <span class="text-danger">*</span></label>
                            <select name="course_id" id="editQuizCourseSelect" class="form-select text-sm rounded-3" required onchange="updateEditLessonOptions(this.value)">
                                @foreach($courses as $c)
                                    <option value="{{ $c->id }}" {{ old('course_id', $quiz->course_id) == $c->id ? 'selected' : '' }}>
                                        {{ $c->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark text-xs">Scope / Lesson</label>
                            <select name="lesson_id" id="editQuizLessonSelect" class="form-select text-sm rounded-3">
                                <option value="">Course Final Exam (No specific lesson)</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark text-xs">Quiz Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control text-sm rounded-3" value="{{ old('title', $quiz->title) }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark text-xs">Instructions / Description</label>
                            <textarea name="description" rows="2" class="form-control text-sm rounded-3">{{ old('description', $quiz->description) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark text-xs">Pass Percentage (%) <span class="text-danger">*</span></label>
                            <input type="number" name="pass_percentage" class="form-control text-sm rounded-3" min="1" max="100" value="{{ old('pass_percentage', $quiz->pass_percentage) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark text-xs">Time Limit (Minutes)</label>
                            <input type="number" name="time_limit_minutes" class="form-control text-sm rounded-3" min="1" max="300" placeholder="15" value="{{ old('time_limit_minutes', $quiz->time_limit_minutes) }}">
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-3 text-xs" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 text-xs fw-semibold shadow-sm">
                        Update Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];

    // Dynamic options in Add Question Modal
    function addNewOptionRow() {
        const container = document.getElementById('newOptionsContainer');
        const count = container.querySelectorAll('.option-row').length;
        if (count >= 10) {
            alert('Maximum 10 options allowed per question.');
            return;
        }

        const letter = alphabet[count] || (count + 1);
        const div = document.createElement('div');
        div.className = 'input-group mb-2 option-row';
        div.innerHTML = `
            <div class="input-group-text bg-white">
                <input class="form-check-input mt-0" type="radio" name="correct_answer_index" value="${count}" required title="Mark as correct answer">
            </div>
            <span class="input-group-text bg-light text-xs fw-bold px-2.5">${letter}</span>
            <input type="text" name="options[]" class="form-control text-sm" placeholder="Option ${letter} text..." required>
            <button type="button" class="btn btn-outline-danger" onclick="removeOptionRow(this)" title="Remove Option">
                <i class="ri-delete-bin-line"></i>
            </button>
        `;
        container.appendChild(div);
    }

    // Dynamic options in Edit Question Modal
    function addOptionRow(questionId) {
        const container = document.getElementById(`editOptionsContainer_${questionId}`);
        const count = container.querySelectorAll('.option-row').length;
        if (count >= 10) {
            alert('Maximum 10 options allowed per question.');
            return;
        }

        const letter = alphabet[count] || (count + 1);
        const div = document.createElement('div');
        div.className = 'input-group mb-2 option-row';
        div.innerHTML = `
            <div class="input-group-text bg-white">
                <input class="form-check-input mt-0" type="radio" name="correct_answer_index" value="${count}" required title="Mark as correct answer">
            </div>
            <span class="input-group-text bg-light text-xs fw-bold px-2.5">${letter}</span>
            <input type="text" name="options[]" class="form-control text-sm" placeholder="Option ${letter} text..." required>
            <button type="button" class="btn btn-outline-danger" onclick="removeOptionRow(this, ${questionId})" title="Remove Option">
                <i class="ri-delete-bin-line"></i>
            </button>
        `;
        container.appendChild(div);
    }

    function removeOptionRow(btn, questionId = null) {
        const container = questionId ? document.getElementById(`editOptionsContainer_${questionId}`) : document.getElementById('newOptionsContainer');
        const rows = container.querySelectorAll('.option-row');
        if (rows.length <= 2) {
            alert('At least 2 options are required.');
            return;
        }

        btn.closest('.option-row').remove();
        // Re-index remaining rows
        reindexOptionRows(container);
    }

    function reindexOptionRows(container) {
        const rows = container.querySelectorAll('.option-row');
        rows.forEach((row, idx) => {
            const letter = alphabet[idx] || (idx + 1);
            const radio = row.querySelector('input[type="radio"]');
            if (radio) {
                radio.value = idx;
            }
            const badge = row.querySelector('.input-group-text.bg-light');
            if (badge) {
                badge.textContent = letter;
            }
            const input = row.querySelector('input[type="text"]');
            if (input && !input.value) {
                input.placeholder = `Option ${letter} text...`;
            }
        });
    }

    // Course to Lessons dictionary for dynamic modal dropdown
    const courseLessonsMap = {
        @foreach($courses as $c)
            {{ $c->id }}: [
                @foreach($c->lessons as $l)
                    { id: {{ $l->id }}, title: {!! json_encode($l->title) !!}, order: {{ $l->sort_order }} },
                @endforeach
            ],
        @endforeach
    };

    const currentQuizLessonId = {{ json_encode($quiz->lesson_id) }};

    function updateEditLessonOptions(courseId) {
        const lessonSelect = document.getElementById('editQuizLessonSelect');
        if (!lessonSelect) return;

        lessonSelect.innerHTML = '<option value="">Course Final Exam (No specific lesson)</option>';

        if (courseId && courseLessonsMap[courseId]) {
            courseLessonsMap[courseId].forEach(lesson => {
                const opt = document.createElement('option');
                opt.value = lesson.id;
                opt.textContent = `Lesson ${lesson.order}: ${lesson.title}`;
                if (currentQuizLessonId && currentQuizLessonId == lesson.id) {
                    opt.selected = true;
                }
                lessonSelect.appendChild(opt);
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const initialCourse = document.getElementById('editQuizCourseSelect')?.value;
        if (initialCourse) {
            updateEditLessonOptions(initialCourse);
        }
    });
</script>
@endsection
