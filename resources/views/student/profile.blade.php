@extends('layouts.student-dash')

@section('title', 'My Profile & Account Settings — Authority LMS')

@section('content')
<!-- ========================================== -->
<!-- BREADCRUMB & HEADER -->
<!-- ========================================== -->
<div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <div>
        <h1 class="fw-semibold mb-4 h5 text-primary-light">My Profile & Account Settings</h1>
        <div class="text-xs">
            <a href="{{ route('student.dashboard') }}" class="text-secondary-light hover-text-primary hover-underline">Dashboard</a>
            <span class="text-secondary-light">/ Edit Profile</span>
        </div>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('student.courses') }}" class="btn btn-outline-primary-600 btn-sm radius-8 d-flex align-items-center gap-6 px-16 py-8 fw-semibold">
            <i class="ri-book-read-line"></i> My Enrolled Courses
        </a>
    </div>
</div>

<div class="row gy-4">
    <!-- ========================================== -->
    <!-- LEFT COLUMN: PROFILE CARD SUMMARY -->
    <!-- ========================================== -->
    <div class="col-lg-4 col-xl-3">
        <div class="card border-0 shadow-1 radius-16 bg-white overflow-hidden text-center p-24 mb-24">
            <!-- Avatar Display -->
            <div class="position-relative d-inline-block mx-auto mb-16">
                @if($user->avatar_url)
                    <img id="avatar-preview-side" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                         class="w-120-px h-120-px rounded-circle object-fit-cover shadow-sm border border-3 border-primary-100">
                @else
                    <div id="avatar-preview-side-fallback" 
                         class="w-120-px h-120-px rounded-circle bg-primary-600 text-white d-flex align-items-center justify-content-center fw-bold fs-1 shadow-sm border border-3 border-primary-100">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <label for="avatar-input" class="position-absolute bottom-0 end-0 w-36-px h-36-px rounded-circle bg-primary-600 text-white d-flex align-items-center justify-content-center cursor-pointer shadow border border-2 border-white hover-bg-primary-700" title="Change Avatar">
                    <i class="ri-camera-fill fs-6"></i>
                </label>
            </div>

            <!-- Name and Role -->
            <h5 class="fw-bold text-dark mb-4">{{ $user->name }}</h5>
            <p class="text-xs text-secondary-light mb-12">{{ $user->email }}</p>

            <div class="mb-16">
                @if($user->hasRole('admin'))
                    <span class="badge bg-danger-subtle text-danger px-12 py-6 rounded-pill text-xs fw-semibold">
                        <i class="ri-shield-check-fill me-1"></i> System Administrator
                    </span>
                @elseif($user->hasRole('tutor'))
                    <span class="badge bg-info-subtle text-info px-12 py-6 rounded-pill text-xs fw-semibold">
                        <i class="ri-user-star-fill me-1"></i> Certified Instructor
                    </span>
                @else
                    <span class="badge bg-primary-subtle text-primary px-12 py-6 rounded-pill text-xs fw-semibold">
                        <i class="ri-user-smile-fill me-1"></i> Active Learner
                    </span>
                @endif
            </div>

            <!-- Quick Stats -->
            <div class="border-top border-bottom border-neutral-200 py-16 mb-20">
                <div class="row g-2">
                    <div class="col-4">
                        <h6 class="mb-0 fw-bold text-dark">{{ $enrolledCount }}</h6>
                        <span class="text-secondary-light text-xxs text-uppercase fw-semibold">Courses</span>
                    </div>
                    <div class="col-4 border-start border-end border-neutral-200">
                        <h6 class="mb-0 fw-bold text-dark">{{ $completedCount }}</h6>
                        <span class="text-secondary-light text-xxs text-uppercase fw-semibold">Passed</span>
                    </div>
                    <div class="col-4">
                        <h6 class="mb-0 fw-bold text-dark">{{ $certificatesCount }}</h6>
                        <span class="text-secondary-light text-xxs text-uppercase fw-semibold">Badges</span>
                    </div>
                </div>
            </div>

             
        </div>
    </div>

    <!-- ========================================== -->
    <!-- RIGHT COLUMN: EDIT PROFILE FORMS -->
    <!-- ========================================== -->
    <div class="col-lg-8 col-xl-9">
        <!-- Navigation Tabs -->
        <div class="card border-0 shadow-1 radius-16 bg-white overflow-hidden mb-24">
            <div class="card-header bg-white border-bottom p-0">
                <ul class="nav nav-tabs border-0 px-20 pt-12 gap-3" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold text-sm border-0 border-bottom border-3 border-primary-600 pb-12 px-12 bg-transparent text-primary-600" 
                                id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal-content" type="button" role="tab">
                            <i class="ri-user-3-line me-1"></i> Personal & Learning Profile
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold text-sm border-0 pb-12 px-12 bg-transparent text-secondary-light" 
                                id="security-tab" data-bs-toggle="tab" data-bs-target="#security-content" type="button" role="tab">
                            <i class="ri-lock-password-line me-1"></i> Password & Security
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-24">
                <div class="tab-content" id="profileTabContent">
                    <!-- ========================================== -->
                    <!-- TAB 1: PERSONAL & LEARNING PROFILE -->
                    <!-- ========================================== -->
                    <div class="tab-pane fade show active" id="personal-content" role="tabpanel" aria-labelledby="personal-tab">
                        <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Avatar Upload Section -->
                            <div class="mb-24 pb-24 border-bottom border-neutral-200">
                                <label class="form-label fw-bold text-sm text-primary-light mb-8">Profile Photo / Avatar</label>
                                <div class="d-flex align-items-center gap-16 flex-wrap">
                                    {{-- <div class="position-relative">
                                        @if($user->avatar_url)
                                            <img id="avatar-preview-form" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                                                 class="w-80-px h-80-px rounded-circle object-fit-cover border border-2 border-primary-100">
                                        @else
                                            <div id="avatar-preview-form-fallback" 
                                                 class="w-80-px h-80-px rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold fs-3 border border-2 border-primary-100">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div> --}}
                                    <div class="flex-grow-1">
                                        <input type="file" name="avatar" id="avatar-input" class="form-control radius-8 text-xs @error('avatar') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,image/webp">
                                        <span class="text-xxs text-secondary-light d-block mt-4">Accepted: JPG, PNG, WebP (Max: 2MB). Ideal dimensions: 300x300px.</span>
                                        @error('avatar')
                                            <div class="invalid-feedback text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row gy-3">
                                <!-- Full Name -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label text-sm fw-semibold text-primary-light mb-6">Full Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-neutral-50 border-neutral-200 text-secondary-light">
                                            <i class="ri-user-line"></i>
                                        </span>
                                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required 
                                               class="form-control radius-end-8 text-sm @error('name') is-invalid @enderror" placeholder="Your full name">
                                    </div>
                                    @error('name')
                                        <span class="text-danger text-xs mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email Address -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label text-sm fw-semibold text-primary-light mb-6">Email Address <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-neutral-50 border-neutral-200 text-secondary-light">
                                            <i class="ri-mail-line"></i>
                                        </span>
                                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required 
                                               class="form-control radius-end-8 text-sm @error('email') is-invalid @enderror" placeholder="yourname@domain.com">
                                    </div>
                                    @error('email')
                                        <span class="text-danger text-xs mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- WhatsApp Phone Number -->
                                <div class="col-md-6">
                                    <label for="phone" class="form-label text-sm fw-semibold text-primary-light mb-6">
                                        WhatsApp Phone Number 
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-neutral-50 border-neutral-200 text-success">
                                            <i class="ri-whatsapp-line"></i>
                                        </span>
                                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                                               class="form-control radius-end-8 text-sm @error('phone') is-invalid @enderror" 
                                               placeholder="+12345678901">
                                    </div>
                                    <span class="text-xxs text-secondary-light d-block mt-4">
                                        Include country code (e.g. <code>+1...</code> or <code>+234...</code>). Used to send automated lesson reminders and certificate downloads.
                                    </span>
                                    @error('phone')
                                        <span class="text-danger text-xs mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- WhatsApp Opt-In Switch -->
                                {{-- <div class="col-md-6 d-flex align-items-center">
                                    <div class="form-check form-switch p-0 pt-md-24 d-flex align-items-center gap-3">
                                        <input class="form-check-input ms-0 me-2 cursor-pointer" type="checkbox" role="switch" id="whatsapp_opted_in" name="whatsapp_opted_in" value="1" 
                                               {{ old('whatsapp_opted_in', $user->whatsapp_opted_in) ? 'checked' : '' }} style="width: 2.75em; height: 1.5em;">
                                        <label class="form-check-label text-sm fw-semibold text-primary-light cursor-pointer" for="whatsapp_opted_in">
                                            Enable WhatsApp Accountability Bot
                                            <span class="d-block text-xxs text-secondary-light fw-normal">Receive automated progress check-ins and exam milestones via WhatsApp.</span>
                                        </label>
                                    </div>
                                </div> --}}

                                <!-- Bio / Learning Objectives -->
                                <div class="col-12">
                                    <label for="bio" class="form-label text-sm fw-semibold text-primary-light mb-6">Bio & Learning Goals</label>
                                    <textarea name="bio" id="bio" rows="4" class="form-control radius-8 text-sm @error('bio') is-invalid @enderror" 
                                              placeholder="Tell instructors and mentors about your professional background, learning targets, and career aspirations...">{{ old('bio', $user->bio) }}</textarea>
                                    <span class="text-xxs text-secondary-light d-block mt-4">Maximum 1,000 characters.</span>
                                    @error('bio')
                                        <span class="text-danger text-xs mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-3 mt-24 pt-20 border-top border-neutral-200">
                                <a href="{{ route('student.dashboard') }}" class="btn btn-neutral-100 text-secondary-light radius-8 px-20 py-10 fw-semibold">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary-600 radius-8 px-28 py-10 fw-bold d-inline-flex align-items-center gap-2 shadow-sm">
                                    <i class="ri-save-3-line"></i> Save Profile Details
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- ========================================== -->
                    <!-- TAB 2: PASSWORD & SECURITY -->
                    <!-- ========================================== -->
                    <div class="tab-pane fade" id="security-content" role="tabpanel" aria-labelledby="security-tab">
                        <form method="POST" action="{{ route('student.profile.password') }}">
                            @csrf
                            @method('PUT')

                            <div class="row gy-3 max-w-600">
                                <!-- Current Password -->
                                <div class="col-12">
                                    <label for="current_password" class="form-label text-sm fw-semibold text-primary-light mb-6">Current Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-neutral-50 border-neutral-200 text-secondary-light">
                                            <i class="ri-lock-line"></i>
                                        </span>
                                        <input type="password" name="current_password" id="current_password" required 
                                               class="form-control text-sm @error('current_password') is-invalid @enderror" placeholder="Enter your current password">
                                        <button class="input-group-text bg-neutral-50 border-neutral-200 text-secondary-light cursor-pointer" type="button" onclick="togglePasswordVisibility('current_password', this)">
                                            <i class="ri-eye-line"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <span class="text-danger text-xs mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- New Password -->
                                <div class="col-12">
                                    <label for="password" class="form-label text-sm fw-semibold text-primary-light mb-6">New Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-neutral-50 border-neutral-200 text-secondary-light">
                                            <i class="ri-key-2-line"></i>
                                        </span>
                                        <input type="password" name="password" id="password" required 
                                               class="form-control text-sm @error('password') is-invalid @enderror" placeholder="Enter new strong password">
                                        <button class="input-group-text bg-neutral-50 border-neutral-200 text-secondary-light cursor-pointer" type="button" onclick="togglePasswordVisibility('password', this)">
                                            <i class="ri-eye-line"></i>
                                        </button>
                                    </div>
                                    <span class="text-xxs text-secondary-light d-block mt-4">Must be at least 8 characters with letters, numbers, and symbols.</span>
                                    @error('password')
                                        <span class="text-danger text-xs mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-12">
                                    <label for="password_confirmation" class="form-label text-sm fw-semibold text-primary-light mb-6">Confirm New Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-neutral-50 border-neutral-200 text-secondary-light">
                                            <i class="ri-check-line"></i>
                                        </span>
                                        <input type="password" name="password_confirmation" id="password_confirmation" required 
                                               class="form-control radius-end-8 text-sm" placeholder="Repeat new password">
                                    </div>
                                </div>
                            </div>

                            <!-- Password Actions -->
                            <div class="d-flex justify-content-start gap-3 mt-24 pt-20 border-top border-neutral-200">
                                <button type="submit" class="btn btn-primary-600 radius-8 px-28 py-10 fw-bold d-inline-flex align-items-center gap-2 shadow-sm">
                                    <i class="ri-shield-keyhole-line"></i> Update Security Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Live avatar preview before submitting
    const avatarInput = document.getElementById('avatar-input');
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const sidePreview = document.getElementById('avatar-preview-side');
                    const sideFallback = document.getElementById('avatar-preview-side-fallback');
                    const formPreview = document.getElementById('avatar-preview-form');
                    const formFallback = document.getElementById('avatar-preview-form-fallback');

                    if (sidePreview) {
                        sidePreview.src = event.target.result;
                    } else if (sideFallback) {
                        const newImg = document.createElement('img');
                        newImg.id = 'avatar-preview-side';
                        newImg.src = event.target.result;
                        newImg.className = 'w-120-px h-120-px rounded-circle object-fit-cover shadow-sm border border-3 border-primary-100';
                        sideFallback.parentNode.replaceChild(newImg, sideFallback);
                    }

                    if (formPreview) {
                        formPreview.src = event.target.result;
                    } else if (formFallback) {
                        const newFormImg = document.createElement('img');
                        newFormImg.id = 'avatar-preview-form';
                        newFormImg.src = event.target.result;
                        newFormImg.className = 'w-80-px h-80-px rounded-circle object-fit-cover border border-2 border-primary-100';
                        formFallback.parentNode.replaceChild(newFormImg, formFallback);
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Toggle password visibility helper
    function togglePasswordVisibility(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'ri-eye-off-line';
        } else {
            input.type = 'password';
            icon.className = 'ri-eye-line';
        }
    }
</script>
@endsection
