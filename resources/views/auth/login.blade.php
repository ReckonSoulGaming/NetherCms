@extends('layouts.app')


@section('content')
<div class="container" style="margin-top:100px; margin-bottom:80px;">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                 {{--  TABS --}}
                <ul class="nav nav-pills nav-fill bg-light p-2" id="authTabs">
                    <li class="nav-item">
                        <button class="nav-link active fw-bold" data-bs-toggle="pill" data-bs-target="#loginTab">
                            Login
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold" data-bs-toggle="pill" data-bs-target="#registerTab">
                            Register
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold" data-bs-toggle="pill" data-bs-target="#forgotTab">
                            Forgot
                        </button>
                    </li>
                </ul>

                <div class="card-body p-4">
                    <div class="tab-content">

                         {{--   LOGIN --}}
                        <div class="tab-pane fade show active" id="loginTab">
                            <h3 class="fw-bold mb-1">Login</h3>
                            <p class="text-muted mb-4">Login to your account</p>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" required autofocus>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password</label>
                                    <input type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>

                                <button type="submit" class="btn btn-dark w-100 py-2">
                                    Login
                                </button>
                            </form>
                        </div>

                         {{--  REGISTER --}}
                        <div class="tab-pane fade" id="registerTab">
                            <h3 class="fw-bold mb-1">Register</h3>
                            <p class="text-muted mb-4">Create your account</p>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Username</label>
                                    <input type="text" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
								
								<div class="mb-3">
    <label class="form-label fw-semibold">Player Type</label>
    <select name="player_type" class="form-select" required>
        <option value="java" {{ old('player_type') == 'java' ? 'selected' : '' }}>Java Edition</option>
        <option value="bedrock" {{ old('player_type') == 'bedrock' ? 'selected' : '' }}>Bedrock Edition</option>
    </select>
</div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password</label>
                                    <input type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Confirm Password</label>
                                    <input type="password" name="password_confirmation"
                                           class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-success w-100 py-2">
                                    Create Account
                                </button>
                            </form>
                        </div>

                         {{--   FORGOT PASSWORD --}}
                        <div class="tab-pane fade" id="forgotTab">
                            <h3 class="fw-bold mb-1">Forgot Password</h3>
                            <p class="text-muted mb-4">Receive reset link on email</p>

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <button type="submit" class="btn btn-warning w-100 py-2">
                                    Send Reset Link
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
