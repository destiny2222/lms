@extends('layouts.admin')

@section('page_title', 'Course Management')

@section('content')
<div class="container-fluid p-0">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Courses</h4>
            <p class="text-muted text-sm mb-0">Create courses, configure video lessons, and manage curriculum</p>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold">
            <i class="ri-add-line me-1"></i> Create New Course
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-sm">
                <thead class="table-light text-xs text-muted text-uppercase">
                    <tr>
                        <th>Course Title</th>
                        <th>Instructor</th>
                        <th>Duration</th>
                        <th>Lessons</th>
                        <th>Enrolled Students</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $course->title }}</div>
                                <span class="text-xs text-muted">{{ $course->slug }}</span>
                            </td>
                            <td>{{ $course->tutor->name ?? 'None' }}</td>
                            <td>{{ $course->duration_hours }} Hours</td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $course->lessons->count() }} Lessons</span>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary">{{ $course->enrollments->count() }} Students</span>
                            </td>
                            <td>
                                <span class="badge {{ $course->status === 'published' ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.courses.lessons', $course->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                                    <i class="ri-play-list-add-line me-1"></i> Manage Lessons
                                </a>
                                <a href="{{ route('courses.show', $course->slug) }}" target="_blank" class="btn btn-light btn-sm rounded-pill px-2 text-muted">
                                    <i class="ri-external-link-line"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No courses created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3 border-top">
            {{ $courses->links() }}
        </div>
    </div>

</div>
@endsection
