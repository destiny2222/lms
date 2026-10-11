@extends('layouts.main')

@section('title', $course->title . ' — Authority LMS')

@section('content')
<!-- breadcrumb -->
@include('layouts.breadcrumb', ['pageTitle' => 'Course Details'])
 

<!-- course-details-section -->
<section class="course-details-section pt-100 pb-70">
    <div class="container">
        <div class="row">
            <!-- Right Summary Sidebar -->
            <div class="col-12 col-lg-4 pb-30 order-lg-2">
                <div class="summery-details-item sidebar-to-header">
                    <div class="summery-box">
                        <!-- Course Thumbnail / Video Preview -->
                        <div class="summery-iframe position-relative overflow-hidden" style="height: 220px; background-color: #0b132b;">
                            <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/images/courses/course-image-1.jpg') }}" alt="{{ $course->title }}" class="w-100 h-100 object-fit-cover" onerror="this.src='{{ asset('assets/images/courses/course-image-1.jpg') }}'">
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center shadow-lg" style="width: 56px; height: 56px;">
                                    <i class="flaticon-online-learning-1" style="font-size: 26px;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="summery-inner">
                            <div class="summery-list">
                                <div class="summery-list-item">
                                    <div class="summery-label"><i class="flaticon-equalizer"></i>Level</div>
                                    <div class="summery-option">{{ ucfirst($course->level) }}</div>
                                </div>
                                <div class="summery-list-item">
                                    <div class="summery-label"><i class="flaticon-instructor"></i>Instructor</div>
                                    <div class="summery-option">{{ $course->tutor->name ?? 'Course Faculty' }}</div>
                                </div>
                                <div class="summery-list-item">
                                    <div class="summery-label"><i class="flaticon-online-learning-1"></i>Lessons</div>
                                    <div class="summery-option">{{ $course->lessons->count() }} Lessons</div>
                                </div>
                                <div class="summery-list-item">
                                    <div class="summery-label"><i class="flaticon-reading-book-1"></i>Enrolled</div>
                                    <div class="summery-option">{{ $course->enrollments->count() }} Students</div>
                                </div>
                                <div class="summery-list-item">
                                    <div class="summery-label"><i class="flaticon-clock"></i>Duration</div>
                                    <div class="summery-option">{{ $course->duration_hours }} Hours</div>
                                </div>
                                <div class="summery-list-item">
                                    <div class="summery-label"><i class="flaticon-key"></i>Access</div>
                                    <div class="summery-option">Online Video Streaming</div>
                                </div>
                                <div class="summery-list-item">
                                    <div class="summery-label"><i class="flaticon-award"></i>Certificate</div>
                                    <div class="summery-option">Verified Badge & PDF</div>
                                </div>
                            </div>

                            <!-- Enrollment Action or Progress -->
                            @auth
                                @if($enrollment)
                                    <div class="p-3 bg-off-white rounded my-3">
                                        <div class="d-flex justify-content-between text-xs mb-1">
                                            <span class="fw-semibold">Your Progress</span>
                                            <span class="fw-bold text-primary">{{ $enrollment->progress_percentage }}%</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $enrollment->progress_percentage }}%" aria-valuenow="{{ $enrollment->progress_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    @php
                                        $firstIncomplete = $course->lessons->first(fn($l) => !$enrollment->isLessonCompleted($l->id)) ?? $course->lessons->first();
                                    @endphp

                                    <div class="summery-buttons">
                                        @if($firstIncomplete)
                                            <a href="{{ route('student.lesson.show', [$course->slug, $firstIncomplete->slug]) }}" class="btn main-btn w-100 text-center mb-2">
                                                CONTINUE LEARNING <i class="flaticon-right-arrow ms-1"></i>
                                            </a>
                                        @elseif($course->finalExam() && !$course->finalExam()->isPassedBy($enrollment))
                                            <a href="{{ route('student.quiz.show', [$course->slug, $course->finalExam()->id]) }}" class="btn main-btn btn-warning text-dark w-100 text-center mb-2 fw-bold">
                                                TAKE FINAL EXAM <i class="flaticon-right-arrow ms-1"></i>
                                            </a>
                                        @elseif($course->lessons->isNotEmpty())
                                            <div class="alert alert-success text-center py-2 px-3 mb-2 rounded-3 text-xs fw-semibold">
                                                <i class="flaticon-check me-1"></i> You've completed all lessons!
                                            </div>
                                        @else
                                            <div class="alert alert-info text-center py-2 px-3 mb-2 rounded-3 text-xs fw-semibold">
                                                <i class="flaticon-bell me-1"></i> Lessons will be published soon.
                                            </div>
                                        @endif
                                        <a href="{{ route('student.dashboard') }}" class="btn main-btn btn-white w-100 text-center">
                                            STUDENT DASHBOARD <i class="flaticon-user ms-1"></i>
                                        </a>
                                    </div>
                                @else
                                    <div class="summery-buttons">
                                        <form action="{{ route('student.enroll', $course->id) }}" method="POST" class="w-100">
                                            @csrf
                                            <button type="submit" class="btn main-btn w-100 text-center">
                                                ENROLL FREE NOW <i class="flaticon-edit ms-1"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @else
                                <div class="summery-buttons">
                                    <a href="{{ route('register') }}" class="btn main-btn w-100 text-center mb-2">
                                        REGISTER TO ENROLL FREE <i class="flaticon-user ms-1"></i>
                                    </a>
                                    <a href="{{ route('login') }}" class="btn main-btn btn-white w-100 text-center">
                                        SIGN IN <i class="flaticon-right-arrow ms-1"></i>
                                    </a>
                                </div>
                            @endauth

                            <div class="summery-material-list">
                                <h4>Material Includes</h4>
                                <ul>
                                    <li><span>-</span> Interactive Online Video Delivery</li>
                                    <li><span>-</span> Formative Knowledge Check Quizzes</li>
                                    <li><span>-</span> Final Exam for Certification</li>
                                    <li><span>-</span> Automated WhatsApp Accountability Bot</li>
                                    <li><span>-</span> Verifiable Digital Social Badge & PDF</li>
                                </ul>
                            </div>

                            <div class="summery-social-share">
                                <ul class="social-list">
                                    <li><a href="https://www.facebook.com" target="_blank"><img src="assets/images/facebook.png" alt="facebook"></a></li>
                                    <li><a href="https://twitter.com" target="_blank"><img src="assets/images/twitter.png" alt="twitter"></a></li>
                                    <li><a href="https://www.linkedin.com" target="_blank"><img src="assets/images/linkedin.png" alt="linkedin"></a></li>
                                    <li><a href="https://www.instagram.com" target="_blank"><img src="assets/images/instagram.png" alt="instagram"></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Left Tabs & Detailed Information -->
            <div class="col-12 col-lg-8 pb-30 order-lg-1">
                <div class="summery-details-item desk-pad-right-30">
                    <ul class="product-tab-list">
                        <li class="active" data-product-tab="1">Overview</li>
                        <li data-product-tab="2">Curriculum</li>
                        <li data-product-tab="3">Instructor</li> 
                    </ul>

                    <div class="summery-info-details">
                        <!-- TAB 1: OVERVIEW -->
                        <div class="summery-info-details-item summery-info-details-item-active" data-summery-info-details="1">
                            <div class="summery-info-details-inner">
                                <h3>Course Description</h3>
                                <div class="mb-20">
                                    {!! nl2br(e($course->description)) !!}
                                </div>

                                <h4>Course Highlights & Delivery:</h4>
                                <ul>
                                    <li><i class="flaticon-check"></i> Structured online video lessons created by leading industry practitioners.</li>
                                    <li><i class="flaticon-check"></i> Knowledge check quizzes along the way to test your retention and grasp of critical frameworks.</li> 
                                    <li><i class="flaticon-check"></i> Final Certification Exam awarding an official verified credential with a unique token and PDF.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- TAB 2: CURRICULUM -->
                        <div class="summery-info-details-item" data-summery-info-details="2">
                            <div class="summery-info-details-inner">
                                <h4>Course Outline & Lessons</h4>
                                <small class="text-muted d-block mb-20"><em>{{ $course->lessons->count() }} lessons &bull; {{ $course->duration_hours }} hours total</em></small>

                                <ul class="summery-lesson-list">
                                    @forelse($course->lessons as $lesson)
                                        <li>
                                            <a href="{{ $enrollment ? route('student.lesson.show', [$course->slug, $lesson->slug]) : 'javascript:void(0)' }}">
                                                <span class="summery-lesson-name">
                                                    <strong>Lesson {{ str_pad($lesson->sort_order, 2, '0', STR_PAD_LEFT) }}:</strong> {{ $lesson->title }}
                                                    @if($lesson->quiz)
                                                        <span class="badge bg-warning text-dark text-xs ms-2">Quiz</span>
                                                    @endif
                                                </span>
                                                <div class="summery-item-meta">
                                                    <span class="item-meta duration">{{ $lesson->video_duration_minutes }} min</span>
                                                    @if($enrollment)
                                                        @if($enrollment->isLessonCompleted($lesson->id))
                                                            <i class='bx bx-check-circle text-success fs-5' title="Completed"></i>
                                                        @else
                                                            <i class='bx bx-play-circle text-primary fs-5' title="Start Lesson"></i>
                                                        @endif
                                                    @else
                                                        <i class='bx bxs-lock-alt' title="Enroll to unlock"></i>
                                                    @endif
                                                </div>
                                            </a>
                                        </li>
                                    @empty
                                        <li class="p-3 text-center text-muted">
                                            <em><i class="flaticon-reading me-1"></i> Lessons for this course will be published soon.</em>
                                        </li>
                                    @endforelse

                                    <!-- Final Exam Node -->
                                    @if($course->finalExam())
                                        <li class="bg-warning bg-opacity-10 border border-warning rounded p-3 mt-3">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                <div>
                                                    <h5 class="mb-1 text-dark fw-bold">
                                                        <i class="flaticon-reading text-warning me-2"></i> Final Certification Exam: {{ $course->finalExam()->title }}
                                                    </h5>
                                                    <p class="text-muted text-xs mb-0">Score &ge;{{ $course->finalExam()->pass_percentage }}% on the exam to earn your official verified digital certification badge & PDF.</p>
                                                </div>
                                                <span class="badge bg-warning text-dark px-3 py-2 fw-bold">
                                                    Passing: {{ $course->finalExam()->pass_percentage }}%
                                                </span>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <!-- TAB 3: INSTRUCTOR -->
                        <div class="summery-info-details-item" data-summery-info-details="3">
                            <div class="summery-info-details-inner">
                                <div class="summery-info-instructor">
                                    <div class="summery-info-instructor-thumb">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-3" style="width: 100px; height: 100px;">
                                            {{ strtoupper(substr($course->tutor->name ?? 'T', 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="summery-info-instructor-details">
                                        <h3>{{ $course->tutor->name ?? 'Course Faculty' }}</h3>
                                        <p>{{ $course->tutor->bio ?? 'Lead Faculty and Masterclass Director at Authority LMS. Dedicated to equipping modern practitioners with actionable, real-world competencies.' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- .end course-details-section -->

<!-- Related Courses Section -->
@if($relatedCourses->isNotEmpty())
    <section class="course-section p-tb-100 bg-off-white">
        <div class="container">
            <div class="section-title-group">
                <div class="section-title section-title-shapeless">
                    <h2>Courses You <span>Might Like</span></h2>
                </div>
            </div>
            <div class="course-carousel swiper swiper-container">
                <div class="swiper-wrapper">
                    @foreach($relatedCourses as $relCourse)
                        <div class="course-carousel-item swiper-slide">
                            <div class="course-card">
                                <div class="course-card-thumb">
                                    <a href="{{ route('courses.show', $relCourse->slug) }}">
                                        <img src="{{ $relCourse->thumbnail ? asset($relCourse->thumbnail) : asset('assets/images/courses/course-image-' . (($loop->index % 6) + 1) . '.jpg') }}" alt="{{ $relCourse->title }}" onerror="this.src='{{ asset('assets/images/courses/course-image-1.jpg') }}'">
                                    </a>
                                </div>
                                <div class="course-card-content bg-gray">
                                    <ul class="course-info-list">
                                        <li><i class="flaticon-reading"></i> {{ $relCourse->enrollments->count() }} Students</li>
                                        <li><i class="flaticon-online-learning-1"></i> {{ $relCourse->lessons->count() }} Lessons</li>
                                    </ul>
                                    <h3>
                                        <a href="{{ route('courses.show', $relCourse->slug) }}">{{ $relCourse->title }}</a>
                                    </h3>
                                    <div class="d-flex align-items-center justify-content-between mt-2 pt-2 border-top">
                                        <h4 class="course-price mb-0 text-primary">Free</h4>
                                        <a href="{{ route('courses.show', $relCourse->slug) }}" class="btn main-btn btn-sm">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                                <ul class="course-filter-list">
                                    <li class="course-filter-danger">{{ ucfirst($relCourse->level) }}</li>
                                    <li class="course-filter-success"><i class="flaticon-time"></i> {{ $relCourse->duration_hours }}h</li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-carousel-control">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </section>
@endif

@endsection
