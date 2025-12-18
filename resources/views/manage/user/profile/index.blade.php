@extends('manage.user.index')

@section('title', 'My Profile')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 fw-bold">My Profile</h1>
        <p class="text-muted small">Your public profile and account details</p>
    </div>
</div>

<div class="row g-5">

    {{-- Avatar + Status Card --}}
    <div class="col-lg-4">
        <div class="card shadow border-0 text-center h-100">
            <div class="card-body p-5">
                <img src="{{ Auth::user()->profile_image_path
                    ? asset('uploads/avatar/' . Auth::user()->profile_image_path)
                    : asset('uploads/avatar/undraw_profile.png') }}"
                     class="rounded-circle shadow-lg mb-4 border border-5 border-white"
                     style="width: 180px; height: 180px; object-fit: cover;"
                     alt="Profile Picture">

                <h4 class="fw-bold text-gray-800 mb-1">{{ Auth::user()->name }}</h4>
                <p class="text-muted mb-4">{{ Auth::user()->email }}</p>

                <div class="mt-4">
                    @if(Auth::user()->isLogged == 1)
                        <span class="badge bg-success fs-6 px-4 py-2 fw-bold">
                            Online In-Game
                        </span>
                    @else
                        <span class="badge bg-secondary fs-6 px-4 py-2 fw-bold">
                            Offline
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Account Information Card --}}
    <div class="col-lg-8">
        <div class="card shadow border-0 h-100">
            <div class="card-header py-4 text-white text-center fw-bold"
                 style="background: linear-gradient(90deg, #4e73df, #224abe);">
                <h5 class="mb-0">Account Information</h5>
            </div>

            <div class="card-body p-5">
                <table class="table table-borderless align-middle mb-5">
                    <tbody>
                        <tr>
                            <th width="35%" class="text-gray-700 fw-600">Username</th>
                            <td class="fw-bold">{{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <th>Registered Email</th>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <th>Join Date</th>
                            <td>{{ Auth::user()->created_at?->format('d M Y, H:i') ?? 'Unknown' }}</td>
                        </tr>
                      
                        <tr>
                            <th>Client IP Address</th>
                            <td class="text-muted">{{ Auth::user()->ip ?? 'Not recorded' }}</td>
                        </tr>
                        <tr>
                            <th>Account Status</th>
                            <td>
                                @if(Auth::user()->isLogged == 1)
                                    <span class="text-success fw-bold">Currently In-Game</span>
                                @else
                                    <span class="text-muted">Offline</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                <hr class="border-light opacity-25">

                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start mt-4">
                    <a href="{{ route('user.profile.changepassword') }}"
                       class="btn btn-outline-info btn-lg px-5 fw-bold">
                        Change Password 

                    </a>
                    <a href="{{ route('user.profile.editprofile') }}"
                       class="btn btn-primary btn-lg px-5 fw-bold shadow-sm">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Optional hover glow for cards --}}
<style>
    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 1.5rem 3rem rgba(0,0,0,.175) !important;
        transition: all 0.4s ease;
    }
</style>

@endsection