@extends('layouts.admin')

@section('page_title', 'Website Testimonials')

@section('content')
<div class="container-fluid p-0">

    <!-- Top Page Header matching Larkon Breadcrumb / Title Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold text-dark mb-0 text-uppercase" style="letter-spacing: 0.6px; font-size: 1.15rem;">Website Testimonials</h4>
            <p class="text-muted text-xs mb-0">Manage disciple testimonies, student reviews, and quotes showcased on the public About Us page</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('about') }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-3 px-3 py-1.5 text-xs d-inline-flex align-items-center gap-1.5">
                <i class="ri-external-link-line"></i> View on About Page
            </a>
            <button type="button" class="btn btn-larkon-add" data-bs-toggle="modal" data-bs-target="#createTestimonialModal">
                <i class="ri-add-line fs-5"></i> Add Testimonial
            </button>
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

    <!-- Top KPI Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Total Testimonials</span>
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-chat-quote-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $stats['total'] }}</h3>
                <span class="text-muted text-xs mt-1 d-block">All recorded testimonies</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Active &amp; Published</span>
                    <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-checkbox-circle-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $stats['active'] }}</h3>
                <span class="text-muted text-xs mt-1 d-block">Visible on live carousel</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Inactive / Drafts</span>
                    <div class="rounded-circle bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-eye-off-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $stats['inactive'] }}</h3>
                <span class="text-muted text-xs mt-1 d-block">Hidden from public view</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Live Placement</span>
                    <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-layout-masonry-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">About Us</h3>
                <span class="text-muted text-xs mt-1 d-block">Section: "What People Say"</span>
            </div>
        </div>
    </div>

    <!-- Main Card matching Larkon "All Product List" -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white larkon-main-card">
        
        <!-- Card Header: Title + Search & Filters -->
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <h5 class="fw-bold text-dark mb-0 fs-16">All Testimonials Directory</h5>
                <span class="badge bg-light text-muted border text-xs px-2 py-1 rounded-pill">{{ $testimonials->total() }} Records</span>
            </div>
            
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <!-- Search and Filters Form -->
                <form method="GET" action="{{ route('admin.testimonials.index') }}" class="d-flex align-items-center gap-2 flex-wrap m-0">
                    <div class="input-group input-group-sm" style="width: 240px;">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="ri-search-line"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Search name, role, quote..." value="{{ request('search') }}">
                    </div>

                    <select name="status" class="form-select form-select-sm bg-light" style="width: 140px;" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>

                    @if(request()->anyFilled(['search', 'status']))
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-sm btn-outline-secondary" title="Clear Filters">
                            <i class="ri-refresh-line"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Table Responsive Container -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 larkon-table">
                <thead>
                    <tr>
                        <th style="min-width: 250px;" class="ps-4">Reviewer Details</th>
                        <th style="min-width: 320px;">Testimonial Quote</th>
                        <th style="min-width: 110px;" class="text-center">Rating</th>
                        <th style="min-width: 110px;" class="text-center">Status</th>
                        <th style="min-width: 100px;" class="text-center">Order</th>
                        <th style="min-width: 130px;">Created</th>
                        <th style="min-width: 150px;" class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $testimonial)
                        <tr>
                            <!-- Reviewer Name & Designation -->
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="position-relative flex-shrink-0">
                                        <img src="{{ $testimonial->avatar_url }}" alt="{{ $testimonial->name }}" class="rounded-circle border" style="width: 44px; height: 44px; object-fit: cover;">
                                        @if($testimonial->is_active)
                                            <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle" title="Active"></span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="fw-bold text-dark fs-14 text-truncate" style="max-width: 190px;" title="{{ $testimonial->name }}">
                                            {{ $testimonial->name }}
                                        </div>
                                        <span class="text-muted text-xs d-block text-truncate" style="max-width: 190px;">
                                            {{ $testimonial->designation ?: 'Disciple / Student' }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Testimonial Quote -->
                            <td>
                                <div class="text-secondary fs-13 line-clamp-2" style="max-width: 380px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;" title="{{ $testimonial->content }}">
                                    &ldquo;{{ $testimonial->content }}&rdquo;
                                </div>
                            </td>

                            <!-- Star Rating -->
                            <td class="text-center">
                                <div class="text-warning text-xs">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= ($testimonial->rating ?? 5))
                                            <i class="ri-star-fill"></i>
                                        @else
                                            <i class="ri-star-line text-muted"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-xxs text-muted d-block mt-0.5">{{ $testimonial->rating ?? 5 }}/5 Stars</span>
                            </td>

                            <!-- Status Badge with Toggle Form -->
                            <td class="text-center">
                                <form action="{{ route('admin.testimonials.toggle', $testimonial->id) }}" method="POST" class="d-inline m-0">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn p-0 border-0 bg-transparent" title="Click to {{ $testimonial->is_active ? 'deactivate' : 'activate' }}">
                                        @if($testimonial->is_active)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 text-xs fw-semibold">
                                                <i class="ri-checkbox-circle-fill me-0.5"></i> Active
                                            </span>
                                        @else
                                            <span class="badge bg-light text-muted border rounded-pill px-2.5 py-1 text-xs fw-semibold">
                                                <i class="ri-eye-off-line me-0.5"></i> Hidden
                                            </span>
                                        @endif
                                    </button>
                                </form>
                            </td>

                            <!-- Sort Order -->
                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-2 py-0.5 text-xs font-monospace">
                                    #{{ $testimonial->sort_order }}
                                </span>
                            </td>

                            <!-- Created Date -->
                            <td>
                                <span class="text-dark fs-13 fw-medium">{{ $testimonial->created_at->format('M d, Y') }}</span>
                                <span class="text-muted text-xs d-block">{{ $testimonial->created_at->diffForHumans() }}</span>
                            </td>

                            <!-- Actions -->
                            <td class="text-end pe-4">
                                <div class="d-inline-flex align-items-center gap-1.5">
                                    <!-- Preview Modal Trigger -->
                                    <button type="button" class="btn-larkon-action btn-larkon-view" data-bs-toggle="modal" data-bs-target="#previewModal{{ $testimonial->id }}" title="Preview Testimonial">
                                        <i class="ri-eye-line"></i>
                                    </button>

                                    <!-- Edit Modal Trigger -->
                                    <button type="button" class="btn-larkon-action btn-larkon-edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $testimonial->id }}" title="Edit Testimonial">
                                        <i class="ri-pencil-line"></i>
                                    </button>

                                    <!-- Delete Modal Trigger -->
                                    <button type="button" class="btn-larkon-action btn-larkon-delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $testimonial->id }}" title="Delete Testimonial">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>

                                <!-- Card Preview Modal -->
                                <div class="modal fade text-start" id="previewModal{{ $testimonial->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                            <div class="modal-header bg-light border-bottom px-4 py-3">
                                                <h5 class="modal-title fw-bold text-dark fs-16 mb-0">Website Display Preview</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4 text-center">
                                                <div class="mb-3">
                                                    <img src="{{ $testimonial->avatar_url }}" alt="{{ $testimonial->name }}" class="rounded-circle shadow-sm border" style="width: 80px; height: 80px; object-fit: cover;">
                                                </div>
                                                <h4 class="fw-bold text-dark mb-0.5">{{ $testimonial->name }}</h4>
                                                @if($testimonial->designation)
                                                    <p class="text-muted text-xs mb-3">{!! preg_replace('/(\s+at\s+)(.*)/i', '$1<span class="text-primary fw-semibold">$2</span>', e($testimonial->designation)) !!}</p>
                                                @endif
                                                <div class="p-3.5 rounded-3 bg-light border text-start position-relative">
                                                    <i class="ri-double-quotes-l fs-3 text-muted position-absolute top-0 start-0 ms-2 mt-1 opacity-25"></i>
                                                    <p class="text-secondary fs-14 mb-0 fst-italic position-relative z-1">
                                                        &ldquo;{{ $testimonial->content }}&rdquo;
                                                    </p>
                                                </div>
                                                <div class="mt-3 text-warning">
                                                    @for($i = 1; $i <= ($testimonial->rating ?? 5); $i++)
                                                        <i class="ri-star-fill"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light px-4 py-2.5">
                                                <button type="button" class="btn btn-secondary rounded-pill px-3 text-xs" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Testimonial Modal -->
                                <div class="modal fade text-start" id="editModal{{ $testimonial->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                            <div class="modal-header bg-light border-bottom px-4 py-3">
                                                <h5 class="modal-title fw-bold text-dark fs-16 mb-0">Edit Testimonial</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body p-4">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label text-xs fw-bold text-uppercase text-muted">Reviewer Name <span class="text-danger">*</span></label>
                                                            <input type="text" name="name" class="form-control" value="{{ old('name', $testimonial->name) }}" required placeholder="e.g. Charry Porter">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label text-xs fw-bold text-uppercase text-muted">Designation / Role</label>
                                                            <input type="text" name="designation" class="form-control" value="{{ old('designation', $testimonial->designation) }}" placeholder="e.g. Student at Porter Library">
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="form-label text-xs fw-bold text-uppercase text-muted">Testimonial Content <span class="text-danger">*</span></label>
                                                            <textarea name="content" class="form-control" rows="4" required placeholder="Write the testimony or feedback quote here...">{{ old('content', $testimonial->content) }}</textarea>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label text-xs fw-bold text-uppercase text-muted">Avatar / Photo</label>
                                                            <div class="d-flex align-items-center gap-3">
                                                                <img src="{{ $testimonial->avatar_url }}" alt="Preview" class="rounded-circle border flex-shrink-0" style="width: 48px; height: 48px; object-fit: cover;">
                                                                <input type="file" name="image" class="form-control" accept="image/*">
                                                            </div>
                                                            <span class="text-xxs text-muted mt-1 d-block">Recommended square JPG/PNG/WebP, max 5MB</span>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label class="form-label text-xs fw-bold text-uppercase text-muted">Star Rating</label>
                                                            <select name="rating" class="form-select">
                                                                @for($r = 5; $r >= 1; $r--)
                                                                    <option value="{{ $r }}" {{ old('rating', $testimonial->rating ?? 5) == $r ? 'selected' : '' }}>
                                                                        {{ $r }} Stars ({{ str_repeat('★', $r) }})
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label class="form-label text-xs fw-bold text-uppercase text-muted">Sort Order</label>
                                                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $testimonial->sort_order) }}" min="0">
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-check form-switch mt-2">
                                                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="editActive{{ $testimonial->id }}" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                                                                <label class="form-check-label text-xs fw-semibold text-dark" for="editActive{{ $testimonial->id }}">
                                                                    Active (Display publicly on the About Us page carousel)
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light px-4 py-2.5">
                                                    <button type="button" class="btn btn-secondary rounded-pill px-3 text-xs" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary rounded-pill px-4 text-xs fw-semibold">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade text-start" id="deleteModal{{ $testimonial->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                            <div class="modal-header border-0 pb-0">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center px-4 pt-0 pb-4">
                                                <div class="rounded-circle bg-danger-subtle text-danger d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                                                    <i class="ri-delete-bin-line fs-2"></i>
                                                </div>
                                                <h5 class="fw-bold text-dark mb-1">Delete Testimonial?</h5>
                                                <p class="text-muted text-xs mb-3">
                                                    Are you sure you want to permanently delete the testimony from <strong class="text-dark">{{ $testimonial->name }}</strong>?
                                                </p>
                                                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                                        <button type="button" class="btn btn-sm btn-light rounded-pill px-3 text-xs" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3 text-xs">Yes, Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                                        <i class="ri-chat-quote-line fs-2 text-muted"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-1">No testimonials found</h5>
                                    <p class="text-muted text-xs mb-3">No testimonials match your current search or filter criteria.</p>
                                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#createTestimonialModal">
                                        <i class="ri-add-line me-1"></i> Add First Testimonial
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($testimonials->hasPages())
            <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span class="text-xs text-muted">
                    Showing {{ $testimonials->firstItem() ?? 0 }} to {{ $testimonials->lastItem() ?? 0 }} of {{ $testimonials->total() }} testimonials
                </span>
                <div>
                    {{ $testimonials->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>

</div>

<!-- Create Testimonial Modal -->
<div class="modal fade" id="createTestimonialModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                        <i class="ri-chat-quote-line fs-5"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark fs-16 mb-0">Add New Testimonial</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-xs fw-bold text-uppercase text-muted">Reviewer Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="e.g. Sister Grace Johnson">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-xs fw-bold text-uppercase text-muted">Designation / Role</label>
                            <input type="text" name="designation" class="form-control" value="{{ old('designation') }}" placeholder="e.g. Disciple at RACAi Ministry">
                        </div>

                        <div class="col-12">
                            <label class="form-label text-xs fw-bold text-uppercase text-muted">Testimonial Content <span class="text-danger">*</span></label>
                            <textarea name="content" class="form-control" rows="4" required placeholder="Enter the testimonial, life transformation story, or feedback quote...">{{ old('content') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-xs fw-bold text-uppercase text-muted">Avatar / Photo (Optional)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <span class="text-xxs text-muted mt-1 d-block">Upload portrait photo. If left blank, a branded initial avatar will be used automatically.</span>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label text-xs fw-bold text-uppercase text-muted">Star Rating</label>
                            <select name="rating" class="form-select">
                                <option value="5" selected>5 Stars (★★★★★)</option>
                                <option value="4">4 Stars (★★★★☆)</option>
                                <option value="3">3 Stars (★★★☆☆)</option>
                                <option value="2">2 Stars (★★☆☆☆)</option>
                                <option value="1">1 Star (★☆☆☆☆)</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label text-xs fw-bold text-uppercase text-muted">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="createActive" checked>
                                <label class="form-check-label text-xs fw-semibold text-dark" for="createActive">
                                    Publish immediately to About Us carousel
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-2.5">
                    <button type="button" class="btn btn-secondary rounded-pill px-3 text-xs" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 text-xs fw-semibold">
                        <i class="ri-check-line me-1"></i> Save Testimonial
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .larkon-main-card {
        border-color: #eef2f6 !important;
    }
    .larkon-table thead th {
        background-color: #f8fafc;
        color: #475569;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 13px 16px;
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

    /* Action Buttons Design */
    .btn-larkon-action {
        width: 36px !important;
        height: 36px !important;
        border-radius: 9px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border: 1px solid transparent !important;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
        text-decoration: none !important;
        font-size: 17px !important;
        cursor: pointer !important;
        padding: 0 !important;
        line-height: 1 !important;
        outline: none !important;
        box-shadow: none !important;
    }
    .btn-larkon-action:hover {
        transform: translateY(-2px) !important;
    }

    /* 1. Preview (Purple) */
    .btn-larkon-view {
        background-color: #f5f3ff !important;
        border-color: #ede9fe !important;
        color: #7c3aed !important;
    }
    .btn-larkon-view:hover {
        background-color: #7c3aed !important;
        border-color: #7c3aed !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3) !important;
    }

    /* 2. Edit (Brand Blue) */
    .btn-larkon-edit {
        background-color: #eff6ff !important;
        border-color: #dbeafe !important;
        color: #2563eb !important;
    }
    .btn-larkon-edit:hover {
        background-color: #2563eb !important;
        border-color: #2563eb !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3) !important;
    }

    /* 3. Delete (Rose / Red) */
    .btn-larkon-delete {
        background-color: #fef2f2 !important;
        border-color: #fee2e2 !important;
        color: #dc2626 !important;
    }
    .btn-larkon-delete:hover {
        background-color: #dc2626 !important;
        border-color: #dc2626 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3) !important;
    }
</style>
@endsection
