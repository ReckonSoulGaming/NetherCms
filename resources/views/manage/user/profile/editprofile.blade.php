{{-- resources/views/manage/profile/edit.blade.php --}}
@extends('manage.user.index')

@section('title', 'Edit Profile')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 fw-bold">Edit Profile</h1>
        <p class="text-muted small">Update your username and profile picture</p>
    </div>
</div>

<div class="row g-5">
    {{-- Form Card --}}
    <div class="col-lg-8">
        <div class="card shadow border-0 h-100">
            <div class="card-header py-4 text-white text-center fw-bold"
                 style="background: linear-gradient(90deg, #4e73df, #224abe);">
                <h5 class="mb-0">Profile Settings</h5>
            </div>

            <div class="card-body p-5">
                <form method="POST" action="{{ route('user.profile.updateprofile') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Email (Read-only) --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Email Address</label>
                        <input type="email"
       name="email"
       class="form-control form-control-lg bg-white"
       value="{{ $user->email }}"
       readonly>

                    </div>

                    {{-- Username --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text"
                               name="name"
                               class="form-control form-control-lg @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                        @enderror
                    </div>

{{-- Player Type --}}
<div class="mb-4">
    <label class="form-label fw-bold">Player Type</label>
    <select name="player_type"
            class="form-control form-control-lg @error('player_type') is-invalid @enderror"
            required>
        <option value="java" {{ $user->player_type == 'java' ? 'selected' : '' }}>
            Java Edition
        </option>
        <option value="bedrock" {{ $user->player_type == 'bedrock' ? 'selected' : '' }}>
            Bedrock Edition
        </option>
    </select>

    @error('player_type')
        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
    @enderror
</div>



                    {{-- Avatar Upload --}}
                    <div class="mb-5">
                        <label class="form-label fw-bold">Profile Picture</label>
                        <input type="file"
                               name="avatar"
                               id="avatarInput"
                               class="form-control form-control-lg @error('avatar') is-invalid @enderror"
                               accept="image/*">
                        <div class="form-text">Max 2MB • PNG, JPG, JPEG only</div>
                        @error('avatar')
                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex flex-wrap gap-3">
                        <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm fw-bold">
                            Save Changes
                        </button>
                        <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary btn-lg px-5">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Current Avatar Preview --}}
    <div class="col-lg-4">
        <div class="card shadow border-0 text-center h-100">
            <div class="card-header py-4 text-white fw-bold"
                 style="background: linear-gradient(90deg, #4e73df, #224abe);">
                Current Avatar
            </div>
            <div class="card-body p-5">
                <img src="{{ $user->profile_image_path
                    ? asset('uploads/avatar/' . $user->profile_image_path)
                    : asset('uploads/avatar/undraw_profile.png') }}"
                     alt="Current Profile Picture"
                     class="rounded-circle shadow-lg border border-5 border-white mb-4"
                     style="width: 220px; height: 220px; object-fit: cover;">
                <p class="text-muted">This is how others see you</p>
            </div>
        </div>
    </div>
</div>

{{-- Hover effect + styling --}}
<style>
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 1.5rem 3.5rem rgba(0,0,0,.2) !important;
        transition: all 0.4s ease;
    }
    .form-control-lg {
        height: 56px;
        border-radius: 12px;
    }
    .form-text {
        font-size: 0.9rem;
        color: #6c757d;
    }
    @media (max-width: 768px) {
        .row.g-5 > div { margin-bottom: 2rem; }
        img[alt="Current Profile Picture"] {
            width: 180px !important;
            height: 180px !important;
        }
    }
</style>

@endsection