@extends('layouts.main')
@section('title', 'FAQ — RACAi Discipleship')
@section('content')

    <!-- breadcrumb -->
    @include('layouts.breadcrumb', ['pageTitle' => 'FAQ'])
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
@endsection