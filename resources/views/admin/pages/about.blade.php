@extends('layouts.admin')

@section('page_title', 'About Us Page — Content Plugin')

@section('content')
<div class="container-fluid p-0">

    <!-- Top Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="{{ route('admin.pages.index') }}" class="text-muted text-xs text-decoration-none">
                    <i class="ri-arrow-left-line"></i> Pages &amp; Plugins
                </a>
                <span class="text-muted text-xs">/</span>
                <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill text-xs px-2.5 py-0.5 fw-semibold">About Plugin</span>
            </div>
            <h4 class="fw-bold text-dark mb-0 text-uppercase" style="letter-spacing: 0.6px; font-size: 1.15rem;">About Us Page Settings</h4>
            <p class="text-muted text-xs mb-0">Configure the ministry hero introduction, mission paragraphs, key achievement counters, and featured study photo</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('about') }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-3 px-3 py-1.5 text-xs d-inline-flex align-items-center gap-1.5">
                <i class="ri-external-link-line"></i> View Live About Page
            </a>
            <a href="{{ route('admin.pages.contact') }}" class="btn btn-sm btn-light border rounded-3 px-3 py-1.5 text-xs d-inline-flex align-items-center gap-1.5">
                <i class="ri-customer-service-2-line"></i> Switch to Contact Page
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

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2 mb-1">
                <i class="ri-error-warning-fill fs-5 text-danger"></i>
                <div class="fw-semibold text-sm">Please correct the following errors:</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <ul class="mb-0 text-xs ps-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <!-- Main Form Column -->
        <div class="col-12 col-xl-8">
            <form action="{{ route('admin.pages.about.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Card 1: Hero Titles & Badge -->
                <div class="card border-0 shadow-sm rounded-3 bg-white mb-4">
                    <div class="card-header bg-transparent border-bottom border-light pt-4 px-4 pb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="ri-t-box-line"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Hero Headlines &amp; Tagline</h6>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label text-xs fw-semibold text-dark">Background Badge Title</label>
                                <input type="text" name="badge_title" class="form-control" value="{{ old('badge_title', $aboutSetting->badge_title) }}" placeholder="e.g. About">
                                <span class="text-muted text-xs">Faded watermark title above heading</span>
                            </div>

                            <div class="col-12 col-md-8">
                                <label class="form-label text-xs fw-semibold text-dark">Heading Main Text <span class="text-danger">*</span></label>
                                <input type="text" name="heading_prefix" class="form-control" value="{{ old('heading_prefix', $aboutSetting->heading_prefix) }}" placeholder="e.g. Our Techniques Crucial To Learn If You're Going" required>
                                <span class="text-muted text-xs">Primary bold headline</span>
                            </div>

                            <div class="col-12">
                                <label class="form-label text-xs fw-semibold text-dark">Heading Highlight (Colored Accent)</label>
                                <input type="text" name="heading_highlight" class="form-control" value="{{ old('heading_highlight', $aboutSetting->heading_highlight) }}" placeholder="e.g. To Explore In Learning">
                                <span class="text-muted text-xs">This portion is rendered with brand accent color</span>
                            </div>

                            <div class="col-12">
                                <label class="form-label text-xs fw-semibold text-dark">Primary Description Paragraph <span class="text-danger">*</span></label>
                                <textarea name="description_1" rows="3" class="form-control" placeholder="Introduce the mission and core spiritual values" required>{{ old('description_1', $aboutSetting->description_1) }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label text-xs fw-semibold text-dark">Secondary Description Paragraph</label>
                                <textarea name="description_2" rows="3" class="form-control" placeholder="Optional secondary explanatory paragraph">{{ old('description_2', $aboutSetting->description_2) }}</textarea>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label text-xs fw-semibold text-dark">Action Button Label</label>
                                <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $aboutSetting->button_text) }}" placeholder="e.g. LEARN MORE">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label text-xs fw-semibold text-dark">Action Button Link</label>
                                <input type="text" name="button_link" class="form-control" value="{{ old('button_link', $aboutSetting->button_link) }}" placeholder="e.g. /courses">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Key Achievement Metrics / Counters -->
                <div class="card border-0 shadow-sm rounded-3 bg-white mb-4">
                    <div class="card-header bg-transparent border-bottom border-light pt-4 px-4 pb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="ri-bar-chart-box-line"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Record Achievement Counters (Banner Grid)</h6>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted text-xs mb-3">These 4 animated numbers display across the About page milestone band:</p>
                        <div class="row g-3">
                            <!-- Stat 1 -->
                            <div class="col-12 col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <label class="form-label text-xs fw-semibold text-dark mb-1">Metric 1</label>
                                    <div class="row g-2">
                                        <div class="col-5">
                                            <input type="text" name="stat_projects_count" class="form-control form-control-sm" value="{{ old('stat_projects_count', $aboutSetting->stat_projects_count) }}" placeholder="200">
                                            <span class="text-muted text-xs">Number</span>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" name="stat_projects_label" class="form-control form-control-sm" value="{{ old('stat_projects_label', $aboutSetting->stat_projects_label) }}" placeholder="Projects Finished">
                                            <span class="text-muted text-xs">Label</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stat 2 -->
                            <div class="col-12 col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <label class="form-label text-xs fw-semibold text-dark mb-1">Metric 2</label>
                                    <div class="row g-2">
                                        <div class="col-5">
                                            <input type="text" name="stat_clients_count" class="form-control form-control-sm" value="{{ old('stat_clients_count', $aboutSetting->stat_clients_count) }}" placeholder="199">
                                            <span class="text-muted text-xs">Number</span>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" name="stat_clients_label" class="form-control form-control-sm" value="{{ old('stat_clients_label', $aboutSetting->stat_clients_label) }}" placeholder="Satisfied Clients">
                                            <span class="text-muted text-xs">Label</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stat 3 -->
                            <div class="col-12 col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <label class="form-label text-xs fw-semibold text-dark mb-1">Metric 3</label>
                                    <div class="row g-2">
                                        <div class="col-5">
                                            <input type="text" name="stat_students_count" class="form-control form-control-sm" value="{{ old('stat_students_count', $aboutSetting->stat_students_count) }}" placeholder="150">
                                            <span class="text-muted text-xs">Number</span>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" name="stat_students_label" class="form-control form-control-sm" value="{{ old('stat_students_label', $aboutSetting->stat_students_label) }}" placeholder="Online Students">
                                            <span class="text-muted text-xs">Label</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stat 4 -->
                            <div class="col-12 col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <label class="form-label text-xs fw-semibold text-dark mb-1">Metric 4</label>
                                    <div class="row g-2">
                                        <div class="col-5">
                                            <input type="text" name="stat_years_count" class="form-control form-control-sm" value="{{ old('stat_years_count', $aboutSetting->stat_years_count) }}" placeholder="20">
                                            <span class="text-muted text-xs">Number</span>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" name="stat_years_label" class="form-control form-control-sm" value="{{ old('stat_years_label', $aboutSetting->stat_years_label) }}" placeholder="Years of Experience">
                                            <span class="text-muted text-xs">Label</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2.5: Ministry Pillars / How We Help Section -->
                <div class="card border-0 shadow-sm rounded-3 bg-white mb-4">
                    <div class="card-header bg-transparent border-bottom border-light pt-4 px-4 pb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-purple-subtle text-purple d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #f3e8ff; color: #9333ea;">
                                <i class="ri-compass-3-line"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Ministry Pillars &amp; Help Section</h6>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-4">
                                <label class="form-label text-xs fw-semibold text-dark">Section Title Prefix</label>
                                <input type="text" name="help_title" class="form-control" value="{{ old('help_title', $aboutSetting->help_title) }}" placeholder="How Can We">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label text-xs fw-semibold text-dark">Title Highlight (Accent)</label>
                                <input type="text" name="help_title_highlight" class="form-control" value="{{ old('help_title_highlight', $aboutSetting->help_title_highlight) }}" placeholder="Help">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label text-xs fw-semibold text-dark">Title Suffix</label>
                                <input type="text" name="help_title_suffix" class="form-control" value="{{ old('help_title_suffix', $aboutSetting->help_title_suffix) }}" placeholder="You">
                            </div>
                        </div>

                        <p class="text-muted text-xs fw-semibold text-uppercase mb-2">4 Ministry Pillars / Cards:</p>
                        <div class="row g-3">
                            <!-- Pillar 1 -->
                            <div class="col-12 col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <label class="form-label text-xs fw-bold text-dark mb-1">Pillar 1</label>
                                    <input type="text" name="feature_1_title" class="form-control form-control-sm mb-2" value="{{ old('feature_1_title', $aboutSetting->feature_1_title) }}" placeholder="Pillar Title">
                                    <textarea name="feature_1_desc" rows="2" class="form-control form-control-sm" placeholder="Description">{{ old('feature_1_desc', $aboutSetting->feature_1_desc) }}</textarea>
                                </div>
                            </div>
                            <!-- Pillar 2 -->
                            <div class="col-12 col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <label class="form-label text-xs fw-bold text-dark mb-1">Pillar 2</label>
                                    <input type="text" name="feature_2_title" class="form-control form-control-sm mb-2" value="{{ old('feature_2_title', $aboutSetting->feature_2_title) }}" placeholder="Pillar Title">
                                    <textarea name="feature_2_desc" rows="2" class="form-control form-control-sm" placeholder="Description">{{ old('feature_2_desc', $aboutSetting->feature_2_desc) }}</textarea>
                                </div>
                            </div>
                            <!-- Pillar 3 -->
                            <div class="col-12 col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <label class="form-label text-xs fw-bold text-dark mb-1">Pillar 3</label>
                                    <input type="text" name="feature_3_title" class="form-control form-control-sm mb-2" value="{{ old('feature_3_title', $aboutSetting->feature_3_title) }}" placeholder="Pillar Title">
                                    <textarea name="feature_3_desc" rows="2" class="form-control form-control-sm" placeholder="Description">{{ old('feature_3_desc', $aboutSetting->feature_3_desc) }}</textarea>
                                </div>
                            </div>
                            <!-- Pillar 4 -->
                            <div class="col-12 col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <label class="form-label text-xs fw-bold text-dark mb-1">Pillar 4</label>
                                    <input type="text" name="feature_4_title" class="form-control form-control-sm mb-2" value="{{ old('feature_4_title', $aboutSetting->feature_4_title) }}" placeholder="Pillar Title">
                                    <textarea name="feature_4_desc" rows="2" class="form-control form-control-sm" placeholder="Description">{{ old('feature_4_desc', $aboutSetting->feature_4_desc) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Featured Photo Upload -->
                <div class="card border-0 shadow-sm rounded-3 bg-white mb-4">
                    <div class="card-header bg-transparent border-bottom border-light pt-4 px-4 pb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="ri-image-line"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Featured About Section Image</h6>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start gap-4 flex-wrap flex-md-nowrap">
                            <div class="rounded-3 border overflow-hidden position-relative flex-shrink-0 bg-light d-flex align-items-center justify-content-center" style="width: 140px; height: 110px;">
                                <img src="{{ $aboutSetting->about_image_url }}" alt="About image" id="aboutImagePreview" class="w-100 h-100 object-fit-cover">
                            </div>
                            <div class="flex-grow-1">
                                <label class="form-label text-xs fw-semibold text-dark">Upload New Featured Image</label>
                                <input type="file" name="about_image" id="aboutImageInput" accept="image/jpeg,image/png,image/webp,image/jpg" class="form-control">
                                <p class="text-muted text-xs mt-1 mb-0">Recommended size: 650x550px. JPG, PNG or WEBP up to 5MB. Leave empty to keep existing image.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button Bar -->
                <div class="d-flex align-items-center justify-content-between p-3 bg-white rounded-3 border-0 shadow-sm">
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary rounded-3 text-xs px-3 py-2">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary rounded-3 text-xs fw-semibold px-4 py-2 d-inline-flex align-items-center gap-1.5" style="background-color: #2563eb; border-color: #2563eb;">
                        <i class="ri-save-line fs-6"></i> Save About Us Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Live Website Preview Column -->
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 bg-white sticky-top" style="top: 90px;">
                <div class="card-header bg-transparent border-bottom border-light pt-4 px-4 pb-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill text-xs px-2 py-0.5">Live Preview</span>
                        <h6 class="fw-bold text-dark mb-0">About Section Simulation</h6>
                    </div>
                    <i class="ri-eye-line text-muted"></i>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted text-xs mb-3">Live visualization of how disciples see the About page:</p>

                    <!-- Preview Container -->
                    <div class="p-3 rounded-3 border bg-light-subtle">
                        <div class="mb-2">
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill text-xs px-2 py-0.5">{{ $aboutSetting->badge_title ?? 'About' }}</span>
                        </div>
                        <h6 class="fw-bold text-dark mb-2" style="font-size: 0.95rem; line-height: 1.4;">
                            {{ $aboutSetting->heading_prefix ?? "Our Techniques Crucial To Learn If You're Going" }}
                            <span class="text-primary">{{ $aboutSetting->heading_highlight ?? 'To Explore In Learning' }}</span>
                        </h6>
                        <p class="text-muted text-xs mb-3" style="line-height: 1.5;">
                            {{ Str::limit($aboutSetting->description_1, 140) }}
                        </p>

                        <!-- Button Preview -->
                        <div class="mb-3">
                            <span class="btn btn-sm btn-primary rounded-2 text-xs py-1 px-2.5" style="background-color: #2563eb; font-size: 11px;">
                                {{ $aboutSetting->button_text ?? 'LEARN MORE' }} <i class="ri-arrow-right-line ms-1"></i>
                            </span>
                        </div>

                        <!-- Milestone Counters Preview -->
                        <div class="pt-3 border-top">
                            <span class="text-muted text-xs fw-semibold text-uppercase d-block mb-2">Milestone Band Preview:</span>
                            <div class="row g-2 text-center">
                                <div class="col-6">
                                    <div class="p-2 rounded bg-white border">
                                        <div class="fw-bold text-primary fs-6">{{ $aboutSetting->stat_projects_count ?? '200' }}+</div>
                                        <div class="text-muted text-xs" style="font-size: 10px;">{{ $aboutSetting->stat_projects_label ?? 'Projects' }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 rounded bg-white border">
                                        <div class="fw-bold text-primary fs-6">{{ $aboutSetting->stat_students_count ?? '150' }}+</div>
                                        <div class="text-muted text-xs" style="font-size: 10px;">{{ $aboutSetting->stat_students_label ?? 'Students' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 text-center">
                        <a href="{{ route('about') }}" target="_blank" class="btn btn-sm btn-link text-xs text-primary text-decoration-none">
                            <i class="ri-external-link-line me-1"></i> Open Live About Page in New Tab
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.getElementById('aboutImageInput')?.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('aboutImagePreview');
                if (preview) {
                    preview.src = event.target.result;
                }
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endsection
