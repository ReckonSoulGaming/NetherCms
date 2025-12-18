@extends('manage.admin.index')


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/manage">{{ Auth::user()->name }}</a></li>
    <li class="breadcrumb-item active">Payment History</li>
@endsection

@section('content')

<div class="card shadow-lg border-0 mb-4">
    <div class="card-header bg-gradient-primary text-white py-3">
        <h5 class="mb-0 fw-bold"><i class="fas fa-receipt me-2"></i>Payment History</h5>
    </div>

    <div class="card-body">

        <p class="text-muted mb-4">All your purchase transactions will appear here.</p>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th style="width: 90px;">Order #</th>
                        <th>Provider</th>
                        <th>Package</th>
                        <th>Payer</th>
                        <th>Amount (INR)</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($history as $info)
                        <tr class="text-center">

                             {{--  Order ID --}}
                            <td class="fw-bold text-primary">#{{ $info->payment_id }}</td>

                             {{--  Provider --}}
                            <td class="text-capitalize fw-semibold">
                                @if($info->payment_provider === 'razorpay')
                                    <i class="fa-brands fa-google-pay text-primary me-1"></i> Razorpay
                                @else
                                    {{ ucfirst($info->payment_provider) }}
                                @endif
                            </td>

                             {{--  Package --}}
                            <td class="fw-bold">
                                @php
                                    $pkg = \App\Packages::find($info->package_id);
                                @endphp

                                @if ($pkg)
                                    {{ $pkg->package_name }}
                                @else
                                    <span class="text-muted">Unknown</span>
                                @endif
                            </td>

                             {{--  Payer --}}
                            <td>{{ $info->payment_payer }}</td>

                             {{--  Amount --}}
                            <td class="fw-semibold text-dark">
                                ₹{{ number_format($info->payment_amount) }}
                            </td>

                             {{--  Status --}}
                            <td>
                                @if($info->payment_status === 'successful')
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i> Success
                                    </span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">
                                        <i class="fas fa-times-circle me-1"></i> Failed
                                    </span>
                                @endif
                            </td>

                             {{--  Date --}}
                            <td class="text-muted">
                                {{ $info->created_at->format('d M, Y - h:i A') }}
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-3x opacity-25 mb-3"></i><br>
                                No payment history found yet.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(90deg, #4e73df, #224abe) !important;
    }
    .table-hover tbody tr:hover {
        background-color: #eef3ff !important;
    }
    .card {
        transition: 0.3s;
    }
    .card:hover {
        box-shadow: 0 1rem 3rem rgba(0,0,0,.25) !important;
    }
</style>

@endsection
