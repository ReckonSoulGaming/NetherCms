

@extends('layouts.app')

@section('title', 'HomePage')  

@section('content')

{{-- Hero Section --}}
<div class="hero-section text-white text-center position-relative">
    <div class="container position-relative">
        <h1 class="display-3 fw-bold text-uppercase mb-3">{{ $settings->website_name }}</h1>
        <h5 class="fw-light fs-3 opacity-90 mb-5">{{ $settings->homepage_highlight }}</h5>

        <a href="#store" class="btn text-white fw-bold px-5 py-3 rounded-pill shadow-lg"
           style="background: var(--primary); font-size: 1.15rem;">
            Start Shopping
        </a>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="container my-5">
    <div class="row g-5">
        {{-- LEFT COLUMN --}}
        <div class="col-lg-8">

            {{-- ANNOUNCEMENTS --}}
            <div class="glass p-5 mb-5">
                <div class="d-flex align-items-center mb-4">
                    <i class="fas fa-bullhorn fa-3x me-4" style="color: var(--primary);"></i>
                    <div>
                        <h3 class="mb-0 text-white">Latest Announcements</h3>
                        <p class="text-muted">Stay updated</p>
                    </div>
                </div>

                @forelse(collect($alerts ?? [])->take(5) as $alert)
                    <div class="bg-dark bg-opacity-50 rounded-3 p-4 mb-3 border-start border-5"
                         style="border-color: var(--primary)!important;">
                        <span class="tag-glow small">{{ $alert->alert_tag ?? 'UPDATE' }}</span>
                        <h5 class="text-white mt-2">{!! $alert->alert_title !!}</h5>
                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($alert->created_at)->diffForHumans() }}
                        </small>
                    </div>
                @empty
                    <p class="text-center py-5 text-muted">No announcements yet.</p>
                @endforelse
            </div>

            {{-- ABOUT SECTION --}}
            <div class="glass p-5">
                <div class="d-flex align-items-center mb-4">
                    <i class="fas fa-info-circle fa-3x me-4" style="color: #00d4ff;"></i>
                    <h3 class="mb-0">About {{ $settings->website_name }}</h3>
                </div>
                <p class="fs-5 lh-lg text-light">
                    {!! nl2br(e($settings->website_desc ?? 'No description set yet.')) !!}
                </p>
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-4">
           

            {{-- DISCORD WIDGET --}}
            <div class="glass p-4 mt-5">
                <div class="d-flex align-items-center mb-4">
                    <i class="fab fa-discord fa-3x me-3" style="color:#5865F2;"></i>
                    <div>
                        <h4 class="mb-0">Join Discord</h4>
                        <p class="text-muted small">Live Support & Community</p>
                    </div>
                </div>
                <div class="discord-frame ratio ratio-1x1 ratio-lg-4x3">
                    <iframe src="https://discord.com/widget?id=14cc&theme=dark"
                            width="100%" height="500" allowtransparency="true" frameborder="0"
                            sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
                </div>
            </div>

            {{-- QUICK ACCESS --}}
            <div class="glass p-4 mt-5 text-center">
                <h4 class="mb-4">Quick Access</h4>
                <div class="d-grid gap-3">
                    <a href="/store" class="btn btn-lg text-white" style="background: var(--primary);">
                        Web Store
                    </a>
                    <a href="{{ $settings->vote_url ?? '#' }}" class="btn btn-lg btn-outline-light">
                        Vote & Get Rewards</a>

                    <div class="bg-dark bg-opacity-50 rounded-4 p-4 mt-3">
                        <h5 class="mb-2">Server IP</h5>
                        <code class="fs-4 text-primary">
                            {{ $settings->hostname ?? 'play.example.net' }}
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection