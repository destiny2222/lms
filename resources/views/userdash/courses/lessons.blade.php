@extends('layouts.admin')

@section('page_title', 'Curriculum: ' . $course->title)

@section('content')
<div class="container-fluid p-0">

    <div class="mb-4">
        <a href="{{ route('admin.courses.index') }}" class="text-muted text-sm text-decoration-none">
            <i class="ri-arrow-left-line me-1"></i> Back to Courses
        </a>
        <h4 class="fw-bold text-dark mt-2 mb-1">Curriculum & Video Lessons</h4>
        <p class="text-muted text-sm mb-0">Managing lessons for <strong>{{ $course->title }}</strong></p>
    </div>

    <div class="row g-4">
        <!-- Lessons List -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark mb-0">Sequential Lesson Sequence</h5>
                    <span class="badge bg-light text-dark border">{{ $course->lessons->count() }} Lessons</span>
                </div>

                <div class="list-group list-group-flush">
                    @forelse($course->lessons as $lesson)
                        <div class="list-group-item px-0 py-3 border-bottom d-flex justify-content-between align-items-start gap-3">
                            <div class="d-flex align-items-start gap-3">
                                <div class="w-36-px h-36-px rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold fs-6 flex-shrink-0">
                                    {{ $lesson->sort_order }}
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">{{ $lesson->title }}</h6>
                                    <div class="text-xs text-muted mb-1">
                                        <i class="ri-time-line me-1"></i> {{ $lesson->video_duration_minutes }} mins &bull; Provider: {{ ucfirst($lesson->video_provider) }}
                                    </div>
                                    <div class="text-xs text-truncate text-muted" style="max-width: 320px;">
                                        URL: <code>{{ $lesson->video_url }}</code>
                                    </div>
                                    @if($lesson->quiz)
                                        <span class="badge bg-warning-subtle text-warning-emphasis text-xs mt-1">
                                            Knowledge Check Attached ({{ $lesson->quiz->questions->count() }} Questions)
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="badge {{ $lesson->is_free_preview ? 'bg-success' : 'bg-secondary' }} text-xs">
                                    {{ $lesson->is_free_preview ? 'Free Preview' : 'Members Only' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            No lessons added yet. Use the form on the right to add your first lesson!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Add New Lesson Form -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-top" style="top: 20px;">
                <h5 class="fw-bold text-dark mb-3">Add Video Lesson</h5>

                <form action="{{ route('admin.courses.lessons.store', $course->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Lesson Title</label>
                        <input type="text" name="title" class="form-control bg-light @error('title') is-invalid @enderror" required placeholder="e.g. Lesson 4: Authority Closures">
                        @error('title')
                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Video Stream URL</label>
                        <input type="url" name="video_url" class="form-control bg-light @error('video_url') is-invalid @enderror" required placeholder="https://youtube.com/... or Vimeo / Cloudflare">
                        <div class="form-text text-xs text-muted">Supports YouTube, Vimeo, Cloudflare Stream, or direct video streams with download disabled.</div>
                        @error('video_url')
                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Duration (Minutes)</label>
                        <input type="number" name="video_duration_minutes" class="form-control bg-light" value="15" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Summary / Key Takeaways</label>
                        <textarea name="description" rows="3" class="form-control bg-light" placeholder="Brief lesson notes..."></textarea>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="is_free_preview" name="is_free_preview" value="1">
                        <label class="form-check-label text-sm" for="is_free_preview">Allow free preview without enrollment</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-bold">
                        <i class="ri-add-line me-1"></i> Add Lesson to Course
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
