@extends('layouts.admin')

@section('page_title', 'Student Attempts: ' . $quiz->title)

@section('content')
<div class="container-fluid p-0">

    <!-- Top Breadcrumb & Page Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <div class="text-xs text-muted mb-1">
                <a href="{{ route('admin.quizzes.index') }}" class="text-secondary text-decoration-none">Quizzes</a>
                &bull; <a href="{{ route('admin.quizzes.builder', $quiz->id) }}" class="text-secondary text-decoration-none">{{ $quiz->title }}</a>
                &bull; <span class="text-primary fw-semibold">Student Attempts</span>
            </div>
            <h4 class="fw-bold text-dark mb-0 fs-20">Student Results: {{ $quiz->title }}</h4>
            <p class="text-muted text-xs mb-0">Passing Mark: <strong>{{ $quiz->pass_percentage }}%</strong> &bull; Total Questions: <strong>{{ $quiz->questions->count() }}</strong></p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.quizzes.builder', $quiz->id) }}" class="btn btn-outline-primary rounded-pill text-xs px-3 shadow-sm">
                <i class="ri-list-check-2 me-1"></i> Question Builder
            </a>
            <a href="{{ route('admin.quizzes.index') }}" class="btn btn-outline-secondary rounded-pill text-xs px-3 shadow-sm">
                <i class="ri-arrow-left-line me-1"></i> Back to Quizzes
            </a>
        </div>
    </div>

    <!-- Table of Attempts -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white larkon-main-card">
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark mb-0 fs-16">All Submissions</h5>
            <span class="badge bg-light text-muted border text-xs px-2.5 py-1 rounded-pill">
                {{ $attempts->total() }} Submissions
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 larkon-table">
                <thead>
                    <tr>
                        <th style="min-width: 220px;" class="ps-4">Student</th>
                        <th style="min-width: 140px;">Score</th>
                        <th style="min-width: 130px;">Result</th>
                        <th style="min-width: 180px;">Submission Date</th>
                        <th style="min-width: 120px;" class="text-end pe-4">Answers</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attempts as $attempt)
                        @php
                            $user = $attempt->enrollment->user ?? null;
                            $answers = is_array($attempt->answers) ? $attempt->answers : json_decode($attempt->answers, true) ?? [];
                        @endphp
                        <tr>
                            <!-- Student Info -->
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center text-xs" style="width: 36px; height: 36px;">
                                        {{ strtoupper(substr($user->name ?? 'Student', 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="fw-semibold text-dark text-xs text-truncate" style="max-width: 200px;">
                                            {{ $user->name ?? 'Unknown Student' }}
                                        </div>
                                        <div class="text-muted text-xs text-truncate" style="max-width: 200px;">
                                            {{ $user->email ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Score -->
                            <td>
                                <div class="fw-bold fs-15 {{ $attempt->is_passed ? 'text-success' : 'text-danger' }}">
                                    {{ $attempt->score_percentage }}%
                                </div>
                                <span class="text-muted text-xs">Required: {{ $quiz->pass_percentage }}%</span>
                            </td>

                            <!-- Pass / Fail Badge -->
                            <td>
                                @if($attempt->is_passed)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 text-xs fw-semibold">
                                        <i class="ri-checkbox-circle-fill me-1"></i> Passed
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2.5 py-1 text-xs fw-semibold">
                                        <i class="ri-close-circle-fill me-1"></i> Failed
                                    </span>
                                @endif
                            </td>

                            <!-- Attempt Date -->
                            <td>
                                <div class="text-dark text-xs fw-medium">
                                    {{ $attempt->attempted_at ? $attempt->attempted_at->format('M d, Y') : $attempt->created_at->format('M d, Y') }}
                                </div>
                                <span class="text-muted text-xs">
                                    {{ $attempt->attempted_at ? $attempt->attempted_at->format('h:i A') : $attempt->created_at->format('h:i A') }}
                                </span>
                            </td>

                            <!-- View Answers Action -->
                            <td class="text-end pe-4">
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-1 text-xs" data-bs-toggle="modal" data-bs-target="#viewAnswersModal{{ $attempt->id }}">
                                    <i class="ri-eye-line me-1"></i> View Answers
                                </button>

                                <!-- Answers Modal -->
                                <div class="modal fade text-start" id="viewAnswersModal{{ $attempt->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                            <div class="modal-header bg-light border-bottom px-4 py-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="rounded-circle {{ $attempt->is_passed ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                                        <i class="{{ $attempt->is_passed ? 'ri-checkbox-circle-fill' : 'ri-close-circle-fill' }} fs-5"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="modal-title fw-bold text-dark fs-16 mb-0">{{ $user->name ?? 'Student' }}'s Submission</h5>
                                                        <span class="text-muted text-xs">Score: {{ $attempt->score_percentage }}% ({{ $attempt->is_passed ? 'Passed' : 'Failed' }})</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body p-4">
                                                @foreach($quiz->questions as $qIdx => $question)
                                                    @php
                                                        $options = is_array($question->options) ? $question->options : json_decode($question->options, true) ?? [];
                                                        $studentChoice = $answers[$question->id] ?? null;
                                                        $isChoiceCorrect = ($studentChoice !== null && (int)$studentChoice === (int)$question->correct_answer_index);
                                                        $alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                                                    @endphp
                                                    <div class="border rounded-3 p-3 mb-3 bg-white">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="badge bg-light text-secondary border text-xs">Question {{ $qIdx + 1 }}</span>
                                                            @if($isChoiceCorrect)
                                                                <span class="badge bg-success-subtle text-success text-xs"><i class="ri-check-line me-1"></i>Correct</span>
                                                            @else
                                                                <span class="badge bg-danger-subtle text-danger text-xs"><i class="ri-close-line me-1"></i>Incorrect</span>
                                                            @endif
                                                        </div>

                                                        <div class="fw-semibold text-dark text-sm mb-3">
                                                            {{ $question->question }}
                                                        </div>

                                                        <div class="row g-2">
                                                            @foreach($options as $oIdx => $optText)
                                                                @php
                                                                    $isStudentPick = ($studentChoice !== null && (int)$studentChoice === (int)$oIdx);
                                                                    $isTheKey = ((int)$question->correct_answer_index === (int)$oIdx);
                                                                @endphp
                                                                <div class="col-md-6">
                                                                    <div class="p-2 rounded-2 text-xs border d-flex align-items-center justify-content-between {{ $isTheKey ? 'bg-success-subtle border-success text-success-emphasis fw-bold' : ($isStudentPick ? 'bg-danger-subtle border-danger text-danger-emphasis' : 'bg-light text-muted') }}">
                                                                        <span>
                                                                            <strong>{{ $alphabet[$oIdx] ?? ($oIdx + 1) }}.</strong> {{ $optText }}
                                                                        </span>
                                                                        @if($isTheKey)
                                                                            <span class="badge bg-success text-white text-xxs">Correct Key</span>
                                                                        @elseif($isStudentPick)
                                                                            <span class="badge bg-danger text-white text-xxs">Student Selected</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        @if($question->explanation)
                                                            <div class="mt-2 text-xs text-muted fst-italic">
                                                                Ref: {{ $question->explanation }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="modal-footer bg-light px-4 py-2.5">
                                                <button type="button" class="btn btn-secondary rounded-pill px-3 text-xs" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="py-3">
                                    <i class="ri-user-line fs-1 text-secondary mb-2 d-block"></i>
                                    <div class="fw-semibold text-dark">No student attempts recorded yet</div>
                                    <p class="text-muted text-xs mb-0">Attempts will appear here as students complete this quiz.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($attempts->hasPages())
            <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center">
                <span class="text-xs text-muted">
                    Showing {{ $attempts->firstItem() ?? 0 }} to {{ $attempts->lastItem() ?? 0 }} of {{ $attempts->total() }} submissions
                </span>
                <div>
                    {{ $attempts->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>

</div>
@endsection
