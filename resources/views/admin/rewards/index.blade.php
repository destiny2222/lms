@extends('layouts.admin')

@section('page_title', 'Data Subscription Rewards')

@section('content')
<div class="container-fluid p-0">

    <!-- Top Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-0 text-uppercase" style="letter-spacing: 0.6px; font-size: 1.15rem;">Data Subscription Rewards</h4>
            <p class="text-muted text-xs mb-0">Milestone incentives: Students who complete 10 courses &amp; earn 10 badges qualify for 1 Month Free Mobile Data</p>
        </div>
        <div class="text-sm text-muted">
            <span class="text-secondary fw-medium">Admin</span> &bull; <span class="text-primary fw-semibold">Rewards</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert" style="background-color: #ecfdf5; color: #065f46;">
            <i class="ri-checkbox-circle-fill fs-5 text-success"></i>
            <div class="fw-medium text-sm">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="ri-error-warning-fill fs-5 text-danger"></i>
            <div class="fw-medium text-sm">{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- KPI Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Total Qualified</span>
                    <div class="rounded-circle bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-trophy-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $metrics['total_qualified'] }}</h3>
                <span class="text-muted text-xs mt-1 d-block">Learners with &ge; 10 badges</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Pending Claims</span>
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-time-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0 text-primary">{{ $metrics['pending_claims'] }}</h3>
                <span class="text-muted text-xs mt-1 d-block">Phone numbers awaiting credit</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Fulfilled Rewards</span>
                    <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-checkbox-circle-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0 text-success">{{ $metrics['fulfilled_rewards'] }}</h3>
                <span class="text-muted text-xs mt-1 d-block">Subscribed &amp; credited data</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Unclaimed</span>
                    <div class="rounded-circle bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-hourglass-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $metrics['unclaimed_rewards'] }}</h3>
                <span class="text-muted text-xs mt-1 d-block">Students yet to submit phone #</span>
            </div>
        </div>
    </div>

    <!-- Main Content Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <!-- Status Filter Tabs -->
                <ul class="nav nav-pills gap-2">
                    <li class="nav-item">
                        <a href="{{ route('admin.rewards.index', ['status' => 'all', 'search' => request('search')]) }}"
                           class="nav-link py-2 px-3 text-xs fw-semibold rounded-pill {{ $status === 'all' ? 'active bg-dark text-white' : 'text-muted bg-light' }}">
                            All ({{ $metrics['total_qualified'] }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.rewards.index', ['status' => 'claimed', 'search' => request('search')]) }}"
                           class="nav-link py-2 px-3 text-xs fw-semibold rounded-pill {{ $status === 'claimed' ? 'active bg-primary text-white' : 'text-muted bg-light' }}">
                            Pending Claims ({{ $metrics['pending_claims'] }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.rewards.index', ['status' => 'fulfilled', 'search' => request('search')]) }}"
                           class="nav-link py-2 px-3 text-xs fw-semibold rounded-pill {{ $status === 'fulfilled' ? 'active bg-success text-white' : 'text-muted bg-light' }}">
                            Fulfilled ({{ $metrics['fulfilled_rewards'] }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.rewards.index', ['status' => 'unlocked', 'search' => request('search')]) }}"
                           class="nav-link py-2 px-3 text-xs fw-semibold rounded-pill {{ $status === 'unlocked' ? 'active bg-warning text-dark' : 'text-muted bg-light' }}">
                            Unclaimed ({{ $metrics['unclaimed_rewards'] }})
                        </a>
                    </li>
                </ul>

                <!-- Search Input Form -->
                <form method="GET" action="{{ route('admin.rewards.index') }}" class="d-flex align-items-center gap-2">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <div class="input-group input-group-sm" style="width: 280px;">
                        <span class="input-group-text bg-light border-0"><i class="ri-search-line text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="form-control bg-light border-0 text-xs"
                               placeholder="Search student, phone, network...">
                    </div>
                    @if(request('search'))
                        <a href="{{ route('admin.rewards.index', ['status' => $status]) }}" class="btn btn-sm btn-outline-secondary text-xs">Clear</a>
                    @endif
                </form>
            </div>
        </div>

        <div class="card-body px-0 pb-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-sm">
                    <thead class="table-light text-xs text-muted text-uppercase">
                        <tr>
                            <th class="ps-4">Student</th>
                            <th>Milestone</th>
                            <th>Target Network</th>
                            <th>Target Phone</th>
                            <th>Status</th>
                            <th>Qualified / Claimed</th>
                            <th class="pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rewards as $reward)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center text-xs" style="width: 38px; height: 38px;">
                                            {{ strtoupper(substr($reward->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.students.show', $reward->user->id) }}" class="fw-semibold text-dark text-decoration-none">
                                                {{ $reward->user->name }}
                                            </a>
                                            <div class="text-xs text-muted">{{ $reward->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1 rounded-pill text-xs fw-semibold">
                                        <i class="ri-award-fill me-1"></i> {{ $reward->milestone_count }} Badges Earned
                                    </span>
                                </td>
                                <td>
                                    @if($reward->network_provider)
                                        @php
                                            $netColor = match($reward->network_provider) {
                                                'MTN' => 'bg-warning text-dark',
                                                'Airtel' => 'bg-danger text-white',
                                                'Glo' => 'bg-success text-white',
                                                '9mobile' => 'bg-dark text-white',
                                                default => 'bg-secondary text-white'
                                            };
                                        @endphp
                                        <span class="badge {{ $netColor }} px-2 py-1 rounded-pill text-xs fw-bold">
                                            {{ $reward->network_provider }}
                                        </span>
                                    @else
                                        <span class="text-muted text-xs italic">Not submitted</span>
                                    @endif
                                </td>
                                <td>
                                    @if($reward->phone_number)
                                        <div class="fw-bold font-monospace text-dark text-xs">
                                            <i class="ri-phone-line text-muted me-1"></i>{{ $reward->phone_number }}
                                        </div>
                                    @else
                                        <span class="text-muted text-xs">Pending student submission</span>
                                    @endif
                                </td>
                                <td>
                                    @if($reward->status === 'fulfilled')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill text-xs px-2 py-1 fw-semibold">
                                            <i class="ri-checkbox-circle-fill me-1"></i> Fulfilled
                                        </span>
                                    @elseif($reward->status === 'claimed')
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill text-xs px-2 py-1 fw-bold">
                                            <i class="ri-time-fill me-1"></i> Pending Credit
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill text-xs px-2 py-1 fw-semibold">
                                            <i class="ri-hourglass-2-line me-1"></i> Awaiting Claim
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-xs text-dark fw-medium">{{ $reward->unlocked_at ? $reward->unlocked_at->format('M d, Y') : '—' }}</div>
                                    @if($reward->claimed_at)
                                        <div class="text-xxs text-muted">Claimed: {{ $reward->claimed_at->diffForHumans() }}</div>
                                    @endif
                                    @if($reward->fulfilled_at)
                                        <div class="text-xxs text-success">Fulfilled: {{ $reward->fulfilled_at->format('M d, Y') }}</div>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    @if($reward->status === 'claimed')
                                        <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 text-xs fw-semibold d-inline-flex align-items-center gap-1"
                                                data-bs-toggle="modal" data-bs-target="#fulfillModal{{ $reward->id }}">
                                            <i class="ri-send-plane-line"></i> Credit &amp; Fulfill
                                        </button>
                                    @elseif($reward->status === 'fulfilled')
                                        <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 text-xs fw-semibold"
                                                data-bs-toggle="modal" data-bs-target="#viewFulfillModal{{ $reward->id }}">
                                            <i class="ri-check-double-line"></i> View Receipt
                                        </button>
                                    @else
                                        <span class="text-muted text-xs">Awaiting claim</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- Fulfill Action Modal -->
                            @if($reward->status === 'claimed')
                                <div class="modal fade" id="fulfillModal{{ $reward->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <form method="POST" action="{{ route('admin.rewards.fulfill', $reward->id) }}">
                                                @csrf
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-bold text-dark">
                                                        <i class="ri-wifi-line text-primary me-2"></i>Fulfill 1-Month Free Data
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body py-4">
                                                    <p class="text-muted text-xs mb-3">
                                                        Confirm that you have credited the 1-month mobile data bundle to the student. They will receive an automated WhatsApp confirmation message.
                                                    </p>

                                                    <div class="p-3 rounded-3 bg-light mb-3">
                                                        <div class="row g-2 text-xs">
                                                            <div class="col-6">
                                                                <span class="text-muted d-block">Student:</span>
                                                                <span class="fw-bold text-dark">{{ $reward->user->name }}</span>
                                                            </div>
                                                            <div class="col-6">
                                                                <span class="text-muted d-block">Network Provider:</span>
                                                                <span class="fw-bold text-primary">{{ $reward->network_provider }}</span>
                                                            </div>
                                                            <div class="col-12 mt-2">
                                                                <span class="text-muted d-block">Phone Number to Credit:</span>
                                                                <span class="fw-bold font-monospace fs-6 text-dark">{{ $reward->phone_number }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-xs fw-bold text-muted text-uppercase">Admin Reference / Transaction Note (Optional)</label>
                                                        <textarea name="admin_notes" rows="2" class="form-control text-xs"
                                                                  placeholder="e.g. VTU Reference #9283921 credited via MTN SME Data Portal"></textarea>
                                                        <span class="text-xxs text-muted">This note is recorded in the student's log and included in their WhatsApp notification.</span>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 pt-0">
                                                    <button type="button" class="btn btn-sm btn-light rounded-pill px-3 text-xs" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 text-xs fw-bold">
                                                        <i class="ri-checkbox-circle-line me-1"></i> Confirm &amp; Mark Fulfilled
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- View Fulfilled Receipt Modal -->
                            @if($reward->status === 'fulfilled')
                                <div class="modal fade" id="viewFulfillModal{{ $reward->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold text-dark">
                                                    <i class="ri-checkbox-circle-fill text-success me-2"></i>Reward Fulfillment Receipt
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body py-4">
                                                <div class="p-3 rounded-3 bg-success-subtle mb-3">
                                                    <div class="d-flex align-items-center gap-2 text-success fw-bold text-xs mb-1">
                                                        <i class="ri-check-line"></i> 1-Month Free Data Subscription Credited
                                                    </div>
                                                    <div class="text-xs text-muted">
                                                        Fulfilled on {{ $reward->fulfilled_at ? $reward->fulfilled_at->format('M d, Y \a\t h:i A') : '—' }}
                                                    </div>
                                                </div>
                                                <div class="p-3 rounded-3 bg-light">
                                                    <div class="row g-2 text-xs">
                                                        <div class="col-6">
                                                            <span class="text-muted d-block">Student:</span>
                                                            <span class="fw-bold text-dark">{{ $reward->user->name }}</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="text-muted d-block">Network:</span>
                                                            <span class="fw-bold text-dark">{{ $reward->network_provider }}</span>
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <span class="text-muted d-block">Phone Number Credited:</span>
                                                            <span class="fw-bold font-monospace text-dark">{{ $reward->phone_number }}</span>
                                                        </div>
                                                        @if($reward->admin_notes)
                                                            <div class="col-12 mt-2 pt-2 border-top">
                                                                <span class="text-muted d-block">Admin Notes / Ref:</span>
                                                                <span class="text-dark">{{ $reward->admin_notes }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-sm btn-light rounded-pill px-4 text-xs" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <div class="py-4">
                                        <i class="ri-trophy-line fs-1 text-muted opacity-50 mb-2 d-block"></i>
                                        <p class="mb-0 fw-medium">No milestone data rewards found.</p>
                                        <small class="text-muted">Students who complete 10 courses and earn 10 badges will automatically appear here.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($rewards->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $rewards->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
