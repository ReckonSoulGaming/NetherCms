

@extends('layouts.app')

@section('title', 'Checkout - ' . $packages->package_name)

{{-- Only Razorpay + tiny custom styles needed --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .checkout-card {
        background: rgba(20, 25, 55, 0.92);
        backdrop-filter: blur(18px);
        border: 1px solid rgba(0, 212, 255, 0.3);
        border-radius: 24px;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.6);
        overflow: hidden;
    }
    .item-image {
        width: 180px;
        height: 180px;
        object-fit: cover;
        border-radius: 16px;
        border: 5px solid var(--primary);
        box-shadow: 0 0 30px rgba(0, 212, 255, 0.4);
    }
    .price-original {
        text-decoration: line-through;
        color: #777;
        font-size: 1.4rem;
    }
    .price-final {
        font-size: 3.8rem;
        font-weight: 900;
        background: linear-gradient(90deg, var(--primary), #ff00ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .btn-confirm {
        background: linear-gradient(45deg, var(--primary), #ff00ff);
        color: black;
        padding: 1.3rem 3rem;
        font-size: 1.5rem;
        font-weight: 900;
        border-radius: 60px;
        box-shadow: 0 15px 40px rgba(0, 212, 255, 0.5);
        transition: all 0.4s;
    }
    .btn-confirm:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 60px rgba(0, 212, 255, 0.7);
    }
    .btn-back {
        border: 2px solid rgba(255,255,255,0.3);
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 60px;
        font-weight: 700;
        transition: all 0.3s;
    }
    .btn-back:hover {
        background: rgba(255,255,255,0.1);
        border-color: var(--primary);
    }
</style>
@endpush

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById("rzpPay").onclick = function () {
    let package_id = document.getElementById("package_id").value;

    fetch("{{ route('razorpay.order') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ package_id: package_id })
    })
    .then(async res => {
        const text = await res.text();
        try { var data = JSON.parse(text); }
        catch (e) {
            console.error("Backend returned HTML:", text);
            window.location.href = "/checkout/failed"; 
            throw e;
        }
        return data;
    })
    .then(data => {
        if (!data.success) {
            window.location.href = "/checkout/failed"; 
            return;
        }

        var options = {
            "key": data.key,
            "amount": data.amount,
            "currency": "INR",
            "name": "{{ $packages->package_name }}",
            "description": "Minecraft Package Purchase",
            "order_id": data.order_id,
            "handler": function (response) {

                // VERIFY PAYMENT
                fetch("{{ route('razorpay.verify') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        payment_id: response.razorpay_payment_id,
                        order_id: response.razorpay_order_id,
                        signature: response.razorpay_signature
                    })
                })
                .then(res => res.json())
                .then(result => {
                    if (result.success) {
                        window.location.href = "/checkout/success"; 
                    } else {
                        window.location.href = "/checkout/failed"; 
                    }
                });
            },
            "theme": { "color": "#00d4ff" }
        };

        var rzp = new Razorpay(options);
        rzp.open();
    })
    .catch(err => {
        console.error(err);
        window.location.href = "/checkout/failed"; 
    });
};
</script>

@endpush

@section('content')


{{-- Hero - same as all other forum pages --}}
<div class="hero-section text-white text-center position-relative">
    <div class="container position-relative">
        <h1 class="display-3 fw-bold text-uppercase mb-3">CHECKOUT</h1>
        <h5 class="fw-light fs-3 opacity-90">>Confirm & Complete Your Purchase</h5>
    </div>
</div>


<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">

            <div class="checkout-card p-5 shadow-lg">
                {{-- Package Info --}}
                <div class="text-center mb-5">
                    <img src="{{ '/uploads/packages/cover/'.$packages->package_image_path }}"
                         alt="{{ $packages->package_name }}"
                         class="item-image mb-4">

                    <h2 class="fw-bold text-white mb-3">{{ $packages->package_name }}</h2>
                    <p class="text-light opacity-80 fs-4">
                        <i class="fas fa-tag me-2"></i>{{ $packages->category->category_name }}
                    </p>
                    <p class="text-light opacity-70">
                        Buying as: <strong class="text-primary">{{ Auth::user()->name }}</strong>
                    </p>
                </div>

                {{-- Price Summary --}}
                <div class="bg-dark bg-opacity-70 p-5 rounded-4 mb-5">
                    <div class="d-flex justify-content-between align-items-end mb-3">
                        <span class="fs-5">Original Price</span>
                        <span class="price-original fs-4">  {{ currency_symbol() }}
            {{ number_format(currency_convert($packages->package_price), 2) }}</span>
                    </div>

                    @if($packages->package_discount_price)
                    <div class="d-flex justify-content-between align-items-end text-success">
                        <span class="fs-5 fw-bold">Discounted Price</span>
                        <span class="fs-3 fw-bold">   {{ currency_symbol() }}
                {{ number_format(currency_convert($packages->package_discount_price), 2) }}</span>
                    </div>
                    @endif

                    <hr class="border-light border-opacity-10 my-4">

                    <div class="d-flex justify-content-between align-items-end">
                        <span class="h3 fw-bold text-white">Total Amount</span>
                        <span class="price-final">
                             {{ currency_symbol() }}
            {{ number_format(currency_convert($packages->package_discount_price ?? $packages->package_price), 2) }}
                        </span>
                    </div>
                </div>

                <input type="hidden" id="package_id" value="{{ $packages->package_id }}">

                {{-- Action Buttons --}}
                <div class="text-center">
                    <button id="rzpPay" class="btn btn-confirm fw-bold">
                        Pay Now
                    </button>
                    <a href="{{ route('store') }}" class="btn btn-back ms-4">
                        Back to Store
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
