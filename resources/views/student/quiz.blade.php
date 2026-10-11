@extends('layouts.app')

@section('title', $quiz->title . ' — Authority LMS')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Breadcrumb -->
            <div class="mb-3 text-sm">
                <a href="{{ route('student.dashboard') }}" class="text-muted text-decoration-none">Dashboard</a>
                <span class="text-muted">/</span>
                <a href="{{ route('courses.show', $course->slug) }}" class="text-muted text-decoration-none">{{ $course->title }}</a>
                <span class="text-muted">/</span>
                <span class="fw-semibold text-dark">{{ $quiz->title }}</span>
            </div>

            <!-- Quiz Overview Banner -->
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <span class="badge {{ is_null($quiz->lesson_id) ? 'bg-warning text-dark' : 'bg-primary-subtle text-primary' }} text-xs text-uppercase px-3 py-1 rounded-pill mb-2 fw-bold">
                            {{ is_null($quiz->lesson_id) ? 'Final Certification Examination' : 'Lesson Knowledge Check' }}
                        </span>
                        <h3 class="fw-bold text-dark mb-1">{{ $quiz->title }}</h3>
                        <p class="text-muted text-sm mb-0">{{ $quiz->description }}</p>
                    </div>

                    <div class="d-flex gap-3 text-center flex-shrink-0">
                        <div class="p-3 bg-light rounded-3">
                            <div class="fw-bold text-dark fs-5">{{ $quiz->questions->count() }}</div>
                            <div class="text-xs text-muted">Questions</div>
                        </div>
                        <div class="p-3 bg-light rounded-3">
                            <div class="fw-bold text-success fs-5">{{ $quiz->pass_percentage }}%</div>
                            <div class="text-xs text-muted">Pass Mark</div>
                        </div>
                    </div>
                </div>

                @if($previousAttempts->isNotEmpty())
                    <hr class="my-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-xs text-muted">Previous Best Attempt:</span>
                            <span class="fw-bold {{ $isPassed ? 'text-success' : 'text-danger' }}">
                                {{ $previousAttempts->max('score_percentage') }}% - {{ $isPassed ? 'PASSED ✅' : 'FAILED ❌' }}
                            </span>
                        </div>
                        @if($isPassed)
                            @if(is_null($quiz->lesson_id) && $enrollment->certificate)
                                <a href="{{ route('certificates.verify', $enrollment->certificate->share_token) }}" class="btn btn-warning text-dark btn-sm rounded-pill px-3 fw-bold">
                                    <i class="ri-award-fill me-1"></i> View Earned Badge
                                </a>
                            @endif
                        @endif
                    </div>
                @endif
            </div>

            <!-- Quiz Questions Form -->
            <form action="{{ route('student.quiz.submit', [$course->slug, $quiz->id]) }}" method="POST">
                @csrf

                @foreach($quiz->questions as $index => $q)
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-3 bg-white">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <span class="badge bg-primary text-white rounded-circle p-2 fs-6" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                {{ $index + 1 }}
                            </span>
                            <h5 class="fw-bold text-dark mb-0 pt-1">{{ $q->question }}</h5>
                        </div>

                        <div class="ps-md-5 d-flex flex-column gap-2">
                            @foreach($q->options as $optIndex => $optionText)
                                <div class="form-check p-3 border rounded-3 bg-light hover-bg-white transition-all">
                                    <input class="form-check-input ms-0 me-3" type="radio" name="answers[{{ $q->id }}]" id="q_{{ $q->id }}_{{ $optIndex }}" value="{{ $optIndex }}" required>
                                    <label class="form-check-label w-100 fw-medium text-dark text-sm cursor-pointer" for="q_{{ $q->id }}_{{ $optIndex }}">
                                        {{ $optionText }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- Submit Button -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white text-center">
                    <p class="text-xs text-muted mb-3">
                        By submitting, your answers will be automatically scored against the passing grade of {{ $quiz->pass_percentage }}%.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-bold fs-6 shadow-sm">
                            <i class="ri-send-plane-fill me-1"></i> Submit Exam Answers
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
