{{-- resources/views/manage/history/index.blade.php --}}
@extends('manage.user.index')

@section('title', 'Account Activity History')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 fw-bold">Account Activity History</h1>
        <p class="text-muted small">All actions and events recorded on your account</p>
    </div>
</div>

<div class="card shadow border-0 overflow-hidden">
    <div class="card-header py-4 text-white text-center fw-bold"
         style="background: linear-gradient(90deg, #4e73df, #224abe);">
        <h5 class="mb-0">Activity Log</h5>
    </div>

    <div class="card-body p-0">
        <div class="row g-0">
            {{-- Activity Table --}}
            <div class="col-lg-9">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 120px;">Ref ID</th>
                                <th>Activity Details</th>
                                <th style="width: 180px;">Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($history as $log)
                                <tr class="history-row cursor-pointer"
                                    data-log-id="{{ $log->log_id }}"
                                    data-detail="{{ $log->action_detail }}"
                                    data-type="{{ $log->type ?? 'General' }}"
                                    data-created="{{ $log->created_at->format('d M Y, H:i:s') }}">
                                    <td class="text-center fw-bold text-primary">#{{ $log->log_id }}</td>
                                    <td class="pe-3">
                                        <div class="fw-600">{{ Str::limit($log->action_detail, 80) }}</div>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $log->created_at->format('d M Y') }}<br>
                                        <span class="text-primary">{{ $log->created_at->format('H:i') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-6">
                                        <i class="fas fa-history fa-4x text-muted opacity-30 mb-4"></i>
                                        <h5 class="text-muted">No activity recorded yet</h5>
                                        <p class="text-muted small">Your actions will appear here</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Detail Panel --}}
            <div class="col-lg-3 bg-light border-start border-opacity-50">
                <div class="p-4 sticky-top" style="top: 100px;">
                    <div class="d-flex align-items-center mb-4">
                        <i class="fas fa-info-circle fa-2x text-primary me-3"></i>
                        <h6 class="fw-bold text-primary mb-0">Log Details</h6>
                    </div>

                    <div id="detailContent" class="mt-4">
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-hand-pointer fa-3x mb-3 opacity-25"></i>
                            <p class="small">Click any row to view full details</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Click-to-show details + styling --}}
<script>
    document.querySelectorAll('.history-row').forEach(row => {
        row.addEventListener('click', function () {
            document.querySelectorAll('.history-row').forEach(r => r.classList.remove('table-primary'));
            this.classList.add('table-primary');

            const detail = this.dataset.detail || 'No additional details available.';
            const type = this.dataset.type;
            const created = this.dataset.created;

            document.getElementById('detailContent').innerHTML = `
                <div class="border-bottom pb-3 mb-3">
                    <strong>Action Performed:</strong>
                </div>
                <p class="text-muted small mb-4">${detail}</p>

                <div class="small">
                    <div class="mb-2"><strong>User:</strong> <span class="fw-bold text-primary">{{ Auth::user()->name }}</span></div>
                    <div class="mb-2"><strong>Type:</strong> <span class="badge bg-info text-dark px-3 py-1">${type}</span></div>
                    <div class="text-muted"><strong>Timestamp:</strong><br>${created}</div>
                </div>
            `;
        });
    });

    // Auto-select first row on page load
    if (document.querySelector('.history-row')) {
        document.querySelector('.history-row').click();
    }
</script>

{{-- Keep your exact premium look --}}
<style>
    .table-hover tbody tr:hover {
        background-color: #f0f5ff !important;
    }
    .table-hover tbody tr.table-primary {
        background-color: #e6f0ff !important;
        font-weight: 600;
    }
    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 1.5rem 3.5rem rgba(0,0,0,.18) !important;
        transition: all 0.4s ease;
    }
    @media (max-width: 992px) {
        .border-start { border-top: 1px solid #dee2e6 !important; border-left: none !important; }
    }
</style>

@endsection