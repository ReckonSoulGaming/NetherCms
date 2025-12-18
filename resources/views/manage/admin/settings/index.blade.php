@extends('manage.admin.index')



@section('breadcrumb')
    <b class="breadcrumb-item">{{ config('app.name') }}</b>
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
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
    min-height: 48px;
    border-radius: 12px;
}
textarea.form-control {
    min-height: 180px;
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 fw-bold text-gray-800">General Settings</h1>
        <p class="mb-0 text-muted">Configure server connection, website appearance, and theme</p>
    </div>
    <div>
        @if(session('settings_saved'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm">
                <i class="fas fa-check-circle me-2"></i>Settings saved successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
</div>

<form action="{{ route('settings.store') }}" method="POST">
@csrf

<div class="row g-4">

{{-- ================= SERVER CONNECTION ================= --}}
<div class="col-xl-6">
<div class="card shadow border-0 h-100">
    <div class="card-header py-3 text-white fw-bold" style="background: linear-gradient(90deg, #e74a3b, #c71e1e);">
        Server Connection
    </div>
    <div class="card-body">
        <div class="row g-3">

            <div class="col-12">
                <label class="form-label fw-bold">Hostname</label>
                <input type="text" name="hostname" class="form-control"
                       value="{{ old('hostname', $settings->hostname) }}" required>
                @error('hostname') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Hostname Port</label>
                <input type="number" name="hostname_port" class="form-control"
                       value="{{ old('hostname_port', $settings->hostname_port) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">RCON Port</label>
                <input type="number" name="rcon_port" class="form-control"
                       value="{{ old('rcon_port', $settings->rcon_port) }}" required>
                @error('rcon_port') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">RCON Password</label>
                <input type="text" name="rcon_password" class="form-control"
                       value="{{ old('rcon_password', $settings->rcon_password) }}" required>
                @error('rcon_password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Websender Port</label>
                <input type="number" name="websender_port" class="form-control"
                       value="{{ old('websender_port', $settings->websender_port) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Websender Password</label>
                <input type="text" name="websender_password" class="form-control"
                       value="{{ old('websender_password', $settings->websender_password) }}">
            </div>

        </div>
    </div>
</div>
</div>

{{-- ================= WEBSITE INFO ================= --}}
<div class="col-xl-6">
<div class="card shadow border-0 h-100">
    <div class="card-header py-3 text-white fw-bold" style="background: linear-gradient(90deg, #1cc88a, #17a673);">
        Website Information
    </div>
    <div class="card-body">
        <div class="row g-3">

            <div class="col-12">
                <label class="form-label fw-bold">Website Name</label>
                <input type="text" name="website_name" class="form-control"
                       value="{{ old('website_name', $settings->website_name) }}" required>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Website Description</label>
                <textarea name="website_desc" rows="4" class="form-control">{{ old('website_desc', $settings->website_desc) }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Site Tagline</label>
                <input type="text" name="site_tagline" class="form-control"
                       value="{{ old('site_tagline', $settings->site_tagline) }}"
                       placeholder="The Best Minecraft Experience">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Contact Email</label>
                <input type="email" name="contact_email" class="form-control"
                       value="{{ old('contact_email', $settings->contact_email) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Homepage Highlight</label>
                <input type="text" name="homepage_highlight" class="form-control"
                       value="{{ old('homepage_highlight', $settings->homepage_highlight) }}"
                       placeholder="Summer Sale 50% OFF">
            </div>

        </div>
    </div>
</div>
</div>

{{-- ================= THEME SETTINGS ================= --}}
<div class="col-xl-6">
<div class="card shadow border-0">
    <div class="card-header py-3 text-white fw-bold" style="background: linear-gradient(90deg, #f6c23e, #e67e22);">
        Theme & Colors
    </div>
    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-bold">Navbar Background</label>
                <input type="text" name="navbar_color" class="form-control"
                       value="{{ old('navbar_color', $settings->navbar_color) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Primary Accent</label>
                <input type="text" name="primary_color" class="form-control"
                       value="{{ old('primary_color', $settings->primary_color) }}">
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Background Image URL</label>
                <input type="text" name="background_image" class="form-control"
                       value="{{ old('background_image', $settings->background_image) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Background Color</label>
                <input type="text" name="background_color" class="form-control"
                       value="{{ old('background_color', $settings->background_color) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Navbar Text Color</label>
                <input type="text" name="nav_text_color" class="form-control"
                       value="{{ old('nav_text_color', $settings->nav_text_color) }}">
            </div>

        </div>
    </div>
</div>
</div>

{{-- ================= CUSTOM CSS ================= --}}
<div class="col-xl-6">
<div class="card shadow border-0">
    <div class="card-header py-3 text-white fw-bold" style="background: linear-gradient(90deg, #36b9cc, #1c92d2);">
        Custom CSS
    </div>
    <div class="card-body">
        <textarea name="custom_css" class="form-control font-monospace">{{ old('custom_css', $settings->custom_css) }}</textarea>
        <div class="form-text mt-2">
            Advanced styling — use with caution. Applied globally.
        </div>
    </div>
</div>
</div>

</div>

<div class="text-center mt-5">
    <button type="submit" class="btn btn-success btn-lg px-5 shadow">
        <i class="fas fa-save me-2"></i>Save All Settings
    </button>
</div>

</form>
@endsection
