@extends('layouts.admin')

@section('page_title', 'Create New Course')

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <div class="mb-4">
                    <a href="{{ route('admin.courses.index') }}" class="text-muted text-sm text-decoration-none">
                        <i class="ri-arrow-left-line me-1"></i> Back to Courses
                    </a>
                    <h4 class="fw-bold text-dark mt-2 mb-1">Create Course</h4>
                    <p class="text-muted text-sm mb-0">Set up the masterclass profile. You will add lessons and quizzes in the next step.</p>
                </div>

                <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Course Title</label>
                        <input type="text" name="title" class="form-control bg-light @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="e.g. The Authority to Buy Masterclass">
                        @error('title')
                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Subtitle / Catchphrase</label>
                        <input type="text" name="subtitle" class="form-control bg-light @error('subtitle') is-invalid @enderror" value="{{ old('subtitle') }}" placeholder="Brief 1-line hook">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Course Thumbnail (Cloudinary / CDN)</label>
                        <input type="file" name="thumbnail" accept="image/*" class="form-control bg-light @error('thumbnail') is-invalid @enderror">
                        <div class="form-text text-xs text-muted">Upload cover image (JPEG, PNG, WebP — max 5MB). Automatically optimized and hosted.</div>
                        @error('thumbnail')
                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Full Course Description</label>
                        <textarea name="description" rows="5" class="form-control bg-light @error('description') is-invalid @enderror" required placeholder="Detailed curriculum overview and certification outcomes...">{{ old('description') }}</textarea>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-sm">Difficulty Level</label>
                            <select name="level" class="form-select bg-light">
                                <option value="beginner">Beginner</option>
                                <option value="intermediate" selected>Intermediate</option>
                                <option value="advanced">Advanced</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-sm">Duration (Hours)</label>
                            <input type="number" name="duration_hours" class="form-control bg-light" value="{{ old('duration_hours', 4) }}" min="1" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-sm">Publication Status</label>
                            <select name="status" class="form-select bg-light">
                                <option value="published" selected>Published (Public)</option>
                                <option value="draft">Draft (Hidden)</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">Save & Add Lessons</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
