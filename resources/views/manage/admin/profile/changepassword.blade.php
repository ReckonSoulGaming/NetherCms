@extends('manage.admin.index')

@section('title', 'Change Password')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 fw-bold">Change Password</h1>
        <p class="text-muted small">Update your account password securely</p>
    </div>
</div>

<div class="row g-5">
    {{-- Main Form Card --}}
    <div class="col-lg-7">
        <div class="card shadow border-0">
            <div class="card-header py-4 text-white text-center fw-bold"
                 style="background: linear-gradient(90deg, #4e73df, #224abe);">
                <h5 class="mb-0">Set New Password</h5>
            </div>

            <div class="card-body p-5">
                <form method="POST" action="{{ route('profile.store') }}">
                    @csrf

                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-bold">New Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control form-control-lg @error('password') is-invalid @enderror"
                                   placeholder="Enter strong password"
                                   required autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback d-block mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Confirm New Password</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control form-control-lg"
                                   placeholder="Re-type password"
                                   required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm fw-bold">
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tips Card --}}
    <div class="col-lg-5">
        <div class="card shadow border-0 h-100">
            <div class="card-header py-4 text-white text-center fw-bold"
                 style="background: linear-gradient(90deg, #ff9c27, #f39c12);">
                <i class="fas fa-shield-alt me-2"></i> Password Tips
            </div>
            <div class="card-body p-5">
                <h6 class="fw-bold mb-3">Create a strong password:</h6>
                <ul class="list-unstyled text-muted">
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> At least 8 characters</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> One uppercase letter (A-Z)</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> One lowercase letter (a-z)</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> One number (0-9)</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> One special character (!@#$%^&*)</li>
                </ul>
                <div class="alert alert-info small mt-4 py-3">
                    <i class="fas fa-info-circle me-2"></i>
                    Avoid using your name, birthday, or common words.
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Optional hover effect --}}
<style>
    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 1.5rem 3rem rgba(0,0,0,.2) !important;
        transition: all 0.4s ease;
    }
</style>

@endsection