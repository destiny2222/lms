@extends('layouts.main')
@section('title', 'Contact Us — RACAi Discipleship')
@section('content')
    <!-- breadcrumb -->
    @include('layouts.breadcrumb', ['pageTitle' => 'Contact Us'])
    <!-- contact-form-section -->
    <section class="contact-form-section p-tb-100">
        <div class="container">
            <div class="contact-form-box">
                <div class="sub-section-title text-center">
                    @if(!empty($contactSetting->form_title))
                    <h3 class="sub-section-title-heading">{{ $contactSetting->form_title }}</h3>
                    @endif
                    @if(!empty($contactSetting->form_subtitle))
                    <p>{{ $contactSetting->form_subtitle }}</p>
                    @endif
                </div>
                <form class="contact-form" id="contactForm">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group mb-20">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="flaticon-user"></i></span>
                                    </div>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name*" required data-error="Please enter your name" />
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group mb-20">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="flaticon-envelope"></i></span>
                                    </div>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Email*" required data-error="Please enter your email" />
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group mb-20">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="flaticon-phone-call"></i></span>
                                    </div>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone*" required data-error="Please enter your phone number" />
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group mb-20">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="flaticon-book"></i></span>
                                    </div>
                                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject*" required data-error="Please enter your subject" />
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group mb-20">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="flaticon-envelope"></i></span>
                                    </div>
                                    <textarea name="message" class="form-control" id="message" rows="6" placeholder="Your Comment*"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <div class="form-check agree-label">
                                    <input
                                        name="gridCheck"
                                        value="I agree to the terms and privacy policy."
                                        class="form-check-input"
                                        type="checkbox"
                                        id="gridCheck"
                                        required
                                    >
                                    <label class="form-check-label" for="gridCheck">
                                        Accept <a href="{{ route('terms') }}">Terms of Service</a> and <a href="{{ route('privacy') }}">Privacy Policy</a>
                                    </label>
                                    <div class="help-block with-errors gridCheck-error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-12 col-lg-12 text-center">
                            <button class="btn main-btn" type="submit">SEND A MESSAGE</button>
                            <div id="msgSubmit"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- .end contact-form-section -->
    <!-- contact-information-section -->
    <section class="contact-information-section pb-70">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-5 pb-30">
                    <div class="contact-information-item">
                        <div class="section-title section-title-shapeless section-title-left text-start">
                            <h2>{{ $contactSetting->section_title }} @if(!empty($contactSetting->section_title_highlight))<span>{{ $contactSetting->section_title_highlight }}</span>@endif</h2>
                        </div>
                        <div class="contact-options">
                            @if(!empty($contactSetting->phone_primary))
                            <div class="contact-option-item">
                                <div class="contact-option-icon"><i class="flaticon-phone-call"></i></div>
                                <div class="contact-option-details">
                                    <p>Mobile: <a href="tel:{{ $contactSetting->phone_primary_tel }}">{{ $contactSetting->phone_primary }}</a></p>
                                    @if(!empty($contactSetting->phone_secondary))
                                    <p>Hotline: <a href="tel:{{ $contactSetting->phone_secondary_tel }}">{{ $contactSetting->phone_secondary }}</a></p>
                                    @endif
                                    @if(!empty($contactSetting->email))
                                    <p>Email: <a href="mailto:{{ $contactSetting->email }}">{{ $contactSetting->email }}</a></p>
                                    @endif
                                </div>
                            </div>
                            @elseif(!empty($contactSetting->email))
                            <div class="contact-option-item">
                                <div class="contact-option-icon"><i class="flaticon-phone-call"></i></div>
                                <div class="contact-option-details">
                                    <p>Email: <a href="mailto:{{ $contactSetting->email }}">{{ $contactSetting->email }}</a></p>
                                </div>
                            </div>
                            @endif
                            @if(!empty($contactSetting->address))
                            <div class="contact-option-item">
                                <div class="contact-option-icon"><i class="flaticon-network"></i></div>
                                <div class="contact-option-details">
                                    <p>{{ $contactSetting->address }}</p>
                                </div>
                            </div>
                            @endif
                            @if(!empty($contactSetting->weekday_hours) || !empty($contactSetting->weekend_hours))
                            <div class="contact-option-item">
                                <div class="contact-option-icon"><i class="flaticon-clock"></i></div>
                                <div class="contact-option-details">
                                    @if(!empty($contactSetting->weekday_hours))
                                    <p>Monday - Friday: <span>{{ $contactSetting->weekday_hours }}</span></p>
                                    @endif
                                    @if(!empty($contactSetting->weekend_hours))
                                    <p>Sunday & Saturday: <span>{{ $contactSetting->weekend_hours }}</span></p>
                                    @endif
                                </div>
                            </div>
                            @endif
                            @if(!empty($contactSetting->whatsapp_number))
                            <div class="contact-option-item">
                                <div class="contact-option-icon"><i class="flaticon-chat"></i></div>
                                <div class="contact-option-details">
                                    <p>WhatsApp: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactSetting->whatsapp_number) }}" target="_blank" rel="noopener noreferrer">{{ $contactSetting->whatsapp_number }}</a></p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-7 pb-30">
                    <div class="contact-information-item">
                        <div class="contact-information-image">
                            <img src="{{ $contactSetting->contact_image_url ?? asset('assets/images/profile-image.jpg') }}" alt="contact">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- .end contact-information-section -->
 
@endsection
    