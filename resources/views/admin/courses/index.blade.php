@extends('layouts.admin')

@section('page_title', 'Course List')

@section('content')
<div class="container-fluid p-0">

    <!-- Top Page Header matching Larkon Breadcrumb / Title Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-0 text-uppercase" style="letter-spacing: 0.6px; font-size: 1.15rem;">Course List</h4>
        </div>
        <div class="text-sm text-muted">
            <span class="text-secondary fw-medium">Admin</span> &bull; <span class="text-primary fw-semibold">Courses</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert" style="background-color: #ecfdf5; color: #065f46;">
            <i class="ri-checkbox-circle-fill fs-5 text-success"></i>
            <div class="fw-medium text-sm">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Card matching Larkon "All Product List" -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white larkon-main-card">
        
        <!-- Card Header: Title + Orange Add Button + Filter Dropdown -->
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <h5 class="fw-bold text-dark mb-0 fs-16">All Courses List</h5>
                <span class="badge bg-light text-muted border text-xs px-2 py-1 rounded-pill">{{ $courses->total() }} Total</span>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <!-- Larkon Signature Orange Action Button -->
                <a href="{{ route('admin.courses.create') }}" class="btn btn-larkon-add shadow-sm">
                    <i class="ri-add-line fs-5"></i> Add Course
                </a>
                
            </div>
        </div>

        <!-- Table Responsive Container -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 larkon-table">
                <thead>
                    <tr>
                        <th style="width: 44px;" class="ps-4 text-center">
                            <input type="checkbox" class="form-check-input" id="checkAll" title="Select All">
                        </th>
                        <th style="min-width: 280px;">Course Name & Info</th>
                        <th style="min-width: 110px;">Price</th>
                        <th style="min-width: 140px;">Stock</th>
                        <th style="min-width: 140px;">Category</th>
                        <th style="min-width: 160px;">Lessons</th>
                        <th style="min-width: 120px;" class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <!-- Checkbox -->
                            <td class="ps-4 text-center">
                                <input type="checkbox" class="form-check-input course-checkbox" value="{{ $course->id }}">
                            </td>

                            <!-- Product Name & Size -> Course Name & Info -->
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="larkon-thumb-box">
                                        @if($course->thumbnail_url)
                                            <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-100 h-100 d-flex align-items-center justify-content-center text-primary bg-primary-subtle fw-bold fs-5\'><i class=\'ri-book-open-fill\'></i></div>';">
                                        @else
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-primary bg-primary-subtle fw-bold fs-5">
                                                <i class="ri-book-open-fill"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.courses.lessons', $course->id) }}" class="fw-semibold text-dark text-decoration-none d-block mb-1 course-title-link text-truncate" style="max-width: 260px;" title="{{ $course->title }}">
                                            {{ $course->title }}
                                        </a>
                                        <span class="text-muted text-xs d-block">
                                            Level : {{ ucfirst($course->level ?? 'Beginner') }} &bull; {{ $course->duration_hours }} Hours
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Price -->
                            <td>
                                <div class="fw-semibold text-dark fs-14">Free</div>
                                <span class="text-muted text-xs d-block">0.00 USD</span>
                            </td>

                            <!-- Stock -> Students Enrolled / Completed -->
                            <td>
                                <div class="fw-semibold text-dark fs-13">{{ $course->enrollments->count() }} Enrolled</div>
                                <span class="text-muted text-xs d-block">{{ $course->enrollments->whereNotNull('completed_at')->count() }} Completed</span>
                            </td>

                            <!-- Category -->
                            <td>
                                <span class="text-secondary text-sm fw-medium d-inline-block">{{ ucfirst($course->level ?? 'Discipleship') }}</span>
                                <span class="badge {{ $course->status === 'published' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }} rounded-pill px-2 py-0.5 text-xs fw-semibold ms-1">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </td>

                            <!-- Rating -->
                            <td>
                                <div class="d-flex align-items-center gap-2 flex-wrap"> 
                                    <span class="text-muted text-xs">{{ $course->lessons->count() }} Lessons</span>
                                </div>
                            </td>

                            <!-- Action: 3 Distinct Square Icon Buttons (Eye, Pencil, Trash) -->
                            <td class="text-end pe-4">
                                <div class="d-inline-flex align-items-center gap-2">
                                    <!-- 1. Eye Button (Preview Public Page) -->
                                    <a href="{{ route('courses.show', $course->slug) }}" target="_blank" class="btn-larkon-action btn-larkon-view" title="Preview Public Page">
                                        <i class="ri-eye-line"></i>
                                    </a>

                                    <!-- 2. Pencil Button (Edit Course Details) -->
                                    <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn-larkon-action btn-larkon-edit" title="Edit Course Details">
                                        <i class="ri-pencil-line"></i>
                                    </a>

                                    <!-- 3. Video / Curriculum Button (Manage Lessons & Quizzes) -->
                                    <a href="{{ route('admin.courses.lessons', $course->id) }}" class="btn-larkon-action btn-larkon-lessons" title="Manage Curriculum & Lessons">
                                        <i class="ri-video-line"></i>
                                    </a>

                                    <!-- 4. Trash Button (Delete Course) -->
                                    <button type="button" class="btn-larkon-action btn-larkon-delete" data-bs-toggle="modal" data-bs-target="#deleteCourseModal{{ $course->id }}" title="Delete Course">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade text-start" id="deleteCourseModal{{ $course->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $course->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                            <div class="modal-body p-4 text-center">
                                                <div class="w-12 h-12 rounded-circle bg-danger-subtle text-danger d-inline-flex align-items-center justify-content-center mb-3 fs-3" style="width: 56px; height: 56px;">
                                                    <i class="ri-delete-bin-line"></i>
                                                </div>
                                                <h5 class="fw-bold text-dark mb-2">Delete Course?</h5>
                                                <p class="text-muted text-xs mb-4">
                                                    Are you sure you want to delete <strong>"{{ $course->title }}"</strong>? This action cannot be undone.
                                                </p>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <button type="button" class="btn btn-light rounded-pill px-3 text-xs fw-semibold" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger rounded-pill px-3 text-xs fw-bold">
                                                            Yes, Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <div class="w-12 h-12 rounded-circle bg-light text-muted d-inline-flex align-items-center justify-content-center mb-2 fs-2" style="width: 60px; height: 60px;">
                                        <i class="ri-inbox-line"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">No Courses Found</h6>
                                    <p class="text-muted text-xs mb-3">Get started by creating your very first course curriculum.</p>
                                    <a href="{{ route('admin.courses.create') }}" class="btn btn-larkon-add btn-sm">
                                        <i class="ri-add-line me-1"></i> Add First Course
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Card Footer: Pagination & Entries Info -->
        <div class="card-footer bg-white border-top py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="text-xs text-muted">
                @if($courses->total() > 0)
                    Showing <span class="fw-semibold text-dark">{{ $courses->firstItem() }}</span> to <span class="fw-semibold text-dark">{{ $courses->lastItem() }}</span> of <span class="fw-semibold text-dark">{{ $courses->total() }}</span> entries
                @else
                    Showing 0 entries
                @endif
            </div>
            <div class="larkon-pagination">
                {{ $courses->links() }}
            </div>
        </div>

    </div>

</div>

<!-- Larkon Table Styling -->
<style>
    /* Card Container */
    .larkon-main-card {
        border: 1px solid #edf2f7 !important;
        border-radius: 12px !important;
        background-color: #ffffff;
    }

    /* Brand Blue Action Button */
    .btn-larkon-add {
        background-color: var(--primary, #2563eb) !important;
        border-color: var(--primary, #2563eb) !important;
        color: #ffffff !important;
        font-weight: 600;
        font-size: 13.5px;
        padding: 7px 16px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .btn-larkon-add:hover {
        background-color: var(--primary-hover, #1d4ed8) !important;
        border-color: var(--primary-hover, #1d4ed8) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
    }

    /* Filter Dropdown Button */
    .btn-larkon-filter {
        background-color: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        color: #475569 !important;
        font-size: 13px;
        font-weight: 500;
        padding: 7px 14px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-larkon-filter:hover {
        background-color: #f8fafc !important;
        border-color: #cbd5e1 !important;
        color: #0f172a !important;
    }

    /* Table Base */
    .larkon-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }
    .larkon-table thead th {
        background-color: #f8fafc;
        color: #64748b;
        font-size: 12.5px;
        font-weight: 600;
        text-transform: none;
        letter-spacing: 0.2px;
        padding: 14px 16px;
        border-bottom: 1px solid #edf2f7;
        white-space: nowrap;
    }
    .larkon-table tbody td {
        padding: 16px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 13.5px;
    }
    .larkon-table tbody tr:hover td {
        background-color: #fafbfc;
    }
    .larkon-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Checkbox Styling */
    .larkon-table .form-check-input {
        width: 18px;
        height: 18px;
        border-radius: 4px;
        border-color: #cbd5e1;
        cursor: pointer;
    }
    .larkon-table .form-check-input:checked {
        background-color: var(--primary, #2563eb);
        border-color: var(--primary, #2563eb);
    }

    /* Thumbnail Box */
    .larkon-thumb-box {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        background-color: #f8fafc;
        border: 1px solid #edf2f7;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }
    .larkon-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Course Title */
    .course-title-link {
        color: #1e293b;
        transition: color 0.15s ease;
    }
    .course-title-link:hover {
        color: var(--primary, #2563eb);
    }

    /* Rating Pill matching Larkon */
    .larkon-rating-pill {
        background-color: #fff9eb;
        color: #1e293b;
        border: 1px solid #fef08a;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* 4 Action Square Buttons */
    .btn-larkon-action {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.15s ease-in-out;
        text-decoration: none;
        font-size: 15px;
        cursor: pointer;
    }
    /* 1. Eye Button */
    .btn-larkon-view {
        background-color: #f1f5f9;
        color: #64748b;
    }
    .btn-larkon-view:hover {
        background-color: #e2e8f0;
        color: #1e293b;
    }
    /* 2. Pencil Button */
    .btn-larkon-edit {
        background-color: #eff6ff;
        color: #2563eb;
    }
    .btn-larkon-edit:hover {
        background-color: #dbeafe;
        color: #1d4ed8;
    }
    /* 3. Curriculum / Video Button */
    .btn-larkon-lessons {
        background-color: #f3e8ff;
        color: #9333ea;
    }
    .btn-larkon-lessons:hover {
        background-color: #e9d5ff;
        color: #7e22ce;
    }
    /* 4. Delete Button */
    .btn-larkon-delete {
        background-color: #fee2e2;
        color: #ef4444;
    }
    .btn-larkon-delete:hover {
        background-color: #fecaca;
        color: #dc2626;
    }

    /* Fonts & Typography */
    .fs-13 { font-size: 13px !important; }
    .fs-14 { font-size: 14px !important; }
    .fs-15 { font-size: 15px !important; }
    .fs-16 { font-size: 16px !important; }
</style>

<!-- Select All Checkbox Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.getElementById('checkAll');
        const checkboxes = document.querySelectorAll('.course-checkbox');

        if (checkAll) {
            checkAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = checkAll.checked);
            });

            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    const allChecked = Array.from(checkboxes).every(c => c.checked);
                    const someChecked = Array.from(checkboxes).some(c => c.checked);
                    checkAll.checked = allChecked;
                    checkAll.indeterminate = !allChecked && someChecked;
                });
            });
        }
    });
</script>
@endsection
