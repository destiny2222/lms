@extends('layouts.app')

@section('title', $lesson->title . ' — ' . $course->title)

@section('content')
<div class="container-fluid px-lg-5 py-3">

    <!-- Top Breadcrumb Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2 text-sm">
            <a href="{{ route('student.dashboard') }}" class="text-muted text-decoration-none">
                <i class="ri-arrow-left-line me-1"></i> My Dashboard
            </a>
            <span class="text-muted">/</span>
            <a href="{{ route('courses.show', $course->slug) }}" class="text-muted text-decoration-none">
                {{ $course->title }}
            </a>
            <span class="text-muted">/</span>
            <span class="fw-semibold text-dark">{{ $lesson->title }}</span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill text-xs">
                Course Progress: {{ $enrollment->progress_percentage }}%
            </span>
        </div>
    </div>

    <!-- Main Theatre Player Row -->
    <div class="row g-4">
        <!-- Video Player Column -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-black mb-3">
                <div class="video-wrapper" oncontextmenu="return false;">
                    {!! $lesson->embed_player_html !!}
                </div>
            </div>

            <!-- Video Info & Actions -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 pb-3 border-bottom mb-3">
                    <div>
                        <span class="badge bg-primary-subtle text-primary text-xs px-3 py-1 rounded-pill mb-2">
                            Lesson {{ $lesson->sort_order }} of {{ $allLessons->count() }}
                        </span>
                        <h4 class="fw-bold text-dark mb-1">{{ $lesson->title }}</h4>
                        <span class="text-xs text-muted">
                            <i class="ri-time-line me-1"></i> {{ $lesson->video_duration_minutes }} Minutes &bull; Online-only secure stream
                        </span>
                    </div>

                    <div>
                        <form action="{{ route('student.lesson.complete', [$course->slug, $lesson->slug]) }}" method="POST">
                            @csrf
                            @if($quiz && !$isQuizPassed)
                                <a href="{{ route('student.quiz.show', [$course->slug, $quiz->id]) }}" class="btn btn-warning text-dark px-4 py-2 rounded-pill fw-bold d-flex align-items-center gap-2">
                                    <i class="ri-questionnaire-line fs-5"></i> Take Knowledge Check
                                </a>
                            @else
                                <button type="submit" class="btn btn-success px-4 py-2 rounded-pill fw-bold d-flex align-items-center gap-2 shadow-sm">
                                    <i class="ri-checkbox-circle-line fs-5"></i> Mark Complete & Continue
                                </button>
                            @endif
                        </form>
                    </div>
                </div>

                @if($quiz)
                    <div class="alert alert-warning border-0 rounded-3 d-flex align-items-center justify-content-between p-3 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ri-lightbulb-flash-line fs-4 text-warning"></i>
                            <div>
                                <strong>Lesson Knowledge Check:</strong>
                                <span class="text-xs d-block">Pass the quiz ({{ $quiz->pass_percentage }}% required) to validate what you learned.</span>
                            </div>
                        </div>
                        <a href="{{ route('student.quiz.show', [$course->slug, $quiz->id]) }}" class="btn btn-dark btn-sm rounded-pill px-3">
                            {{ $isQuizPassed ? 'Retake Quiz' : 'Start Quiz' }}
                        </a>
                    </div>
                @endif

                <h6 class="fw-bold text-dark mb-2">Lesson Overview</h6>
                <div class="text-muted text-sm lh-lg">
                    {{ $lesson->description ?? 'Follow along carefully and absorb the authority frameworks presented in this lesson.' }}
                </div>
            </div>
        </div>

        <!-- Sidebar Syllabus Navigation Column -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white sticky-top" style="top: 80px;">
                <div class="d-flex justify-content-between align-items-center p-2 mb-2 border-bottom">
                    <h6 class="fw-bold text-dark mb-0">Course Curriculum</h6>
                    <span class="text-xs text-muted">{{ count($completedLessonIds) }}/{{ $allLessons->count() }} Done</span>
                </div>

                <div class="list-group list-group-flush" style="max-height: 65vh; overflow-y: auto;">
                    @foreach($allLessons as $item)
                        @php
                            $isCompleted = in_array($item->id, $completedLessonIds);
                            $isCurrent = $item->id === $lesson->id;
                            $canAccess = $enrollment->canAccessLesson($item);
                        @endphp

                        @if($canAccess)
                            <a href="{{ route('student.lesson.show', [$course->slug, $item->slug]) }}" 
                               class="list-group-item list-group-item-action py-3 px-2 border-0 rounded-3 mb-1 d-flex align-items-center justify-content-between {{ $isCurrent ? 'bg-primary text-white' : ($isCompleted ? 'bg-light text-dark' : 'text-dark') }}">
                                <div class="d-flex align-items-center gap-2 text-truncate pe-2">
                                    @if($isCompleted)
                                        <i class="ri-checkbox-circle-fill text-success fs-5"></i>
                                    @elseif($isCurrent)
                                        <i class="ri-play-circle-fill text-warning fs-5"></i>
                                    @else
                                        <i class="ri-radio-button-line text-muted fs-5"></i>
                                    @endif
                                    <div class="text-truncate">
                                        <div class="text-xs fw-semibold text-truncate {{ $isCurrent ? 'text-white' : 'text-dark' }}">
                                            {{ $item->sort_order }}. {{ $item->title }}
                                        </div>
                                        <span class="text-xs {{ $isCurrent ? 'text-light opacity-75' : 'text-muted' }}">
                                            {{ $item->video_duration_minutes }} mins
                                        </span>
                                    </div>
                                </div>
                                @if($item->quiz)
                                    <span class="badge {{ $isCurrent ? 'bg-warning text-dark' : 'bg-warning-subtle text-warning-emphasis' }} text-xs">Quiz</span>
                                @endif
                            </a>
                        @else
                            <div class="list-group-item py-3 px-2 border-0 rounded-3 mb-1 d-flex align-items-center justify-content-between text-muted opacity-50 bg-light">
                                <div class="d-flex align-items-center gap-2 text-truncate">
                                    <i class="ri-lock-line fs-5"></i>
                                    <div class="text-truncate">
                                        <div class="text-xs fw-semibold text-truncate">{{ $item->sort_order }}. {{ $item->title }}</div>
                                        <span class="text-xs">Complete previous lessons to unlock</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <!-- Final Exam in Sidebar -->
                    @if($course->finalExam())
                        <div class="pt-2 border-top mt-2">
                            <a href="{{ route('student.quiz.show', [$course->slug, $course->finalExam()->id]) }}" class="btn btn-outline-warning text-dark w-100 py-2 rounded-3 text-xs fw-bold d-flex align-items-center justify-content-center gap-2">
                                <i class="ri-award-fill text-warning fs-5"></i> Final Certification Exam
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
