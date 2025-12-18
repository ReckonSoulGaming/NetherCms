{{-- resources/views/manage/paymenthistory/index.blade.php --}}
@extends('manage.user.index')

@section('title', 'Payment History')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 fw-bold">Payment History</h1>
        <p class="text-muted small">All your purchase transactions in one place</p>
    </div>
</div>

<div class="card shadow-lg border-0 overflow-hidden">
    <div class="card-header py-4 text-white text-center fw-bold"
         style="background: linear-gradient(90deg, #4e73df, #224abe);">
        <h5 class="mb-0">
            Payment Transactions
        </h5>
    </div>

    <div class="card-body p-4 p-lg-5">
        <p class="text-muted mb-4">Track all your payments and purchase history</p>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-center">
                        <th style="width: 100px;">Order #</th>
                        <th>Provider</th>
                        <th>Package</th>
                        <th>Payer Name</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $info)
                        <tr class="text-center align-middle">
                            {{-- Order ID --}}
                            <td class="fw-bold text-primary">#{{ $info->payment_id }}</td>

                            {{-- Provider --}}
                            <td class="text-capitalize fw-semibold">
                                @if($info->payment_provider === 'razorpay')
                                    <i class="fab fa-google-pay text-primary me-1"></i> Razorpay
                                @elseif($info->payment_provider === 'paypal')
                                    <i class="fab fa-paypal text-primary me-1"></i> PayPal
                                @else
                                    {{ ucfirst($info->payment_provider) }}
                                @endif
                            </td>

                            {{-- Package Name --}}
                            <td class="fw-bold">
                                @php
                                    $pkg = \App\Packages::find($info->package_id);
                                @endphp
                                @if($pkg)
                                    {{ $pkg->package_name }}
                                @else
                                    <span class="text-muted small">Deleted Package</span>
                                @endif
                            </td>

                            {{-- Payer --}}
                            <td>{{ $info->payment_payer ?: '—' }}</td>

                            {{-- Amount --}}
                            <td class="fw-bold fs-5 text-dark">
                                ₹{{ number_format($info->payment_amount) }}
                            </td>

                            {{-- Status --}}
                            <td>
                                @if($info->payment_status === 'successful')
                                    <span class="badge bg-success px-4 py-2 fw-bold">
                                        Success
                                    </span>
                                @elseif($info->payment_status === 'failed')
                                    <span class="badge bg-danger px-4 py-2 fw-bold">
                                        Failed
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark px-4 py-2 fw-bold">
                                        {{ ucfirst($info->payment_status) }}
                                    </span>
                                @endif
                            </td>

                            {{-- Date --}}
                            <td class="text-muted small">
                                {{ $info->created_at->format('d M, Y') }}<br>
                                <span class="text-primary fw-600">{{ $info->created_at->format('h:i A') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6">
                                <i class="fas fa-receipt fa-4x text-muted opacity-30 mb-4"></i>
                                <h5 class="text-muted mb-2">No transactions yet</h5>
                                <p class="text-muted small">Your payment history will appear here once you make a purchase.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Hover glow + styling --}}
<style>
    .table-hover tbody tr:hover {
        background-color: #f0f5ff !important;
        transition: all 0.3s;
    }
    .card {
        transition: all 0.4s ease;
    }
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 2rem 4rem rgba(0,0,0,.22) !important;
    }
    .badge {
        font-size: 0.9rem;
        padding: 0.6em 1.2em;
    }
</style>

@endsection