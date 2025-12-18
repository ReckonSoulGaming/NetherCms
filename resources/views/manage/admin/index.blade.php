{{-- resources/views/layouts/admin.blade.php --}}
@php
    $settings = \App\GeneralSettings::first();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - {{ $settings->website_name }}</title>

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

        .sidebar-link {
            display: block; padding: .9rem 1.5rem; color: rgba(255,255,255,.85);
            text-decoration: none; transition: all .25s; font-weight: 500;
            position: relative; border-radius: 8px; margin: 0 0.75rem;
        }
        .sidebar-link:hover { background: rgba(255,255,255,.15); color: white; }
        .sidebar-link.active {
            background: white !important; color: #4e73df !important; font-weight: 700;
        }

        .sidebar-section {
            font-size: .75rem; font-weight: 700; letter-spacing: .05em;
            padding: 1.25rem 1.5rem .35rem; color: rgba(255,255,255,.5);
            text-transform: uppercase;
        }

        /* BEAUTIFUL SUBMENU */
        .submenu-header {
            padding: .9rem 1.5rem; cursor: pointer; font-weight: 600;
            display: flex; justify-content: space-between; align-items: center;
            border-radius: 8px; margin: 0 0.75rem;
        }
        .submenu-header:hover { background: rgba(255,255,255,.15); }
        .submenu-header .fas { transition: transform .2s; }
        .submenu-header.collapsed .fas { transform: rotate(-90deg); }

        .submenu {
            background: rgba(255,255,255,.08);
            margin: 0 0.75rem 1rem; border-radius: 8px; overflow: hidden;
        }
        .submenu .sidebar-link {
            padding-left: 3rem; color: rgba(255,255,255,.9);
            margin: 0;
        }
        .submenu .sidebar-link:hover { background: rgba(255,255,255,.15); }
        .submenu .sidebar-link.active {
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
            background: rgba(0,0,0,.6); z-index: 1039;
        }
        .sidebar-overlay.active { display: block; }

        .content-card {
            border-left: 5px solid #4e73df;
            border-radius: 12px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,.1);
        }
    </style>
</head>
<body>
<div id="wrapper" class="d-flex">

    {{-- SIDEBAR --}}
    <div id="sidebar-wrapper">
    <div class="sidebar-heading">{{ $settings->website_name }}</div>

    {{-- HOME --}}
    <a href="/" class="sidebar-link">
        <i class="fas fa-globe me-2"></i> View Website
    </a>

    <a href="{{ route('dashboard.index') }}" 
       class="sidebar-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
        <i class="fas fa-chart-line me-2"></i> Dashboard
    </a>

    {{-- STORE --}}
    <div class="sidebar-section">STORE</div>
    <div class="submenu-header collapsed" data-bs-toggle="collapse" data-bs-target="#storeMenu">
        <span><i class="fas fa-store me-2"></i>Store</span>
        <i class="fas fa-chevron-down small"></i>
    </div>
   <div class="collapse submenu {{ request()->routeIs('package.*') || request()->routeIs('category.*') ? 'show' : '' }}" id="storeMenu">
    <a href="{{ route('package.index') }}" 
       class="sidebar-link {{ request()->routeIs('package.*') ? 'active' : '' }}">
       Packages
    </a>

    <a href="{{ route('category.index') }}" 
       class="sidebar-link {{ request()->routeIs('category.*') ? 'active' : '' }}">
       Categories
    </a>
</div>


    {{-- FORUM MANAGEMENT --}}
    <div class="sidebar-section">FORUM</div>
    <div class="submenu-header collapsed" data-bs-toggle="collapse" data-bs-target="#forumMenu">
        <span><i class="fas fa-comments me-2"></i>Forum</span>
        <i class="fas fa-chevron-down small"></i>
    </div>
    <div class="collapse submenu {{ request()->routeIs('forumcontrol.*') || request()->routeIs('admin.topic.*') ? 'show' : '' }}" id="forumMenu">
        <a href="{{ route('forumcontrol.index') }}" class="sidebar-link {{ request()->routeIs('forumcontrol.*') ? 'active' : '' }}">Forum Categories</a>
        <a href="{{ route('admin.topic.index') }}" class="sidebar-link {{ request()->routeIs('admin.topic.*') ? 'active' : '' }}">Forum Topics</a>
    </div>

    {{-- SYSTEM --}}
    <div class="sidebar-section">SYSTEM</div>
    <div class="submenu-header collapsed" data-bs-toggle="collapse" data-bs-target="#systemMenu">
        <span><i class="fas fa-cogs me-2"></i>System</span>
        <i class="fas fa-chevron-down small"></i>
    </div>
    <div class="collapse submenu {{ request()->routeIs('usereditor.*') || request()->routeIs('alert.*') || request()->routeIs('serverconsole') || request()->routeIs('trash.*') ? 'show' : '' }}" id="systemMenu">
        <a href="{{ route('usereditor.index') }}" class="sidebar-link {{ request()->routeIs('usereditor.*') ? 'active' : '' }}">User Manager</a>
        <a href="{{ route('alert.index') }}" class="sidebar-link {{ request()->routeIs('alert.*') ? 'active' : '' }}">Announcements</a>
        <a href="{{ route('serverconsole') }}" class="sidebar-link {{ request()->routeIs('serverconsole') ? 'active' : '' }}">Server Console</a>
        <a href="{{ route('trash.index') }}" class="sidebar-link {{ request()->routeIs('trash.*') ? 'active' : '' }}">Trash</a>
    </div>

    {{-- SETTINGS --}}
    <div class="sidebar-section">SETTINGS</div>
    <div class="submenu-header collapsed" data-bs-toggle="collapse" data-bs-target="#settingsMenu">
        <span><i class="fas fa-sliders-h me-2"></i>Settings</span>
        <i class="fas fa-chevron-down small"></i>
    </div>
    <div class="collapse submenu {{ request()->routeIs('settings.*') || request()->routeIs('server.*') || request()->routeIs('paymentmethod.*') || request()->routeIs('admin.payment.*') ? 'show' : '' }}" id="settingsMenu">
        <a href="{{ route('settings.index') }}" class="sidebar-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">General</a>
        <a href="{{ route('server.index') }}" class="sidebar-link {{ request()->routeIs('server.*') ? 'active' : '' }}">Server Settings</a>
        <a href="{{ route('paymentmethod.index') }}" class="sidebar-link {{ request()->routeIs('paymentmethod.*') ? 'active' : '' }}">Payment Method</a>
        <a href="{{ route('admin.payment.history') }}" class="sidebar-link {{ request()->routeIs('admin.payment.*') ? 'active' : '' }}">Payment History</a>
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


    {{-- Overlay --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Main Content --}}
    <div id="content-wrapper" class="flex-grow-1">
        {{-- Topbar --}}
        <nav class="topbar d-flex align-items-center justify-content-between px-4">
            <button class="btn btn-link text-dark d-md-none" id="sidebarToggle">
                Menu
            </button>

            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">{{ config('app.name') }}</a></li>
                <li class="breadcrumb-item active">Admin Panel</li>
            </ol>
	<form action="{{ route('currency.switch') }}" method="POST">
    @csrf
    <select name="currency" onchange="this.form.submit()" class="form-select form-select-sm">
        <option value="INR" {{ session('currency') == 'INR' ? 'selected' : '' }}>₹ INR</option>
        <option value="USD" {{ session('currency') == 'USD' ? 'selected' : '' }}>$ USD</option>
        <option value="EUR" {{ session('currency') == 'EUR' ? 'selected' : '' }}>€ EUR</option>
    </select>
</form>
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
                    <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Profile</a></li>
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
            <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>

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