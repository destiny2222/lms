@extends('layouts.main')
@section('content')

    <!-- header -->
    <header class="header-page">
        <div class="header-page-shape header-page-shape-bottom">
            <img src="assets/images/shapes/shape-20.png" alt="shape">
        </div>
        <div class="container">
            <div class="header-page-content">
                <h1>FAQ's</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">FAQ's</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
    <!-- .end header -->
    <!-- faq-section -->
    <div class="faq-section pt-100 pb-70">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 pb-30">
                    <div class="faq-section-item desk-pad-right-30">
                        <div class="faq-accordion">
                            <!-- item goes here -->
                            <div class="faq-accordion-item faq-accordion-item-bgless faq-accordion-item-active"> <!-- Use "faq-accordion-item-active" class for toggle accordion -->
                                <div class="faq-accordion-header">
                                    <h3 class="faq-accordion-title">Improving Online Education by Skill</h3>
                                </div>
                                <div class="faq-accordion-body">
                                    <div class="faq-accordion-body-inner">
                                        <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo onse aute irure dolor in reprehenderit in magnam avoluptatem</p>
                                    </div>
                                </div>
                            </div>
                            <div class="faq-accordion-item faq-accordion-item-bgless">
                                <div class="faq-accordion-header">
                                    <h3 class="faq-accordion-title">Superior to Your Fellow Man True Nobility is</h3>
                                </div>
                                <div class="faq-accordion-body">
                                    <div class="faq-accordion-body-inner">
                                        <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo onse aute irure dolor in reprehenderit in magnam avoluptatem</p>
                                    </div>
                                </div>
                            </div>
                            <div class="faq-accordion-item faq-accordion-item-bgless">
                                <div class="faq-accordion-header">
                                    <h3 class="faq-accordion-title">Commitment to Satisfaction in Education</h3>
                                </div>
                                <div class="faq-accordion-body">
                                    <div class="faq-accordion-body-inner">
                                        <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo onse aute irure dolor in reprehenderit in magnam avoluptatem</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 pb-30">
                    <div class="faq-section-item faq-image image-frame">
                        <img src="assets/images/profile-image.jpg" alt="faq">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .end faq-section -->
    
    <!-- partner-section -->
    <section class="partner-section pb-100">
        <div class="container">
            <div class="section-title">
                <h2>They're Our <span>Patronize</span></h2>
            </div>
            <div class="partner-carousel swiper swiper-container">
                <div class="swiper-wrapper">
                    <div class="partner-item swiper-slide">
                        <a href="#"><img src="assets/images/partners/partner-1.png" alt="partner"></a>
                    </div>
                    <div class="partner-item swiper-slide">
                        <a href="#"><img src="assets/images/partners/partner-2.png" alt="partner"></a>
                    </div>
                    <div class="partner-item swiper-slide">
                        <a href="#"><img src="assets/images/partners/partner-3.png" alt="partner"></a>
                    </div>
                    <div class="partner-item swiper-slide">
                        <a href="#"><img src="assets/images/partners/partner-4.png" alt="partner"></a>
                    </div>
                    <div class="partner-item swiper-slide">
                        <a href="#"><img src="assets/images/partners/partner-5.png" alt="partner"></a>
                    </div>
                    <div class="partner-item swiper-slide">
                        <a href="#"><img src="assets/images/partners/partner-6.png" alt="partner"></a>
                    </div>
                    <div class="partner-item swiper-slide">
                        <a href="#"><img src="assets/images/partners/partner-7.png" alt="partner"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- .end partner-section -->

    <!-- become-section -->
    <section class="become-section pb-100">
        <div class="container">
            <div class="bg-main become-section-box">
                <div class="become-section-shapes">
                    <div class="become-section-shape-item">
                        <img src="assets/images/shapes/become-section-curve-line.png" alt="shape">
                    </div>
                </div>
                <div class="become-animate-items">
                    <div class="become-animate-item animation-tab-none">
                        <img src="assets/images/shapes/animate-shape-2.png" alt="shape">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-5 pb-50 mobile-pb-30">
                        <div class="section-title section-title-white section-title-left">
                            <h2>Join As Teacher Or Student</h2>
                            <p>Minim veniam, quis nostrud exercitation ullamco laboris nisi ut henderit in magnam aliquam quaerat voluptatem</p>
                        </div>
                        <div class="section-button-group">
                            <div class="section-button-item">
                                <a href="become-a-teacher.html" class="btn main-btn btn-white">BECOME A TEACHER <i class="flaticon-edit"></i></a>
                            </div>
                            <div class="section-button-item">
                                <a href="become-a-teacher.html" class="btn main-btn btn-white">BECOME A STUDENT <i class="flaticon-edit"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 offset-lg-1 position-relative">
                        <div class="image-position image-position-rb text-center">
                            <img src="assets/images/header-screenshot.png" alt="screenshot">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- .end become-section -->

@endsection