@extends('layouts.student-dash')

@section('title', $lesson->title . ' — ' . $course->title)

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
        <span class="fw-semibold text-primary-light">{{ $lesson->title }}</span>
    </div>

    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-primary-subtle text-primary px-12 py-6 rounded-pill text-xs fw-semibold">
            Course Progress: {{ $enrollment->progress_percentage }}%
        </span>
    </div>
</div>

<!-- Main Theatre Video Row -->
<div class="row g-4">
    <!-- Video Player Column -->
    <div class="col-xl-8">
        <div class="card border-0 shadow-sm radius-16 overflow-hidden bg-black mb-20">
            <div class="video-wrapper position-relative" oncontextmenu="return false;">
                {!! $lesson->embed_player_html !!}
            </div>
        </div>

        <!-- Video Info & Actions -->
        <div class="card border-0 shadow-sm radius-16 p-24 bg-white mb-24">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 pb-20 border-bottom mb-20">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-8">
                        <span class="badge bg-primary-subtle text-primary text-xs px-10 py-4 rounded-pill">
                            Lesson {{ $lesson->sort_order }} of {{ $allLessons->count() }}
                        </span>
                        <span class="badge bg-neutral-100 text-neutral-600 text-xs px-10 py-4 rounded-pill">
                            <i class="ri-lock-line text-warning"></i> Online-only Secure Stream
                        </span>
                    </div>
                    <h4 class="fw-bold text-primary-light mb-4">{{ $lesson->title }}</h4>
                    <span class="text-xs text-secondary-light">
                        <i class="ri-time-line me-1"></i> {{ $lesson->video_duration_minutes }} Minutes &bull; Downloads disabled
                    </span>
                </div>

                <div>
                    <form action="{{ route('student.lesson.complete', [$course->slug, $lesson->slug]) }}" method="POST">
                        @csrf
                        @if($quiz && !$isQuizPassed)
                            <a href="{{ route('student.quiz.show', [$course->slug, $quiz->id]) }}" class="btn btn-warning text-dark px-20 py-10 radius-8 fw-bold d-flex align-items-center gap-2 text-sm shadow-sm">
                                <i class="ri-questionnaire-line fs-5"></i> Take Knowledge Check
                            </a>
                        @else
                            <button type="submit" class="btn btn-success px-20 py-10 radius-8 fw-bold d-flex align-items-center gap-2 text-sm shadow-sm">
                                <i class="ri-checkbox-circle-line fs-5"></i> Mark Complete & Continue
                            </button>
                        @endif
                    </form>
                </div>
            </div>

            @if($quiz)
                <div class="alert alert-warning border-0 radius-12 d-flex align-items-center justify-content-between p-16 mb-20">
                    <div class="d-flex align-items-center gap-3">
                        <i class="ri-lightbulb-flash-line fs-3 text-warning"></i>
                        <div>
                            <strong class="text-dark text-sm d-block">Lesson Knowledge Check</strong>
                            <span class="text-xs text-secondary-light">Pass the quiz ({{ $quiz->pass_percentage }}% required) to validate what you learned.</span>
                        </div>
                    </div>
                    <a href="{{ route('student.quiz.show', [$course->slug, $quiz->id]) }}" class="btn btn-dark btn-sm radius-8 px-16 py-8 text-xs fw-semibold">
                        {{ $isQuizPassed ? 'Retake Quiz' : 'Start Quiz' }}
                    </a>
                </div>
            @endif

            <h6 class="fw-bold text-primary-light mb-8">Lesson Overview & Authority Notes</h6>
            <div class="text-secondary-light text-sm lh-lg">
                {{ $lesson->description ?? 'Follow along carefully and absorb the authority frameworks presented in this lesson. After completing the video, proceed to the knowledge check or the next module.' }}
            </div>
        </div>
    </div>

    <!-- Syllabus Navigation Column -->
    <div class="col-xl-4">
        <div class="card border-0 shadow-sm radius-16 p-20 bg-white sticky-top" style="top: 90px; z-index: 10;">
            <div class="d-flex justify-content-between align-items-center pb-12 mb-12 border-bottom">
                <div>
                    <h6 class="fw-bold text-primary-light mb-2">Course Curriculum</h6>
                    <span class="text-xs text-secondary-light">{{ count($completedLessonIds) }} of {{ $allLessons->count() }} Lessons Completed</span>
                </div>
                <span class="badge bg-primary-subtle text-primary font-monospace text-xs">{{ $enrollment->progress_percentage }}%</span>
            </div>

            <div class="d-flex flex-column gap-8" style="max-height: 60vh; overflow-y: auto;">
                @foreach($allLessons as $item)
                    @php
                        $isCompleted = in_array($item->id, $completedLessonIds);
                        $isCurrent = $item->id === $lesson->id;
                        $canAccess = $enrollment->canAccessLesson($item);
                    @endphp

                    @if($canAccess)
                        <a href="{{ route('student.lesson.show', [$course->slug, $item->slug]) }}" 
                           class="p-12 border radius-8 d-flex align-items-center justify-content-between text-decoration-none transition-all {{ $isCurrent ? 'bg-primary-600 text-white border-primary-600' : ($isCompleted ? 'bg-neutral-50 text-dark' : 'bg-white text-dark hover-bg-neutral-50') }}">
                            <div class="d-flex align-items-center gap-2 text-truncate pe-2">
                                @if($isCompleted)
                                    <i class="ri-checkbox-circle-fill text-success fs-5"></i>
                                @elseif($isCurrent)
                                    <i class="ri-play-circle-fill text-warning fs-5"></i>
                                @else
                                    <i class="ri-radio-button-line text-secondary-light fs-5"></i>
                                @endif
                                <div class="text-truncate">
                                    <div class="text-xs fw-semibold text-truncate {{ $isCurrent ? 'text-white' : 'text-primary-light' }}">
                                        {{ $item->sort_order }}. {{ $item->title }}
                                    </div>
                                    <span class="text-xs {{ $isCurrent ? 'text-white opacity-75' : 'text-secondary-light' }}">
                                        {{ $item->video_duration_minutes }} mins
                                    </span>
                                </div>
                            </div>
                            @if($item->quiz)
                                <span class="badge {{ $isCurrent ? 'bg-warning text-dark' : 'bg-warning-subtle text-warning' }} text-xs">Quiz</span>
                            @endif
                        </a>
                    @else
                        <div class="p-12 border radius-8 d-flex align-items-center justify-content-between bg-neutral-100 text-muted opacity-60">
                            <div class="d-flex align-items-center gap-2 text-truncate">
                                <i class="ri-lock-line fs-5"></i>
                                <div class="text-truncate">
                                    <div class="text-xs fw-semibold text-truncate">{{ $item->sort_order }}. {{ $item->title }}</div>
                                    <span class="text-xs">Locked &bull; Complete previous lesson</span>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                <!-- Final Certification Exam in Curriculum -->
                @if($course->finalExam())
                    <div class="pt-12 border-top mt-8">
                        <a href="{{ route('student.quiz.show', [$course->slug, $course->finalExam()->id]) }}" class="btn btn-warning text-dark w-100 py-10 radius-8 text-xs fw-bold d-flex align-items-center justify-content-center gap-2">
                            <i class="ri-award-fill fs-5"></i> Final Certification Exam
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
