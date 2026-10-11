@extends('layouts.app')

@section('title', 'Verified Certificate: ' . $student->name . ' — ' . $course->title)

@section('meta_tags')
    <!-- Open Graph for LinkedIn, Twitter, and Facebook Previews -->
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Verified Certificate: {{ $student->name }} completed {{ $course->title }}" />
    <meta property="og:description" content="Official Certificate of Completion & Authority Digital Badge awarded to {{ $student->name }} on {{ $certificate->issued_at->format('F d, Y') }}." />
    <meta property="og:url" content="{{ $certificate->share_url }}" />
    <meta property="og:image" content="{{ route('certificates.badge', $certificate->id) }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Verified Certificate: {{ $student->name }} - {{ $course->title }}" />
    <meta name="twitter:description" content="Official Certificate of Completion and Authority Digital Badge." />
    <meta name="twitter:image" content="{{ route('certificates.badge', $certificate->id) }}" />
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <!-- Verified Status Pill -->
            <div class="text-center mb-4">
                <span class="badge bg-success-subtle text-success border border-success px-4 py-2 rounded-pill text-sm fw-bold">
                    <i class="ri-shield-check-fill me-1 fs-6"></i> OFFICIALLY VERIFIED CREDENTIAL
                </span>
            </div>

            <!-- Certificate Visual Display Card -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4 bg-white">
                <!-- Certificate Inner Frame -->
                <div class="p-4 p-md-5 text-center position-relative" style="background: radial-gradient(circle, #FFFFFF 0%, #F8FAFC 100%); border: 12px solid #0F172A; outline: 3px dashed #D97706; outline-offset: -8px;">
                    
                    <!-- Watermark Logo -->
                    <div class="mb-3">
                        <div class="w-72-px h-72-px rounded-circle bg-warning text-dark d-inline-flex align-items-center justify-content-center shadow-sm">
                            <i class="ri-award-fill fs-1"></i>
                        </div>
                    </div>

                    <h6 class="text-xs text-uppercase text-muted letter-spacing-4 mb-2 fw-bold">AUTHORITY LEARNING & EDUCATION FOUNDATION</h6>
                    <h2 class="display-6 fw-extrabold text-dark mb-1" style="font-family: Georgia, serif;">CERTIFICATE OF COMPLETION</h2>
                    <p class="text-xs text-uppercase text-warning fw-bold tracking-wider mb-4">VERIFIED DIGITAL BADGE & HONORS</p>

                    <p class="text-muted text-sm mb-1">This certifies that</p>
                    <h1 class="display-5 fw-bold text-primary mb-3" style="font-family: Georgia, serif; text-decoration: underline; text-decoration-color: #F59E0B;">
                        {{ $student->name }}
                    </h1>

                    <p class="text-muted text-sm mx-auto mb-4" style="max-width: 600px;">
                        has successfully completed all required online video lessons, passed the progressive knowledge checks, and achieved honors on the comprehensive final examination for:
                    </p>

                    <div class="p-3 bg-light rounded-3 d-inline-block px-4 mb-4 border">
                        <h4 class="fw-bold text-dark mb-0">{{ $course->title }}</h4>
                        <span class="text-xs text-muted">{{ $course->duration_hours }} Credit Hours &bull; Authority Level Certification</span>
                    </div>

                    <!-- Signatures & Verification Details Footer -->
                    <div class="row pt-4 mt-3 border-top g-4 align-items-end text-start">
                        <div class="col-md-4 text-center text-md-start">
                            <div class="fw-bold text-dark text-sm border-bottom pb-1" style="font-family: 'Brush Script MT', cursive; font-size: 1.4rem;">
                                {{ $course->tutor->name ?? 'Dr. Jane Mitchell' }}
                            </div>
                            <div class="text-xs text-muted">Director of Academic Curriculum</div>
                        </div>

                        <div class="col-md-4 text-center">
                            <div class="d-inline-block p-2 bg-white rounded-3 border text-center">
                                <i class="ri-qr-code-line fs-2 text-dark"></i>
                                <div class="text-xs text-muted mt-1 font-monospace">{{ $certificate->certificate_number }}</div>
                            </div>
                        </div>

                        <div class="col-md-4 text-center text-md-end">
                            <div class="fw-bold text-dark text-sm border-bottom pb-1">
                                {{ $certificate->issued_at->format('F d, Y') }}
                            </div>
                            <div class="text-xs text-muted">Date of Verification</div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Social Share & Download Action Bar -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="row align-items-center g-3">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-dark mb-1">Share Your Credential Badge</h6>
                        <p class="text-muted text-xs mb-0">Showcase this achievement to your network on social channels:</p>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                            <!-- LinkedIn -->
                            <a href="{{ $certificate->linkedin_share_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm text-white rounded-pill px-3 fw-bold d-flex align-items-center gap-1" style="background: #0A66C2;">
                                <i class="ri-linkedin-fill"></i> LinkedIn
                            </a>

                            <!-- Twitter / X -->
                            <a href="{{ $certificate->twitter_share_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-dark rounded-pill px-3 fw-bold d-flex align-items-center gap-1">
                                <i class="ri-twitter-x-fill"></i> Post
                            </a>

                            <!-- Facebook -->
                            <a href="{{ $certificate->facebook_share_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm text-white rounded-pill px-3 fw-bold d-flex align-items-center gap-1" style="background: #1877F2;">
                                <i class="ri-facebook-fill"></i> Facebook
                            </a>

                            <!-- WhatsApp -->
                            <a href="{{ $certificate->whatsapp_share_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm text-white rounded-pill px-3 fw-bold d-flex align-items-center gap-1" style="background: #25D366;">
                                <i class="ri-whatsapp-fill"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                </div>

                <hr class="my-3">

                <!-- Download Actions -->
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="text-xs text-muted font-monospace">
                        Public Share Link: <a href="{{ $certificate->share_url }}" class="text-primary">{{ $certificate->share_url }}</a>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('certificates.badge', $certificate->id) }}" download="badge-{{ $certificate->certificate_number }}.svg" class="btn btn-outline-warning text-dark btn-sm rounded-pill px-3 fw-semibold">
                            <i class="ri-shield-star-line me-1"></i> Download Vector Badge (SVG)
                        </a>

                        <a href="{{ route('certificates.pdf', $certificate->id) }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-semibold">
                            <i class="ri-file-pdf-line me-1"></i> Download Certificate (PDF)
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
