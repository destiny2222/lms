@extends('layouts.admin')

@section('title', 'Curriculum: ' . $course->title)

@section('content')
<div class="container-fluid p-0">

    <div class="mb-4">
        <a href="{{ route('admin.courses.index') }}" class="text-muted text-sm text-decoration-none">
            <i class="ri-arrow-left-line me-1"></i> Back to Courses
        </a>
        <h4 class="fw-bold text-dark mt-2 mb-1">Curriculum &amp; Video Lessons</h4>
        <p class="text-muted text-sm mb-0">Managing video lessons for <strong>{{ $course->title }}</strong></p>
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
                                    <div class="text-xs text-muted mb-1 d-flex flex-wrap align-items-center gap-2">
                                        <span><i class="ri-time-line me-1"></i> {{ $lesson->video_duration_minutes }} mins</span>
                                        &bull;
                                        @if($lesson->video_provider === 'cloudinary')
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2">
                                                <i class="ri-cloud-line me-1"></i> Cloudinary HD
                                            </span>
                                        @else
                                            <span class="badge bg-light text-secondary border rounded-pill px-2">
                                                {{ ucfirst($lesson->video_provider) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-truncate text-muted" style="max-width: 320px;" title="{{ $lesson->video_url }}">
                                        Stream: <code>{{ $lesson->video_url }}</code>
                                    </div>
                                    @if($lesson->quiz)
                                        <div class="mt-1.5 d-flex align-items-center gap-2">
                                            <a href="{{ route('admin.quizzes.builder', $lesson->quiz->id) }}" class="badge bg-primary-subtle text-primary border border-primary-subtle text-xs text-decoration-none px-2.5 py-1">
                                                <i class="ri-questionnaire-line me-1"></i> Quiz Attached ({{ $lesson->quiz->questions->count() }} Questions) &bull; Manage Key
                                            </a>
                                        </div>
                                    @else
                                        <div class="mt-1.5">
                                            <a href="{{ route('admin.quizzes.create', ['course_id' => $course->id, 'lesson_id' => $lesson->id]) }}" class="badge bg-light text-secondary border text-xs text-decoration-none px-2 py-1">
                                                <i class="ri-add-line me-1"></i> + Attach Knowledge Check Quiz
                                            </a>
                                        </div>
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
                            <i class="ri-video-line fs-1 text-secondary mb-2 d-block"></i>
                            No lessons added yet. Use the form on the right to upload your first video lesson!
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Course Final Exam / Certification Qualifier Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                            <i class="ri-award-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0.5">Course Final Certification Exam</h6>
                            <p class="text-muted text-xs mb-0">Master exam completed by students to unlock their verified certificate</p>
                        </div>
                    </div>
                    <div>
                        @if($course->finalExam())
                            <a href="{{ route('admin.quizzes.builder', $course->finalExam()->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 text-xs shadow-sm">
                                <i class="ri-list-check-2 me-1"></i> Manage Questions ({{ $course->finalExam()->questions->count() }})
                            </a>
                        @else
                            <a href="{{ route('admin.quizzes.create', ['course_id' => $course->id]) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 text-xs fw-semibold">
                                <i class="ri-add-line me-1"></i> Setup Final Exam
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Lesson Form -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-top" style="top: 20px;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold text-dark mb-0">Add Video Lesson</h5>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill text-xs px-2.5 py-1">
                        <i class="ri-cloud-upload-line me-1"></i> Cloudinary Enabled
                    </span>
                </div>

                <form action="{{ route('admin.courses.lessons.store', $course->id) }}" method="POST" enctype="multipart/form-data" id="addLessonForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Lesson Title</label>
                        <input type="text" name="title" class="form-control bg-light @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="e.g. Lesson 4: Authority Closures">
                        @error('title')
                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Video Upload Mode (Cloudinary Upload vs External URL) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm d-flex justify-content-between align-items-center">
                            <span>Upload Video File (Cloudinary)</span>
                            <span class="text-muted text-xs fw-normal">MP4, MOV, WebM</span>
                        </label>

                        @if(!empty($cloudinaryConfig['is_configured']) && !empty($cloudinaryConfig['cloud_name']))
                            <!-- Cloudinary Direct Browser Upload Widget (Handles unlimited sizes with progress bar) -->
                            <button type="button" id="cloudinaryUploadWidgetBtn" class="btn btn-outline-primary w-100 py-2 rounded-3 text-xs fw-bold d-flex align-items-center justify-content-center gap-2 mb-2">
                                <i class="ri-upload-cloud-line fs-5"></i> Direct Cloudinary Upload (Live Progress)
                            </button>
                            <div id="cloudinaryUploadFeedback" class="d-none alert alert-success py-2 px-3 text-xs rounded-3 mb-2">
                                <i class="ri-checkbox-circle-fill me-1"></i> Video uploaded to Cloudinary successfully!
                            </div>
                        @endif

                        <input type="file" name="video_file" id="video_file_input" accept="video/mp4,video/quicktime,video/webm" class="form-control bg-light @error('video_file') is-invalid @enderror">
                        <div class="form-text text-xs text-muted">Upload directly to Cloudinary CDN storage.</div>
                        @error('video_file')
                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-center my-2 position-relative">
                        <hr class="text-muted">
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-2 text-xs text-muted fw-semibold">OR ENTER STREAM URL</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Video Stream URL</label>
                        <input type="text" name="video_url" id="video_url_input" class="form-control bg-light @error('video_url') is-invalid @enderror" value="{{ old('video_url') }}" placeholder="https://res.cloudinary.com/... or YouTube/Vimeo">
                        <div class="form-text text-xs text-muted">Cloudinary CDN, YouTube, Vimeo, or direct streaming URL.</div>
                        @error('video_url')
                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Duration (Minutes)</label>
                        <input type="number" name="video_duration_minutes" id="video_duration_input" class="form-control bg-light" value="{{ old('video_duration_minutes', 15) }}" min="1">
                        <div class="form-text text-xs text-muted">Duration in minutes (automatically calculated when uploading via Cloudinary).</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Summary / Key Takeaways</label>
                        <textarea name="description" rows="3" class="form-control bg-light" placeholder="Brief lesson notes and learning objectives...">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="is_free_preview" name="is_free_preview" value="1" {{ old('is_free_preview') ? 'checked' : '' }}>
                        <label class="form-check-label text-sm" for="is_free_preview">Allow free preview without enrollment</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2.5 rounded-pill fw-bold shadow-sm" style="background-color: var(--primary); border-color: var(--primary);">
                        <i class="ri-add-line me-1"></i> Add Video Lesson to Course
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
@if(!empty($cloudinaryConfig['is_configured']) && !empty($cloudinaryConfig['cloud_name']))
    <!-- Cloudinary Official Upload Widget Script -->
    <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const widgetBtn = document.getElementById('cloudinaryUploadWidgetBtn');
            const urlInput = document.getElementById('video_url_input');
            const durationInput = document.getElementById('video_duration_input');
            const feedbackEl = document.getElementById('cloudinaryUploadFeedback');

            if (widgetBtn && window.cloudinary) {
                const widget = window.cloudinary.createUploadWidget({
                    cloudName: "{{ $cloudinaryConfig['cloud_name'] }}",
                    apiKey: "{{ $cloudinaryConfig['api_key'] }}",
                    uploadSignature: function(callback, paramsToSign) {
                        fetch("{{ route('admin.cloudinary.sign') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Accept": "application/json"
                            },
                            body: JSON.stringify({ params_to_sign: paramsToSign })
                        })
                        .then(response => response.json())
                        .then(data => {
                            callback(data.signature);
                        })
                        .catch(err => {
                            console.error("Cloudinary signing error:", err);
                        });
                    },
                    folder: "{{ $cloudinaryConfig['folder'] }}",
                    resourceType: "video",
                    clientAllowedFormats: ["mp4", "mov", "webm", "mkv", "avi"],
                    maxFileSize: 1048576000, // 1GB
                    multiple: false,
                    sources: ["local", "url", "camera"],
                    styles: {
                        palette: {
                            window: "#FFFFFF",
                            windowBorder: "#90A0B3",
                            tabIcon: "#2563EB",
                            menuIcons: "#5A616A",
                            textDark: "#0F172A",
                            textLight: "#FFFFFF",
                            link: "#2563EB",
                            action: "#2563EB",
                            inactiveTabIcon: "#94A3B8",
                            error: "#EF4444",
                            inProgress: "#2563EB",
                            complete: "#10B981",
                            sourceBg: "#F8FAFC"
                        }
                    }
                }, function(error, result) {
                    if (!error && result && result.event === "success") {
                        const info = result.info;
                        if (urlInput) {
                            urlInput.value = info.secure_url;
                        }
                        if (durationInput && info.duration) {
                            durationInput.value = Math.max(1, Math.ceil(info.duration / 60));
                        }
                        if (feedbackEl) {
                            feedbackEl.classList.remove('d-none');
                            feedbackEl.innerHTML = '<i class="ri-checkbox-circle-fill me-1"></i> Cloudinary Video Uploaded: <strong>' + (info.original_filename || 'Video') + '.' + info.format + '</strong> (' + Math.max(1, Math.ceil(info.duration / 60)) + ' mins)';
                        }
                    }
                });

                widgetBtn.addEventListener('click', function() {
                    widget.open();
                });
            }
        });
    </script>
@endif
@endpush
