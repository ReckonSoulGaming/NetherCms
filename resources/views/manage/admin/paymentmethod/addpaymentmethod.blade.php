@extends('manage.admin.index')



@section('breadcrumb')
    <b class="breadcrumb-item">{{ config('app.name') }}</b>
    <li class="breadcrumb-item active">Payment Gateways</li>
@endsection

@section('content')

<style>
.card {
    border-radius: 18px !important;
}
.card-header {
    border-top-left-radius: 18px !important;
    border-top-right-radius: 18px !important;
}
.form-control,
.form-select {
    border-radius: 10px;
}
.btn {
    border-radius: 10px;
}
.gateway-box {
    border: 1px solid #e5e5e5;
    border-radius: 14px;
    padding: 20px;
    margin-top: 15px;
    background: #fafafa;
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-gray-800 mb-1">Add New Payment Gateway</h1>
        <p class="text-muted small mb-0">Configure Razorpay, Stripe, or PayPal</p>
    </div>
    <a href="{{ route('paymentmethod.index') }}" class="btn btn-light btn-lg shadow-sm px-4">
        ← Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">

        <div class="card shadow border-0">
            <div class="card-header py-3 d-flex justify-content-between align-items-center"
                 style="background: linear-gradient(90deg, #1cc88a, #17a673);">
                <h6 class="m-0 fw-bold text-white">Gateway Configuration</h6>
                <span class="badge bg-light text-dark px-3">New</span>
            </div>

            <div class="card-body p-5">

                <form action="{{ route('paymentmethod.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">

                        {{-- Gateway --}}
                        <div class="col-12">
                            <label class="form-label fw-bold">Payment Gateway</label>
                            <select name="method_provider" id="provider" class="form-select form-select-lg" required>
                                <option value="">Select Gateway</option>
                                <option value="razorpay">Razorpay</option>
                                <option value="stripe">Stripe</option>
                                <option value="paypal">PayPal</option>
                            </select>
                        </div>

                        {{-- RAZORPAY --}}
                        <div id="razorpay_fields" class="d-none">
                            <div class="gateway-box">
                                <h5 class="fw-bold text-primary mb-3">Razorpay Settings</h5>

                                <label class="form-label">Razorpay Key</label>
                                <input type="text" name="razorpay_key" class="form-control form-control-lg"
                                       placeholder="rzp_test_xxxxx">

                                <label class="form-label mt-3">Razorpay Secret</label>
                                <input type="text" name="razorpay_secret" class="form-control form-control-lg"
                                       placeholder="secret_xxxxx">
                            </div>
                        </div>

                        {{-- STRIPE --}}
                        <div id="stripe_fields" class="d-none">
                            <div class="gateway-box">
                                <h5 class="fw-bold text-info mb-3">Stripe Settings</h5>

                                <label class="form-label">Publishable Key</label>
                                <input type="text" name="stripe_publishable_key" class="form-control form-control-lg"
                                       placeholder="pk_live_xxxx">

                                <label class="form-label mt-3">Secret Key</label>
                                <input type="text" name="stripe_secret_key" class="form-control form-control-lg"
                                       placeholder="sk_live_xxxx">
                            </div>
                        </div>

                        {{-- PAYPAL --}}
                        <div id="paypal_fields" class="d-none">
                            <div class="gateway-box">
                                <h5 class="fw-bold text-warning mb-3">PayPal Settings</h5>

                                <label class="form-label">Client ID</label>
                                <input type="text" name="paypal_client_id" class="form-control form-control-lg"
                                       placeholder="paypal-client-id">

                                <label class="form-label mt-3">Secret Key</label>
                                <input type="text" name="paypal_secret_key" class="form-control form-control-lg"
                                       placeholder="paypal-secret">

                                <label class="form-label mt-3">Mode</label>
                                <select name="paypal_mode" class="form-select form-select-lg">
                                    <option value="sandbox">Sandbox</option>
                                    <option value="live">Live</option>
                                </select>
                            </div>
                        </div>

                        {{-- Webhook Secret --}}
                        <div class="col-12 mt-4">
                            <label class="form-label fw-bold">Webhook Secret (optional)</label>
                            <input type="text" name="webhook_secret" class="form-control form-control-lg"
                                   placeholder="Webhook Secret">
                        </div>

                        {{-- Callback URL --}}
                        <div class="col-12">
                            <label class="form-label fw-bold">Callback URL</label>
                            <input type="text" name="callback_url" class="form-control form-control-lg"
                                   placeholder="https://yourwebsite.com/callback">
                        </div>

                        {{-- Enabled --}}
                        <div class="col-12">
                            <label class="form-label fw-bold">Enable Gateway?</label>
                            <select name="enabled" class="form-select form-select-lg">
                                <option value="1" selected>Enabled</option>
                                <option value="0">Disabled</option>
                            </select>
                        </div>

                    </div>

                    <hr class="my-5">

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                            Save Gateway
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

{{-- Show / Hide Fields --}}
<script>
document.getElementById("provider").addEventListener("change", function () {
    let val = this.value;

    document.getElementById("razorpay_fields").classList.add("d-none");
    document.getElementById("stripe_fields").classList.add("d-none");
    document.getElementById("paypal_fields").classList.add("d-none");

    if (val === "razorpay") document.getElementById("razorpay_fields").classList.remove("d-none");
    if (val === "stripe") document.getElementById("stripe_fields").classList.remove("d-none");
    if (val === "paypal") document.getElementById("paypal_fields").classList.remove("d-none");
});
</script>

@endsection
