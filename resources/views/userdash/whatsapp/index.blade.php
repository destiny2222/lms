@extends('layouts.admin')

@section('page_title', 'WhatsApp Bot Command Center & Broadcasts')

@section('content')
<div class="container-fluid p-0">

    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">WhatsApp Follow-Up & Broadcast Engine</h4>
            <p class="text-muted text-sm mb-0">Automated unstarted/incomplete reminders, two-way bot responses, and admin bulk announcements.</p>
        </div>

        <form action="{{ route('admin.whatsapp.reminders') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2">
                <i class="ri-refresh-line"></i> Run Automated Daily Follow-Up Cycle
            </button>
        </form>
    </div>

    <!-- Stats Summary Row -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <span class="text-xs text-muted text-uppercase fw-bold">Total Interactions</span>
                <h3 class="fw-bold text-dark mb-0 mt-1">{{ $stats['total'] }}</h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <span class="text-xs text-muted text-uppercase fw-bold">Outbound Dispatched</span>
                <h3 class="fw-bold text-primary mb-0 mt-1">{{ $stats['outbound'] }}</h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <span class="text-xs text-muted text-uppercase fw-bold">Inbound Student Replies</span>
                <h3 class="fw-bold text-success mb-0 mt-1">{{ $stats['inbound'] }}</h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <span class="text-xs text-muted text-uppercase fw-bold">Automated Reminders</span>
                <h3 class="fw-bold text-warning mb-0 mt-1">{{ $stats['reminders'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Main Working Grid: Bulk Broadcast Form & Meta Config -->
    <div class="row g-4 mb-4">
        <!-- Broadcast Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="w-36-px h-36-px rounded-circle bg-success text-white d-flex align-items-center justify-content-center fs-5">
                        <i class="ri-broadcast-line"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-0">Send Bulk WhatsApp Message / Announcement</h5>
                </div>

                <form action="{{ route('admin.whatsapp.bulk') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Announcement Title</label>
                        <input type="text" name="title" class="form-control bg-light" placeholder="e.g. Important Course Deadline Reminder" value="{{ old('title') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Target Recipients</label>
                        <select name="recipient_group" id="recipient_group" class="form-select bg-light" onchange="toggleRecipientFields()">
                            <option value="all_students">All Registered Students ({{ $students->count() }} with phone numbers)</option>
                            <option value="course_students">Enrolled Students in Specific Course</option>
                            <option value="custom_number">Direct Test Number (Single Recipient)</option>
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="course_select_group">
                        <label class="form-label fw-semibold text-sm">Select Course</label>
                        <select name="course_id" class="form-select bg-light">
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}">{{ $c->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="custom_phone_group">
                        <label class="form-label fw-semibold text-sm">Recipient Phone Number</label>
                        <input type="text" name="custom_phone" class="form-control bg-light" placeholder="+12345678901 or 08012345678">
                        <div class="form-text text-xs text-muted">Use international format without spaces.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Message Content</label>
                        <textarea name="message" rows="4" class="form-control bg-light" required placeholder="Type the announcement here. Students will receive this directly in their WhatsApp DM..."></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success px-4 py-2 rounded-pill fw-bold shadow-sm d-flex align-items-center gap-2">
                            <i class="ri-send-plane-fill"></i> Broadcast via WhatsApp
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Meta WhatsApp Cloud API Setup Guide -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="ri-settings-4-line fs-4 text-primary"></i>
                    <h6 class="fw-bold text-dark mb-0">Meta Cloud API Webhook</h6>
                </div>

                <p class="text-xs text-muted mb-3">
                    Configure your Meta WhatsApp Business Cloud Webhook in Facebook Developer Portal with these credentials:
                </p>

                <div class="mb-2">
                    <label class="text-xs fw-bold text-muted text-uppercase">Callback Webhook URL:</label>
                    <input type="text" class="form-control form-control-sm bg-light font-monospace" readonly value="{{ url('/api/whatsapp/webhook') }}">
                </div>

                <div class="mb-3">
                    <label class="text-xs fw-bold text-muted text-uppercase">Verify Token:</label>
                    <input type="text" class="form-control form-control-sm bg-light font-monospace" readonly value="lms_webhook_secret_token">
                </div>

                <div class="p-3 bg-light rounded-3 text-xs text-muted">
                    <strong>Two-Way Interactive Commands:</strong>
                    <ul class="mb-0 ps-3 mt-1">
                        <li><code>PROGRESS</code> — Current course percentage</li>
                        <li><code>NEXT</code> — Link to next video lesson</li>
                        <li><code>CERTIFICATE</code> — Download badges</li>
                        <li><code>COURSES</code> — View new courses</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Communication Audit Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark mb-0">WhatsApp Communication Log & Message History</h5>
            <span class="badge bg-light text-dark border">{{ $messages->total() }} Logged Entries</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-sm">
                <thead class="table-light text-xs text-muted text-uppercase">
                    <tr>
                        <th>Time</th>
                        <th>Direction</th>
                        <th>Recipient / Sender</th>
                        <th>Type / Trigger</th>
                        <th>Message Content</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $msg)
                        <tr>
                            <td class="text-nowrap text-xs text-muted">{{ $msg->created_at->format('M d, H:i') }}</td>
                            <td>
                                <span class="badge {{ $msg->direction === 'outbound' ? 'bg-primary-subtle text-primary' : 'bg-success-subtle text-success' }} rounded-pill text-xs">
                                    {{ $msg->direction === 'outbound' ? '⬆ Outbound' : '⬇ Inbound' }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $msg->phone_number }}</div>
                                <div class="text-xs text-muted">{{ $msg->user->name ?? 'External' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border text-xs">
                                    {{ str_replace('_', ' ', $msg->trigger_type) }}
                                </span>
                            </td>
                            <td class="text-wrap" style="max-width: 380px;">
                                <div class="text-xs lh-base text-dark">{{ $msg->message_body }}</div>
                            </td>
                            <td>
                                <span class="badge {{ $msg->status === 'sent' || $msg->status === 'delivered' ? 'bg-success' : ($msg->status === 'failed' ? 'bg-danger' : 'bg-warning text-dark') }} rounded-pill text-xs">
                                    {{ ucfirst($msg->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No messages sent yet. Use the bulk broadcast form above or click "Run Automated Daily Follow-Up Cycle".</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3 border-top">
            {{ $messages->links() }}
        </div>
    </div>

</div>

<script>
    function toggleRecipientFields() {
        var group = document.getElementById('recipient_group').value;
        var courseGroup = document.getElementById('course_select_group');
        var phoneGroup = document.getElementById('custom_phone_group');

        if (group === 'course_students') {
            courseGroup.classList.remove('d-none');
            phoneGroup.classList.add('d-none');
        } else if (group === 'custom_number') {
            courseGroup.classList.add('d-none');
            phoneGroup.classList.remove('d-none');
        } else {
            courseGroup.classList.add('d-none');
            phoneGroup.classList.add('d-none');
        }
    }
</script>
@endsection
