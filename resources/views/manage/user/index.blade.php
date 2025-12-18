{{-- resources/views/layouts/userpanel.blade.php --}}
@php
    $settings = \App\GeneralSettings::first();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'User Panel') - {{ $settings->website_name }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fc; color: #5a5c69; }
        
        #sidebar-wrapper {
            position: fixed; top: 0; left: 0; width: 250px; height: 100vh;
            background: linear-gradient(180deg, #4e73df 0%, #224abe 100%);
            color: white; z-index: 1040; transition: transform .3s ease;
            overflow-y: auto; box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,.15);
        }
        @media (max-width: 767.98px) {
            #sidebar-wrapper { transform: translateX(-100%); }
            #sidebar-wrapper.active { transform: translateX(0); }
        }

        .sidebar-heading {
            padding: 1.8rem 1rem; font-size: 1.6rem; font-weight: 800;
            text-align: center; background: rgba(0,0,0,0.15);
        }

        .list-group-item {
            background: transparent; border: none; color: rgba(255,255,255,0.85);
            padding: .9rem 1.5rem; transition: all .3s; border-radius: 0;
        }
        .list-group-item:hover { background: rgba(255,255,255,0.15); color: white; }
        .list-group-item.active {
            background: white !important; color: #4e73df !important; font-weight: 700;
        }

        /* BEAUTIFUL SUBMENU - THIS IS THE FIX */
        .submenu-header {
            padding: .9rem 1.5rem; cursor: pointer; font-weight: 600;
            display: flex; justify-content: space-between; align-items: center;
            border-radius: 8px; margin: 0 0.75rem;
        }
        .submenu-header:hover { background: rgba(255,255,255,0.15); }
        .submenu-header .fas { transition: transform .2s; }
        .submenu-header.collapsed .fas { transform: rotate(-90deg); }

        .submenu {
            background: rgba(255,255,255,0.08);
            margin: 0 0.75rem 1rem; border-radius: 8px; overflow: hidden;
        }
        .submenu .list-group-item {
            padding-left: 3rem; color: rgba(255,255,255,0.9);
        }
        .submenu .list-group-item:hover { background: rgba(255,255,255,0.15); }
        .submenu .list-group-item.active {
            background: #fff !important; color: #4e73df !important;
        }

        #content-wrapper { margin-left: 250px; transition: margin-left .3s ease; }
        @media (max-width: 767.98px) { #content-wrapper { margin-left: 0 !important; } }

        .topbar {
            height: 70px; background: #fff; border-bottom: 1px solid #e3e6f0;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,.15);
            position: sticky; top: 0; z-index: 1030;
        }
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.5); z-index: 1039;
        }
        .sidebar-overlay.active { display: block; }

        .card { border: none; border-radius: 12px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,.1); }
        .content-card { border-left: 4px solid #4e73df; }
    </style>
</head>
<body>
<div id="wrapper" class="d-flex">

    {{-- SIDEBAR --}}
   <div id="sidebar-wrapper">
    <div class="sidebar-heading">{{ $settings->website_name }}</div>

    <div class="list-group list-group-flush">

        {{-- CLAIM --}}
        <div class="px-4 mt-4 mb-2 text-uppercase small fw-bold text-white-50">
            <i class="fas fa-gift me-2"></i> Claim
        </div>
        <a href="{{ route('claim.index') }}" 
           class="list-group-item {{ request()->routeIs('claim.*') ? 'active' : '' }}">
            <i class="fas fa-box-open me-2"></i> Package Claim
        </a>

        {{-- PROFILE --}}
        <div class="px-4 mt-4 mb-2 text-uppercase small fw-bold text-white-50">
            <i class="fas fa-user me-2"></i> Profile
        </div>

        <div class="submenu-header collapsed" data-bs-toggle="collapse" data-bs-target="#profileMenu">
            <span><i class="fas fa-id-badge me-2"></i> Profile Settings</span>
            <i class="fas fa-chevron-down small"></i>
        </div>

        <div class="collapse submenu {{ request()->routeIs('profile.*') ? 'show' : '' }}" id="profileMenu">
            <a href="{{ route('profile.index') }}" 
               class="list-group-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <i class="fas fa-user-circle me-2"></i> My Profile
            </a>




           <a href="{{ route('user.profile.changepassword') }}" 
   class="list-group-item {{ request()->routeIs('profile.changepassword') ? 'active' : '' }}">
    <i class="fas fa-key me-2"></i> Change Password
</a>

        </div>

        {{-- HISTORY --}}
        <div class="px-4 mt-4 mb-2 text-uppercase small fw-bold text-white-50">
            <i class="fas fa-history me-2"></i> History
        </div>

        <div class="submenu-header collapsed" data-bs-toggle="collapse" data-bs-target="#historyMenu">
            <span><i class="fas fa-clock me-2"></i> My History</span>
            <i class="fas fa-chevron-down small"></i>
        </div>

        <div class="collapse submenu {{ request()->routeIs('history.*') || request()->routeIs('user.paymenthistory.*') ? 'show' : '' }}" id="historyMenu">

            <a href="{{ route('history.index') }}" 
               class="list-group-item {{ request()->routeIs('history.*') ? 'active' : '' }}">
                <i class="fas fa-list-ul me-2"></i> Account Activity
            </a>

            <a href="{{ route('paymenthistory.index') }}" 
               class="list-group-item {{ request()->routeIs('user.paymenthistory.*') ? 'active' : '' }}">
                <i class="fas fa-receipt me-2"></i> Payment History
            </a>
        </div>

        {{-- FORUM --}}
        <div class="px-4 mt-4 mb-2 text-uppercase small fw-bold text-white-50">
            <i class="fas fa-comments me-2"></i> Forum
        </div>

        <a href="{{ route('topicmanager.index') }}" 
           class="list-group-item {{ request()->routeIs('topicmanager.*') ? 'active' : '' }}">
            <i class="fas fa-comment-dots me-2"></i> My Topics
        </a>

    </div>

    {{-- LOGOUT --}}
    <div class="p-4 border-top border-white border-opacity-10 mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-light w-100 fw-bold">
                Logout
            </button>
        </form>
    </div>
</div>


    {{-- Overlay & Main Content --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div id="content-wrapper" class="flex-grow-1">
        {{-- Topbar --}}
        <nav class="topbar d-flex align-items-center justify-content-between px-4">
            <button class="btn btn-link text-dark d-md-none" id="sidebarToggle">
                Menu
            </button>

            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">{{ config('app.name') }}</a></li>
                <li class="breadcrumb-item active">User Panel</li>
            </ol>

            <div class="dropdown">
                <a class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
<img src="{{ Auth::user()->profile_image_path
                ? asset('uploads/avatar/' . Auth::user()->profile_image_path)
                : asset('uploads/avatar/undraw_profile.png') }}"
             alt="Current Profile Picture"
             class="rounded-circle shadow-lg border border-5 border-white"
             style="width: 46px; height: 46px; object-fit: cover;">
                    {{ Auth::user()->name }} 
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        {{-- Page Content --}}
        <div class="container-fluid py-4">
            <h1 class="h3 mb-4 text-gray-800">@yield('title', 'User Panel')</h1>
            <div class="card content-card shadow">
                <div class="card-body p-4">
                    @yield('content')
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <footer class="bg-white border-top mt-auto py-4 text-center text-muted small">
            © {{ date('Y') }} {{ $settings->website_name }} • All Rights Reserved
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar-wrapper');
    const overlay = document.getElementById('sidebarOverlay');
    const toggle = document.getElementById('sidebarToggle');

    toggle?.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });

    document.querySelectorAll('#sidebar-wrapper a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        });
    });
</script>
</body>
</html>