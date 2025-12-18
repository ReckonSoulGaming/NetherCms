{{-- PAYMENT PLAN LIST PAGE --}}
@extends('manage.admin.index')



@section('breadcrumb')
    <b class="breadcrumb-item">{{ config('app.name') }}</b>
    <li class="breadcrumb-item active" aria-current="page">Payment Method</li>
@endsection

@section('content')

<style>
/* GLOBAL UI POLISH */
.card {
    border-radius: 18px !important;
}
.card-header {
    border-top-left-radius: 18px !important;
    border-top-right-radius: 18px !important;
}
.badge {
    border-radius: 10px;
}
.btn {
    border-radius: 10px;
}

/* MOBILE RESPONSIVE TABLE */
@media (max-width: 768px) {
    table thead { display: none; }

    table tbody tr {
        display: block;
        margin-bottom: 14px;
        padding: 14px;
        border: 1px solid #e6e6e6;
        border-radius: 14px;
        background: #fff;
    }

    table tbody td {
        display: flex;
        justify-content: space-between;
        padding: 6px 8px;
        align-items: center;
        text-align: right;
    }

    table tbody td:before {
        content: attr(data-label);
        width: 50%;
        font-weight: 600;
        text-align: left;
        color: #666;
    }

    .btn-group {
        width: 100%;
        justify-content: flex-end;
    }
}

.masked {
    font-family: monospace;
    color: #888;
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-gray-800 mb-1">Payment Method</h1>
        <p class="text-muted small mb-0">Manage payment gateway configuration</p>
    </div>

    <a href="{{ route('paymentmethod.create') }}" class="btn btn-success btn-lg shadow-sm px-4">
        <i class="fas fa-plus me-2"></i>Add Gateway
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-header py-3 d-flex justify-content-between align-items-center"
         style="background: linear-gradient(90deg, #4e73df, #224abe);">
        <h6 class="fw-bold text-white mb-0">Configured Payment Gateways</h6>
        <span class="badge bg-light text-dark fs-6">
            {{ count($options) }} gateways
        </span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th class="ps-3">#</th>
                    <th>Gateway</th>
                    <th>API Key</th>
                    <th>Secret Key</th>
                    <th>Webhook Secret</th>
                    <th>Mode</th>
                    <th class="text-center">Enabled</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($options as $option)
                    <tr>

                        {{-- ROW NUMBER --}}
                        <td class="ps-3 fw-bold">{{ $loop->iteration }}</td>

                        {{-- PROVIDER --}}
                        <td data-label="Gateway">
                            <span class="badge bg-dark px-3 py-2">
                                {{ ucfirst($option->method_provider) }}
                            </span>
                        </td>

                        {{-- API KEY --}}
                        <td data-label="API Key">
                            @php
                                $apiKey = $option->razorpay_key
                                    ?? $option->stripe_publishable_key
                                    ?? $option->paypal_client_id
                                    ?? null;
                            @endphp

                            @if ($apiKey)
                                <span class="masked bg-light px-2 py-1 rounded">
                                    {{ substr($apiKey, 0, 6) }}•••••
                                </span>
                            @else
                                <span class="badge bg-danger">Not Set</span>
                            @endif
                        </td>

                        {{-- SECRET KEY --}}
                        <td data-label="Secret Key">
                            @php
                                $secret = $option->razorpay_secret
                                    ?? $option->stripe_secret_key
                                    ?? $option->paypal_secret_key
                                    ?? null;
                            @endphp

                            @if ($secret)
                                <span class="masked bg-light px-2 py-1 rounded">
                                    {{ substr($secret, 0, 4) }}••••••
                                </span>
                            @else
                                <span class="badge bg-danger">Not Set</span>
                            @endif
                        </td>

                        {{-- WEBHOOK --}}
                        <td data-label="Webhook">
                            @if ($option->webhook_secret)
                                <span class="masked bg-light px-2 py-1 rounded">
                                    {{ substr($option->webhook_secret, 0, 4) }}••••
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        {{-- MODE --}}
                        <td data-label="Mode">
                            <span class="badge bg-secondary px-3 py-2">
                                {{ strtoupper($option->paypal_mode ?? 'live') }}
                            </span>
                        </td>

                        {{-- STATUS --}}
                        <td data-label="Enabled" class="text-center">
                            @if ($option->enabled)
                                <span class="badge bg-success px-3 py-2">Enabled</span>
                            @else
                                <span class="badge bg-danger px-3 py-2">Disabled</span>
                            @endif
                        </td>

                        {{-- ACTIONS --}}
                        <td class="text-center">
                            <div class="btn-group shadow-sm">
                                <a href="{{ route('paymentmethod.edit', $option->method_id) }}"
                                   class="btn btn-info btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('paymentmethod.destroy', $option->method_id) }}"
                                      method="POST" class="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this payment gateway?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="fas fa-credit-card fa-4x opacity-25 mb-3"></i>
                            <div class="h5">No gateways configured yet</div>
                            <small>Add your first payment gateway to get started!</small>
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection
