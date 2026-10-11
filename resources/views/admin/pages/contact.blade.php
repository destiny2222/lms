@extends('layouts.admin')

@section('page_title', 'Contact Us Page — Content Plugin')

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
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill text-xs px-2.5 py-0.5 fw-semibold">Contact Plugin</span>
            </div>
            <h4 class="fw-bold text-dark mb-0 text-uppercase" style="letter-spacing: 0.6px; font-size: 1.15rem;">Contact Us Page Settings</h4>
            <p class="text-muted text-xs mb-0">Edit telephone contacts, email, physical church location, ministry hours, and contact section graphics</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('contact') }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-3 px-3 py-1.5 text-xs d-inline-flex align-items-center gap-1.5">
                <i class="ri-external-link-line"></i> View Live Contact Page
            </a>
            <a href="{{ route('admin.pages.about') }}" class="btn btn-sm btn-light border rounded-3 px-3 py-1.5 text-xs d-inline-flex align-items-center gap-1.5">
                <i class="ri-information-line"></i> Switch to About Page
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
            <form action="{{ route('admin.pages.contact.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Card 0: Section Titles & Form Headings -->
                <div class="card border-0 shadow-sm rounded-3 bg-white mb-4">
                    <div class="card-header bg-transparent border-bottom border-light pt-4 px-4 pb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="ri-t-box-line"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Page Headings &amp; Titles</h6>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label text-xs fw-semibold text-dark">Section Main Title <span class="text-danger">*</span></label>
                                <input type="text" name="section_title" class="form-control" value="{{ old('section_title', $contactSetting->section_title) }}" placeholder="e.g. For More Information Get In" required>
                                <span class="text-muted text-xs">Heading above the contact information options</span>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label text-xs fw-semibold text-dark">Section Title Highlight (Accent Color)</label>
                                <input type="text" name="section_title_highlight" class="form-control" value="{{ old('section_title_highlight', $contactSetting->section_title_highlight) }}" placeholder="e.g. Touch With RACAi Discipleship">
                                <span class="text-muted text-xs">Part of the title highlighted in brand blue</span>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label text-xs fw-semibold text-dark">Message Form Title <span class="text-danger">*</span></label>
                                <input type="text" name="form_title" class="form-control" value="{{ old('form_title', $contactSetting->form_title) }}" placeholder="e.g. Leave A Message" required>
                                <span class="text-muted text-xs">Heading on the contact form container</span>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label text-xs fw-semibold text-dark">Message Form Subtitle</label>
                                <input type="text" name="form_subtitle" class="form-control" value="{{ old('form_subtitle', $contactSetting->form_subtitle) }}" placeholder="e.g. Your email address will not be published. Required fields are marked *">
                                <span class="text-muted text-xs">Subtext shown below the form title</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 1: Phone Numbers & Email -->
                <div class="card border-0 shadow-sm rounded-3 bg-white mb-4">
                    <div class="card-header bg-transparent border-bottom border-light pt-4 px-4 pb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="ri-phone-line"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Phone &amp; Electronic Communication</h6>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label text-xs fw-semibold text-dark">Primary Mobile Phone <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="ri-cellphone-line"></i></span>
                                    <input type="text" name="phone_primary" class="form-control border-start-0" value="{{ old('phone_primary', $contactSetting->phone_primary) }}" placeholder="e.g. 800 388 80 90" required>
                                </div>
                                <span class="text-muted text-xs">Shown as main call number on contact page</span>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label text-xs fw-semibold text-dark">Secondary Hotline Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="ri-phone-fill"></i></span>
                                    <input type="text" name="phone_secondary" class="form-control border-start-0" value="{{ old('phone_secondary', $contactSetting->phone_secondary) }}" placeholder="e.g. 1800 1102">
                                </div>
                                <span class="text-muted text-xs">Optional secondary helpline or emergency desk</span>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label text-xs fw-semibold text-dark">Contact / Support Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="ri-mail-line"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0" value="{{ old('email', $contactSetting->email) }}" placeholder="e.g. support@racaitraining.org" required>
                                </div>
                                <span class="text-muted text-xs">Inquiries sent from the contact form are delivered here</span>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label text-xs fw-semibold text-dark">WhatsApp Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-success"><i class="ri-whatsapp-line"></i></span>
                                    <input type="text" name="whatsapp_number" class="form-control border-start-0" value="{{ old('whatsapp_number', $contactSetting->whatsapp_number) }}" placeholder="e.g. +2348079730678">
                                </div>
                                <span class="text-muted text-xs">Direct click-to-chat WhatsApp link for disciples</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Physical Address & Hours -->
                <div class="card border-0 shadow-sm rounded-3 bg-white mb-4">
                    <div class="card-header bg-transparent border-bottom border-light pt-4 px-4 pb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="ri-map-pin-line"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Location &amp; Operating Hours</h6>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label text-xs fw-semibold text-dark">Physical Ministry / Office Address <span class="text-danger">*</span></label>
                                <textarea name="address" rows="3" class="form-control" placeholder="Enter church or ministry headquarters address" required>{{ old('address', $contactSetting->address) }}</textarea>
                                <span class="text-muted text-xs">Displays under the Network icon on the contact page</span>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label text-xs fw-semibold text-dark">Weekday Hours (Monday - Friday)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="ri-time-line"></i></span>
                                    <input type="text" name="weekday_hours" class="form-control border-start-0" value="{{ old('weekday_hours', $contactSetting->weekday_hours) }}" placeholder="e.g. 09:00 am - 5:00 pm">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label text-xs fw-semibold text-dark">Weekend Hours (Saturday - Sunday)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="ri-calendar-line"></i></span>
                                    <input type="text" name="weekend_hours" class="form-control border-start-0" value="{{ old('weekend_hours', $contactSetting->weekend_hours) }}" placeholder="e.g. 10:30 am - 1:00 pm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Banner Image Upload -->
                <div class="card border-0 shadow-sm rounded-3 bg-white mb-4">
                    <div class="card-header bg-transparent border-bottom border-light pt-4 px-4 pb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="ri-image-line"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Contact Section Featured Image</h6>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start gap-4 flex-wrap flex-md-nowrap">
                            <div class="rounded-3 border overflow-hidden position-relative flex-shrink-0 bg-light d-flex align-items-center justify-content-center" style="width: 140px; height: 110px;">
                                <img src="{{ $contactSetting->contact_image_url }}" alt="Contact image" id="contactImagePreview" class="w-100 h-100 object-fit-cover">
                            </div>
                            <div class="flex-grow-1">
                                <label class="form-label text-xs fw-semibold text-dark">Upload New Contact Image</label>
                                <input type="file" name="contact_image" id="contactImageInput" accept="image/jpeg,image/png,image/webp,image/jpg" class="form-control">
                                <p class="text-muted text-xs mt-1 mb-0">Recommended size: 600x500px. JPG, PNG or WEBP up to 5MB. Leave empty to keep existing image.</p>
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
                        <i class="ri-save-line fs-6"></i> Save Contact Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Live Website Preview Column -->
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 bg-white sticky-top" style="top: 90px;">
                <div class="card-header bg-transparent border-bottom border-light pt-4 px-4 pb-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill text-xs px-2 py-0.5">Live Preview</span>
                        <h6 class="fw-bold text-dark mb-0">Frontend Contact Block</h6>
                    </div>
                    <i class="ri-eye-line text-muted"></i>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted text-xs mb-3">Here is an exact simulation of how your contact details appear to visitors:</p>

                    <!-- Simulation Box -->
                    <div class="p-3 rounded-3 border bg-light-subtle">
                        <div class="mb-3">
                            <span class="badge bg-primary text-white text-xs px-2 py-0.5 rounded-pill mb-1">Get in Touch</span>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">
                                {{ $contactSetting->section_title ?? 'For More Information Get In' }} <span class="text-primary">{{ $contactSetting->section_title_highlight ?? 'Touch With RACAi Discipleship' }}</span>
                            </h6>
                        </div>

                        <!-- Option 1: Phone -->
                        <div class="d-flex align-items-start gap-2.5 mb-3 p-2 rounded-2 bg-white border border-light">
                            <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                <i class="ri-phone-line text-xs"></i>
                            </div>
                            <div class="text-xs">
                                <div><span class="text-muted">Mobile:</span> <strong class="text-primary">{{ $contactSetting->phone_primary ?? '800 388 80 90' }}</strong></div>
                                @if(!empty($contactSetting->phone_secondary))
                                    <div><span class="text-muted">Hotline:</span> <strong>{{ $contactSetting->phone_secondary }}</strong></div>
                                @endif
                                <div><span class="text-muted">Email:</span> <span class="text-dark">{{ $contactSetting->email ?? 'support@racaitraining.org' }}</span></div>
                            </div>
                        </div>

                        <!-- Option 2: Address -->
                        <div class="d-flex align-items-start gap-2.5 mb-3 p-2 rounded-2 bg-white border border-light">
                            <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                <i class="ri-map-pin-line text-xs"></i>
                            </div>
                            <div class="text-xs">
                                <span class="text-dark">{{ $contactSetting->address ?? 'Rock of Ages Christian Assembly (RACAi), Benin City, Nigeria' }}</span>
                            </div>
                        </div>

                        <!-- Option 3: Working Hours -->
                        <div class="d-flex align-items-start gap-2.5 mb-3 p-2 rounded-2 bg-white border border-light">
                            <div class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                <i class="ri-time-line text-xs"></i>
                            </div>
                            <div class="text-xs">
                                <div><span class="text-muted">Mon - Fri:</span> <strong>{{ $contactSetting->weekday_hours ?? '09:00 am - 5:00 pm' }}</strong></div>
                                @if(!empty($contactSetting->weekend_hours))
                                    <div><span class="text-muted">Sat &amp; Sun:</span> <strong>{{ $contactSetting->weekend_hours }}</strong></div>
                                @endif
                            </div>
                        </div>

                        <!-- Option 4: WhatsApp -->
                        @if(!empty($contactSetting->whatsapp_number))
                            <div class="d-flex align-items-start gap-2.5 p-2 rounded-2 bg-white border border-light">
                                <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                    <i class="ri-whatsapp-line text-xs"></i>
                                </div>
                                <div class="text-xs">
                                    <span class="text-muted">WhatsApp:</span> <strong class="text-success">{{ $contactSetting->whatsapp_number }}</strong>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-3 text-center">
                        <a href="{{ route('contact') }}" target="_blank" class="btn btn-sm btn-link text-xs text-primary text-decoration-none">
                            <i class="ri-external-link-line me-1"></i> Open Live Contact Page in New Tab
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.getElementById('contactImageInput')?.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('contactImagePreview');
                if (preview) {
                    preview.src = event.target.result;
                }
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endsection
