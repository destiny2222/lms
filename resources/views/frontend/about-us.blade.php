@extends("layouts.main")
@section('title', 'About Us — RACAi Discipleship')
@section('content')
    <!-- breadcrumb -->
    @include('layouts.breadcrumb', ['pageTitle' => 'About Us'])
    <!-- about-section -->
    <section class="about-section pt-100 pb-70">
        <div class="container-fluid desk-p-0">
            <div class="row align-items-center desk-mlr-0">
                <div class="col-12 col-lg-6 pb-30 desk-plr-0 order-lg-2 pb-30">
                    <div class="max-600 desk-mr-auto desk-pad-left-30">
                        <div class="about-section-title section-title section-title-left section-title-shapeless position-relative">
                            @if(!empty($aboutSetting->badge_title))
                            <div class="overlay-text">
                                <h3 class="font-family-3">{{ $aboutSetting->badge_title }}</h3>
                            </div>
                            @endif
                            <h2>{{ $aboutSetting->heading_prefix }} @if(!empty($aboutSetting->heading_highlight))<span>{{ $aboutSetting->heading_highlight }}</span>@endif</h2>
                            @if(!empty($aboutSetting->description_1))
                            <p>{{ $aboutSetting->description_1 }}</p>
                            @endif
                            @if(!empty($aboutSetting->description_2))
                            <p>{{ $aboutSetting->description_2 }}</p>
                            @endif
                        </div>
                        @if(!empty($aboutSetting->button_text))
                        <div class="section-button-group">
                            <div class="section-button-item">
                                <a href="{{ $aboutSetting->button_link ?: route('courses.index') }}" class="btn main-btn">{{ $aboutSetting->button_text }} <i class="flaticon-edit"></i></a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-6 pb-30 desk-plr-0 order-lg-1 pb-30">
                    <div class="about-image text-center">
                        @if ($aboutSetting->about_image_url)
                            <img src="{{ $aboutSetting->about_image_url }}" alt="study">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- .end about-section -->
    <!-- about-section -->
    <div class="about-section bg-maincolor-light pt-100 pb-70 position-relative">
        <div class="record-animate-shapes">
            <div class="record-animate-shape animation-tab-none">
                <img src="{{ asset('assets/images/shapes/shape-10.png') }}" alt="shape">
            </div>
            <div class="record-animate-shape animation-tab-none">
                <img src="{{ asset('assets/images/shapes/shape-11.png') }}" alt="shape">
            </div>
        </div>
        <div class="container position-relative">
            <div class="record-grid">
                <div class="record-grid-item">
                    <div class="record-grid-item-inner">
                        <div class="record-item-number">
                            <div class="counter">{{ $aboutSetting->stat_projects_count }}</div>
                            <span>+</span>
                        </div>
                        <div class="record-item-text">
                            <p>{{ $aboutSetting->stat_projects_label }}</p>
                        </div>
                    </div>
                </div>
                <div class="record-grid-item">
                    <div class="record-grid-item-inner">
                        <div class="record-item-number">
                            <div class="counter">{{ $aboutSetting->stat_clients_count }}</div>
                            <span>+</span>
                        </div>
                        <div class="record-item-text">
                            <p>{{ $aboutSetting->stat_clients_label }}</p>
                        </div>
                    </div>
                </div>
                <div class="record-grid-item">
                    <div class="record-grid-item-inner">
                        <div class="record-item-number">
                            <div class="counter">{{ $aboutSetting->stat_students_count }}</div>
                            <span>+</span>
                        </div>
                        <div class="record-item-text">
                            <p>{{ $aboutSetting->stat_students_label }}</p>
                        </div>
                    </div>
                </div>
                <div class="record-grid-item">
                    <div class="record-grid-item-inner">
                        <div class="record-item-number">
                            <div class="counter">{{ $aboutSetting->stat_years_count }}</div>
                            <span>+</span>
                        </div>
                        <div class="record-item-text">
                            <p>{{ $aboutSetting->stat_years_label }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .end about-section -->
    
    <!-- help-section -->
    <section class="help-section pt-100 pb-70">
        <div class="container">
            <div class="section-title">
                <h2>{{ $aboutSetting->help_title }} @if(!empty($aboutSetting->help_title_highlight))<span>{{ $aboutSetting->help_title_highlight }}</span>@endif {{ $aboutSetting->help_title_suffix }}</h2>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3 pb-30">
                    <div class="help-card help-card-center">
                        <div class="help-card-thumb">
                            <i class="flaticon-resume"></i>
                        </div>
                        <div class="help-card-content">
                            <h3>{{ $aboutSetting->feature_1_title }}</h3>
                            <p>{{ $aboutSetting->feature_1_desc }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 pb-30">
                    <div class="help-card help-card-center">
                        <div class="help-card-thumb">
                            <i class="flaticon-satisfaction"></i>
                        </div>
                        <div class="help-card-content">
                            <h3>{{ $aboutSetting->feature_2_title }}</h3>
                            <p>{{ $aboutSetting->feature_2_desc }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 pb-30">
                    <div class="help-card help-card-center">
                        <div class="help-card-thumb">
                            <i class="flaticon-instructions"></i>
                        </div>
                        <div class="help-card-content">
                            <h3>{{ $aboutSetting->feature_3_title }}</h3>
                            <p>{{ $aboutSetting->feature_3_desc }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 pb-30">
                    <div class="help-card help-card-center">
                        <div class="help-card-thumb">
                            <i class="flaticon-learn"></i>
                        </div>
                        <div class="help-card-content">
                            <h3>{{ $aboutSetting->feature_4_title }}</h3>
                            <p>{{ $aboutSetting->feature_4_desc }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- .end help-section -->
    

    <!--=== testimonial-section -->
    <section class="testimonial-section p-tb-100 bg-off-white position-relative">
        <div class="double-bg-shape-items">
            <div class="double-bg-shape-item">
                <img src="{{ asset('assets/images/shapes/bg-line-area-shape.png') }}" alt="shape">
            </div>
            <div class="double-bg-shape-item">
                <img src="{{ asset('assets/images/shapes/circle-shape.png') }}" alt="shape">
            </div>
        </div> 
        <div class="testimonial-animation-items">
            <div class="testimonial-animation-item animation-tab-none">
                <img src="{{ asset('assets/images/shapes/triangle-shape.png') }}" alt="shape">
            </div>
            <div class="testimonial-animation-item animation-tab-none">
                <img src="{{ asset('assets/images/shapes/square-ring-shape.png') }}" alt="shape">
            </div>
            <div class="testimonial-animation-item animation-tab-none">
                <img src="{{ asset('assets/images/shapes/curved-line-black.png') }}" alt="shape">
            </div>
            <div class="testimonial-animation-item animation-tab-none">
                <img src="{{ asset('assets/images/shapes/combined-circle-shape-2.png') }}" alt="shape">
            </div>
        </div>
        <div class="container">
            <div class="section-title">
                <h2>What People Say <span>About Us</span></h2>
            </div>
            <div class="testimonial-carousel swiper swiper-container">
                <div class="swiper-wrapper">
                    @forelse($testimonials ?? [] as $testimonial)
                        <div class="testimonial-carousel-item swiper-slide">
                            <div class="testimonial-carousel-thumb">
                                <img src="{{ $testimonial->avatar_url }}" alt="{{ $testimonial->name }}" style="width: 75px; height: 75px; object-fit: cover; border-radius: 50%;">
                            </div>
                            <div class="testimonial-carousel-content">
                                <h3 class="testimonial-client-name">{{ $testimonial->name }}</h3>
                                @if($testimonial->designation)
                                    <h4 class="testimonial-client-designation">{!! preg_replace('/(\s+at\s+)(.*)/i', '$1<span>$2</span>', e($testimonial->designation)) !!}</h4>
                                @endif
                                <p class="testimonial-client-feedback">“{{ $testimonial->content }}”</p>
                            </div>
                        </div>
                    @empty
                        <div class="testimonial-carousel-item swiper-slide">
                            <div class="testimonial-carousel-content text-center py-5">
                                <p class="text-muted">Student testimonies will appear here once approved by administration.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="swiper-carousel-control">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- .end testimonial-section ===-->

 
@endsection

         