@extends('manage.user.index')

@section('title', 'Package Claim')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 fw-bold">Package Claim</h1>
       <p class="text-muted small">
    Your purchased packages will be sent to:
    <strong class="text-primary">
        {{ Auth::user()->player_type == 'bedrock' ? '.' . Auth::user()->name : Auth::user()->name }}
    </strong>
</p>

    </div>
</div>

{{-- Success / Error Alerts --}}
@if(session('claimGetPackage'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Package successfully claimed!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('somethingError'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Could not send command to server. Please try again later.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Main Card --}}
<div class="card shadow border-0 overflow-hidden">
    <div class="card-header py-4 text-white text-center fw-bold"
         style="background: linear-gradient(90deg, #4e73df, #224abe);">
        <ul class="nav nav-tabs card-header-tabs mb-0 border-0">
            <li class="nav-item">
                <button class="nav-link active fw-bold text-dark bg-white rounded-0" data-bs-toggle="tab" data-bs-target="#shop">
                    Shop Packages
                </button>
            </li>
            
        </ul>
    </div>

    <div class="card-body p-4 p-lg-5 bg-white">
        <div class="tab-content">

            {{-- SHOP PACKAGES --}}
            <div class="tab-pane fade show active" id="shop">
                <ul class="nav nav-pills mb-4">
                    <li class="nav-item">
                        <a class="nav-link active px-4 py-2 fw-bold" data-bs-toggle="pill" href="#pending">
                            Pending ({{ $claims->count() }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-4 py-2 fw-bold" data-bs-toggle="pill" href="#claimed">
                            Claimed ({{ $claimed->count() }})
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    {{-- PENDING --}}
                    <div class="tab-pane fade show active" id="pending">
                        <div class="row g-4 justify-content-start">
                            @forelse($claims as $claim)
                                <div class="col-lg-4 col-md-6">
                                    <div class="card border-0 shadow-sm h-100 text-center hover-lift transition">
                                        <div class="card-body p-4">
                                            <div class="badge bg-warning text-dark fw-bold mb-3 px-4 py-2">
                                                Not Claimed
                                            </div>
                                            <h5 class="fw-bold mb-2">{{ $claim->package->package_name }}</h5>
                                            <p class="text-muted small mb-3">Order #{{ $claim->claim_id }}</p>

                                            <img src="{{ $claim->package->package_image_path
                                                ? asset('storage/packages/cover/' . $claim->package->package_image_path)
                                                : asset('images/default-package.png') }}"
                                                 class="rounded shadow-sm mb-4"
                                                 style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #4e73df;">

                                            <form method="POST" action="{{ route('claim.store') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $claim->claim_id }}">
                                                <button type="submit" class="btn btn-success btn-lg w-100 fw-bold shadow">
                                                    Claim Package
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-6">
                                    <i class="fas fa-inbox fa-5x text-muted opacity-40 mb-4"></i>
                                    <h4 class="text-muted">No pending packages</h4>
                                    <p class="text-muted">Your purchased items will appear here.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- CLAIMED --}}
                    <div class="tab-pane fade" id="claimed">
                        <div class="row g-4 justify-content-start">
                            @forelse($claimed as $claim)
                                <div class="col-lg-4 col-md-6">
                                    <div class="card border-0 shadow-sm h-100 text-center">
                                        <div class="card-body p-4">
                                            <div class="badge bg-success fw-bold mb-3 px-4 py-2">
                                                Claimed
                                            </div>
                                            <h5 class="fw-bold mb-2">{{ $claim->package->package_name }}</h5>
                                            <p class="text-muted small mb-3">
                                                {{ $claim->updated_at->format('d M Y • H:i') }}
                                            </p>

                                            <img src="{{ $claim->package->package_image_path
                                                ? asset('storage/packages/cover/' . $claim->package->package_image_path)
                                                : asset('images/default-package.png') }}"
                                                 class="rounded shadow-sm mb-4"
                                                 style="width: 120px; height: 120px; object-fit: cover;">

                                            <button class="btn btn-secondary w-100" disabled>
                                                Already Claimed
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-6">
                                    <i class="fas fa-check-circle fa-5x text-success opacity-20 mb-4"></i>
                                    <h5 class="text-muted">No claimed packages yet</h5>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

           

        </div>
    </div>
</div>

{{-- Small hover effect --}}
<style>
    .hover-lift {
        transition: all 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(78,115,223,0.2) !important;
    }
</style>

@endsection