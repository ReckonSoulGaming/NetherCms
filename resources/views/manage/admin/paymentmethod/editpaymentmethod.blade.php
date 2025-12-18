{{-- resources/views/manage/admin/paymentmethod/edit.blade.php --}}
@extends('manage.admin.index')



@section('breadcrumb')
    <b class="breadcrumb-item">{{ config('app.name') }}</b>
    <li class="breadcrumb-item">
        <a href="{{ route('paymentmethod.index') }}">Payment Method</a>
    </li>
    <li class="breadcrumb-item active">Edit</li>
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
.form-control, .form-select {
    border-radius: 10px;
}
.btn {
    border-radius: 10px;
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1 text-gray-800">Edit Payment Gateway</h1>
        <p class="text-muted small mb-0">
            Update API keys for <strong>{{ ucfirst($option->method_provider) }}</strong>
        </p>
    </div>
    <a href="{{ route('paymentmethod.index') }}" class="btn btn-light btn-lg shadow-sm px-4">
        ← Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-xl-7 col-lg-9">

        <div class="card shadow border-0">
            <div class="card-header py-3 d-flex justify-content-between align-items-center"
                 style="background: linear-gradient(90deg, #4e73df, #224abe);">
                <h6 class="fw-bold text-white mb-0">
                    Editing: {{ ucfirst($option->method_provider) }}
                </h6>
                <span class="badge bg-light text-dark px-3">
                    ID: {{ $option->method_id }}
                </span>
            </div>

            <div class="card-body p-5">

                <form action="{{ route('paymentmethod.update', $option->method_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        {{-- Provider --}}
                        <div class="col-12">
                            <label class="form-label fw-bold">Payment Gateway</label>
                            <select name="method_provider" id="gateway" class="form-select form-select-lg" required>
                                <option value="razorpay" {{ $option->method_provider=='razorpay' ? 'selected':'' }}>Razorpay</option>
                                <option value="stripe" {{ $option->method_provider=='stripe' ? 'selected':'' }}>Stripe</option>
                                <option value="paypal" {{ $option->method_provider=='paypal' ? 'selected':'' }}>PayPal</option>
                            </select>
                        </div>

                        {{-- Razorpay Fields --}}
                        <div id="razorpay_fields" class="{{ $option->method_provider=='razorpay' ? '' : 'd-none' }}">
                            <div class="border rounded-4 p-4 mt-3">
                                <h5 class="fw-bold mb-3 text-primary">Razorpay Credentials</h5>

                                <label class="form-label">Razorpay Key</label>
                                <input type="text" name="razorpay_key" class="form-control form-control-lg"
                                       value="{{ old('razorpay_key', $option->razorpay_key) }}">

                                <label class="form-label mt-3">Razorpay Secret</label>
                                <input type="text" name="razorpay_secret" class="form-control form-control-lg"
                                       value="{{ old('razorpay_secret', $option->razorpay_secret) }}">
                            </div>
                        </div>

                        {{-- Stripe Fields --}}
                        <div id="stripe_fields" class="{{ $option->method_provider=='stripe' ? '' : 'd-none' }}">
                            <div class="border rounded-4 p-4 mt-3">
                                <h5 class="fw-bold mb-3 text-info">Stripe Credentials</h5>

                                <label class="form-label">Publishable Key</label>
                                <input type="text" name="stripe_publishable_key" class="form-control form-control-lg"
                                       value="{{ old('stripe_publishable_key', $option->stripe_publishable_key) }}">

                                <label class="form-label mt-3">Secret Key</label>
                                <input type="text" name="stripe_secret_key" class="form-control form-control-lg"
                                       value="{{ old('stripe_secret_key', $option->stripe_secret_key) }}">
                            </div>
                        </div>

                        {{-- PayPal Fields --}}
                        <div id="paypal_fields" class="{{ $option->method_provider=='paypal' ? '' : 'd-none' }}">
                            <div class="border rounded-4 p-4 mt-3">
                                <h5 class="fw-bold mb-3 text-warning">PayPal Credentials</h5>

                                <label class="form-label">Client ID</label>
                                <input type="text" name="paypal_client_id" class="form-control form-control-lg"
                                       value="{{ old('paypal_client_id', $option->paypal_client_id) }}">

                                <label class="form-label mt-3">Secret Key</label>
                                <input type="text" name="paypal_secret_key" class="form-control form-control-lg"
                                       value="{{ old('paypal_secret_key', $option->paypal_secret_key) }}">

                                <label class="form-label mt-3">Mode</label>
                                <select name="paypal_mode" class="form-select form-select-lg">
                                    <option value="sandbox" {{ $option->paypal_mode=='sandbox'?'selected':'' }}>Sandbox</option>
                                    <option value="live" {{ $option->paypal_mode=='live'?'selected':'' }}>Live</option>
                                </select>
                            </div>
                        </div>

                        {{-- Webhook Secret --}}
                        <div class="col-12 mt-4">
                            <label class="form-label fw-bold">Webhook Secret</label>
                            <input type="text" name="webhook_secret" class="form-control form-control-lg"
                                   value="{{ old('webhook_secret', $option->webhook_secret) }}">
                        </div>

                        {{-- Callback URL --}}
                        <div class="col-12">
                            <label class="form-label fw-bold">Callback URL</label>
                            <input type="text" name="callback_url" class="form-control form-control-lg"
                                   value="{{ old('callback_url', $option->callback_url) }}">
                        </div>

                        {{-- Enabled --}}
                        <div class="col-12">
                            <label class="form-label fw-bold">Enabled</label>
                            <select name="enabled" class="form-select form-select-lg">
                                <option value="1" {{ $option->enabled ? 'selected':'' }}>Enabled</option>
                                <option value="0" {{ !$option->enabled ? 'selected':'' }}>Disabled</option>
                            </select>
                        </div>

                    </div>

                    <hr class="my-5">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('paymentmethod.index') }}" class="btn btn-light btn-lg px-5">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            Save Changes
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

{{-- Show/Hide Fields Based on Gateway --}}
<script>
document.getElementById("gateway").addEventListener("change", function () {
    let value = this.value;

    document.getElementById("razorpay_fields").classList.add("d-none");
    document.getElementById("stripe_fields").classList.add("d-none");
    document.getElementById("paypal_fields").classList.add("d-none");

    if (value === "razorpay") document.getElementById("razorpay_fields").classList.remove("d-none");
    if (value === "stripe") document.getElementById("stripe_fields").classList.remove("d-none");
    if (value === "paypal") document.getElementById("paypal_fields").classList.remove("d-none");
});
</script>

@endsection
