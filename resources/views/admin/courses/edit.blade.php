@extends('layouts.admin')

@section('page_title', 'Edit Course — ' . $course->title)

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <div class="mb-4">
                    <a href="{{ route('admin.courses.index') }}" class="text-muted text-sm text-decoration-none">
                        <i class="ri-arrow-left-line me-1"></i> Back to Courses
                    </a>
                    <h4 class="fw-bold text-dark mt-2 mb-1">Edit Course</h4>
                    <p class="text-muted text-sm mb-0">Update course details, metadata, and status.</p>
                </div>

                <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Course Title</label>
                        <input type="text" name="title" class="form-control bg-light @error('title') is-invalid @enderror" value="{{ old('title', $course->title) }}" required>
                        @error('title')
                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Subtitle / Catchphrase</label>
                        <input type="text" name="subtitle" class="form-control bg-light @error('subtitle') is-invalid @enderror" value="{{ old('subtitle', $course->subtitle) }}" placeholder="Brief 1-line hook">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Course Thumbnail (Cloudinary / CDN)</label>
                        @if($course->thumbnail_url)
                            <div class="mb-2 d-flex align-items-center gap-3" id="currentThumbBox">
                                <img src="{{ $course->thumbnail_url }}" alt="Current thumbnail" class="rounded-3 border" style="width: 80px; height: 50px; object-fit: cover;" onerror="document.getElementById('currentThumbBox').style.display='none';">
                                <span class="text-muted text-xs">Current image preview</span>
                            </div>
                        @endif
                        <input type="file" name="thumbnail" accept="image/*" class="form-control bg-light @error('thumbnail') is-invalid @enderror">
                        <div class="form-text text-xs text-muted">Upload replacement cover image (JPEG, PNG, WebP — max 50MB).</div>
                        @error('thumbnail')
                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Full Course Description</label>
                        <textarea name="description" rows="5" class="form-control bg-light @error('description') is-invalid @enderror" required>{{ old('description', $course->description) }}</textarea>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-sm">Difficulty Level</label>
                            <select name="level" class="form-select bg-light">
                                <option value="beginner" {{ old('level', $course->level) === 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('level', $course->level) === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ old('level', $course->level) === 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-sm">Duration (Hours)</label>
                            <input type="number" name="duration_hours" min="1" max="100" class="form-control bg-light @error('duration_hours') is-invalid @enderror" value="{{ old('duration_hours', $course->duration_hours) }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-sm">Publishing Status</label>
                            <select name="status" class="form-select bg-light">
                                <option value="draft" {{ old('status', $course->status) === 'draft' ? 'selected' : '' }}>Draft (Hidden)</option>
                                <option value="published" {{ old('status', $course->status) === 'published' ? 'selected' : '' }}>Published (Active)</option>
                                <option value="archived" {{ old('status', $course->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('admin.courses.lessons', $course->id) }}" class="btn btn-outline-primary rounded-pill px-4 fw-semibold">
                            <i class="ri-play-list-add-line me-1"></i> Manage Curriculum Lessons
                        </a>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.courses.index') }}" class="btn btn-light rounded-pill px-4 text-muted">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                                <i class="ri-check-line me-1"></i> Save Changes
                            </button>
                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
@endsection
