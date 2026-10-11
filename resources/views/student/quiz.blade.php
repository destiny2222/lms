@extends('layouts.student-dash')

@section('title', $quiz->title . ' — Authority LMS')

@section('content')
<!-- Breadcrumb Header -->
<div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-20">
    <div class="d-flex align-items-center gap-2 text-sm">
        <a href="{{ route('student.dashboard') }}" class="text-primary-600 text-decoration-none fw-semibold">
            <i class="ri-dashboard-line me-1"></i> Dashboard
        </a>
        <span class="text-secondary-light">/</span>
        <a href="{{ route('courses.show', $course->slug) }}" class="text-secondary-light text-decoration-none">
            {{ Str::limit($course->title, 25) }}
        </a>
        <span class="text-secondary-light">/</span>
        <span class="fw-semibold text-primary-light">{{ $quiz->title }}</span>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-xl-9 col-lg-10">

        <!-- Quiz Overview Banner Card -->
        <div class="card border-0 shadow-sm radius-16 p-24 p-md-32 mb-24 bg-white">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
                <div>
                    <span class="badge {{ is_null($quiz->lesson_id) ? 'bg-warning text-dark' : 'bg-primary-subtle text-primary' }} text-xs text-uppercase px-12 py-6 rounded-pill mb-12 fw-bold">
                        {{ is_null($quiz->lesson_id) ? '🏆 Final Certification Examination' : '📝 Lesson Knowledge Check' }}
                    </span>
                    <h4 class="fw-bold text-primary-light mb-4">{{ $quiz->title }}</h4>
                    <p class="text-secondary-light text-sm mb-0">{{ $quiz->description }}</p>
                </div>

                <div class="d-flex gap-3 text-center flex-shrink-0">
                    <div class="p-16 bg-neutral-50 radius-12 border min-w-100-px">
                        <div class="fw-bold text-primary-light fs-4">{{ $quiz->questions->count() }}</div>
                        <div class="text-xs text-secondary-light">Questions</div>
                    </div>
                    <div class="p-16 bg-success-subtle radius-12 border border-success-subtle min-w-100-px">
                        <div class="fw-bold text-success fs-4">{{ $quiz->pass_percentage }}%</div>
                        <div class="text-xs text-secondary-light">Pass Mark</div>
                    </div>
                </div>
            </div>

            @if($previousAttempts->isNotEmpty())
                <hr class="my-20">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <span class="text-xs text-secondary-light">Previous Best Attempt:</span>
                        <span class="fw-bold fs-6 ms-2 {{ $isPassed ? 'text-success' : 'text-danger' }}">
                            {{ $previousAttempts->max('score_percentage') }}% — {{ $isPassed ? 'PASSED ✅' : 'FAILED ❌' }}
                        </span>
                    </div>
                    @if($isPassed)
                        @if(is_null($quiz->lesson_id) && $enrollment->certificate)
                            <a href="{{ route('certificates.verify', $enrollment->certificate->share_token) }}" class="btn btn-warning text-dark btn-sm radius-8 px-16 py-8 fw-bold">
                                <i class="ri-award-fill me-1"></i> View Earned Badge & Certificate
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
                <div class="card border-0 shadow-sm radius-16 p-24 mb-20 bg-white">
                    <div class="d-flex align-items-start gap-3 mb-16">
                        <span class="w-32-px h-32-px rounded-circle bg-primary-600 text-white d-flex align-items-center justify-content-center fw-bold text-sm flex-shrink-0">
                            {{ $index + 1 }}
                        </span>
                        <h6 class="fw-bold text-primary-light mb-0 pt-4">{{ $q->question }}</h6>
                    </div>

                    <div class="ps-md-40 d-flex flex-column gap-10">
                        @foreach($q->options as $optIndex => $optionText)
                            <div class="form-check p-16 border radius-10 bg-neutral-50 hover-bg-white transition-all">
                                <input class="form-check-input ms-0 me-3" type="radio" name="answers[{{ $q->id }}]" id="q_{{ $q->id }}_{{ $optIndex }}" value="{{ $optIndex }}" required>
                                <label class="form-check-label w-100 fw-medium text-dark text-sm cursor-pointer" for="q_{{ $q->id }}_{{ $optIndex }}">
                                    {{ $optionText }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Submit Button Card -->
            <div class="card border-0 shadow-sm radius-16 p-24 bg-white text-center">
                <p class="text-xs text-secondary-light mb-16">
                    By submitting, your answers will be automatically evaluated against the passing criteria of {{ $quiz->pass_percentage }}%. Passing the final exam immediately generates your official certificate and digital badge!
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <button type="submit" class="btn btn-primary-600 px-32 py-12 radius-8 fw-bold fs-6 shadow-sm">
                        <i class="ri-send-plane-fill me-1"></i> Submit Examination
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
