@extends('layouts.admin')

@section('page_title', 'Pages & Plugins — Website Content Management')

@section('content')
<div class="container-fluid p-0">

    <!-- Top Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill text-xs px-2.5 py-0.5 fw-semibold">CMS Engine</span>
                <span class="text-muted text-xs">Website Pages &amp; Content Plugins</span>
            </div>
            <h4 class="fw-bold text-dark mb-0 text-uppercase" style="letter-spacing: 0.6px; font-size: 1.15rem;">Pages &amp; Plugins Management</h4>
            <p class="text-muted text-xs mb-0">Configure and customize dynamic public front-facing pages directly from your administration console without writing code</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-3 px-3 py-1.5 text-xs d-inline-flex align-items-center gap-1.5">
                <i class="ri-external-link-line"></i> View Main Website
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert" style="background-color: #ecfdf5; color: #065f46;">
            <i class="ri-checkbox-circle-fill fs-5 text-success"></i>
            <div class="fw-medium text-sm">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Navigation Pills / Tab Switcher -->
    <div class="card border-0 shadow-sm rounded-3 mb-4 p-2 bg-white">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-sm btn-primary rounded-pill px-3 py-1.5 text-xs fw-semibold d-inline-flex align-items-center gap-1.5">
                <i class="ri-apps-2-line"></i> All Plugins &amp; Pages ({{ count($plugins) }})
            </a>
            <a href="{{ route('admin.pages.contact') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1.5 text-xs fw-medium d-inline-flex align-items-center gap-1.5">
                <i class="ri-customer-service-2-line text-primary"></i> Contact Us Page
            </a>
            <a href="{{ route('admin.pages.about') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1.5 text-xs fw-medium d-inline-flex align-items-center gap-1.5">
                <i class="ri-information-line text-info"></i> About Us Page
            </a>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1.5 text-xs fw-medium d-inline-flex align-items-center gap-1.5">
                <i class="ri-chat-quote-line text-purple" style="color: #8b5cf6;"></i> Testimonials
            </a>
        </div>
    </div>

    <!-- Plugins Grid -->
    <div class="row g-4 mb-4">
        @foreach($plugins as $plugin)
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-3 bg-white h-100 plugin-card transition-all position-relative overflow-hidden">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2 d-flex align-items-start justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="plugin-icon-wrap rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: {{ $plugin['color'] }}15; color: {{ $plugin['color'] }};">
                                <i class="{{ $plugin['icon'] }} fs-4"></i>
                            </div>
                            <div>
                                <span class="badge bg-light text-muted border text-xs px-2 py-0.5 rounded-pill mb-1">{{ $plugin['type'] }}</span>
                                <h5 class="fw-bold text-dark mb-0 fs-6">{{ $plugin['name'] }}</h5>
                            </div>
                        </div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill text-xs px-2.5 py-1">
                            <i class="ri-checkbox-circle-fill me-1"></i> {{ $plugin['status'] }}
                        </span>
                    </div>

                    <div class="card-body px-4 py-3">
                        <p class="text-muted text-xs mb-3" style="min-height: 38px; line-height: 1.55;">
                            {{ $plugin['description'] }}
                        </p>

                        <div class="p-3 rounded-3 bg-light border border-light-subtle mb-3">
                            @if($plugin['id'] === 'contact')
                                <div class="d-flex justify-content-between align-items-center mb-1 text-xs">
                                    <span class="text-muted"><i class="ri-phone-line me-1"></i> Primary Phone:</span>
                                    <span class="fw-semibold text-dark">{{ $contactSetting->phone_primary ?? '800 388 80 90' }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1 text-xs">
                                    <span class="text-muted"><i class="ri-mail-line me-1"></i> Support Email:</span>
                                    <span class="fw-semibold text-dark text-truncate ms-2" style="max-width: 170px;">{{ $contactSetting->email ?? 'support@racaitraining.org' }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center text-xs">
                                    <span class="text-muted"><i class="ri-whatsapp-line me-1 text-success"></i> WhatsApp:</span>
                                    <span class="fw-semibold text-dark">{{ $contactSetting->whatsapp_number ?? 'Configured' }}</span>
                                </div>
                            @elseif($plugin['id'] === 'about')
                                <div class="d-flex justify-content-between align-items-center mb-1 text-xs">
                                    <span class="text-muted"><i class="ri-medal-line me-1"></i> Projects Finished:</span>
                                    <span class="fw-semibold text-dark">{{ $aboutSetting->stat_projects_count ?? '200' }}+</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1 text-xs">
                                    <span class="text-muted"><i class="ri-team-line me-1"></i> Online Students:</span>
                                    <span class="fw-semibold text-dark">{{ $aboutSetting->stat_students_count ?? '150' }}+</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center text-xs">
                                    <span class="text-muted"><i class="ri-time-line me-1"></i> Years Experience:</span>
                                    <span class="fw-semibold text-dark">{{ $aboutSetting->stat_years_count ?? '20' }}+</span>
                                </div>
                            @elseif($plugin['id'] === 'testimonials')
                                <div class="d-flex justify-content-between align-items-center mb-1 text-xs">
                                    <span class="text-muted"><i class="ri-chat-1-line me-1"></i> Total Testimonies:</span>
                                    <span class="fw-semibold text-dark">{{ \App\Models\Testimonial::count() }} items</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1 text-xs">
                                    <span class="text-muted"><i class="ri-check-line me-1 text-success"></i> Active Published:</span>
                                    <span class="fw-semibold text-success">{{ \App\Models\Testimonial::where('is_active', true)->count() }} active</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center text-xs">
                                    <span class="text-muted"><i class="ri-star-line me-1 text-warning"></i> Average Rating:</span>
                                    <span class="fw-semibold text-dark">5.0 ★</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer bg-transparent border-top border-light px-4 py-3 d-flex align-items-center justify-content-between">
                        <a href="{{ $plugin['public_url'] }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-3 text-xs d-inline-flex align-items-center gap-1">
                            <i class="ri-external-link-line"></i> View Page
                        </a>
                        <a href="{{ $plugin['route'] }}" class="btn btn-sm btn-primary rounded-3 text-xs fw-semibold px-3 py-1.5 d-inline-flex align-items-center gap-1.5" style="background-color: #2563eb; border-color: #2563eb;">
                            <i class="ri-settings-3-line"></i> Edit Content
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Info Banner Card -->
    <div class="card border-0 shadow-sm rounded-3 bg-white p-4">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                <i class="ri-information-line fs-4"></i>
            </div>
            <div>
                <h6 class="fw-bold text-dark mb-1">Instant Frontend Synchronization</h6>
                <p class="text-muted text-xs mb-0">Changes saved inside any of these plugins immediately reflect on the live discipleship public portal. Custom banner images are optimized and stored through secure cloud storage.</p>
            </div>
        </div>
    </div>

</div>

<style>
    .plugin-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid rgba(226, 232, 240, 0.8) !important;
    }
    .plugin-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04) !important;
    }
</style>
@endsection
