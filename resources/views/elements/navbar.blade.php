{{-- resources/views/components/navbar.blade.php --}}


<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-lg"
     style="background: {{ $settings->navbar_color ?? '#1a1a2e' }} !important;">
    <div class="container">
         {{--  Brand - Dynamic Website Name --}}
        <a class="navbar-brand fw-bold fs-3 text-uppercase" href="/home">
            {{ $settings->website_name ?? 'LAPIZMC' }}
        </a>

         {{--  Mobile Toggle --}}
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

         {{--  Menu --}}
        <div class="collapse navbar-collapse" id="mainNavbar">
             {{--  Left Links --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-uppercase">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('home') ? 'active' : '' }}"
                       href="/home" style="color: {{ $settings->nav_text_color ?? '#ffffff' }} !important;">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('store*') ? 'active' : '' }}"
                       href="/store" style="color: {{ $settings->nav_text_color ?? '#ffffff' }} !important;">
                        Store
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('forum*') ? 'active' : '' }}"
                       href="/forum" style="color: {{ $settings->nav_text_color ?? '#ffffff' }} !important;">
                        Forum
                    </a>
                </li>
            </ul>

             {{--  Right Side (User Menu) --}}
            <ul class="navbar-nav ms-auto">
			<form action="{{ route('currency.switch') }}" method="POST">
    @csrf
    <select name="currency" onchange="this.form.submit()" class="form-select form-select-sm">
        <option value="INR" {{ session('currency') == 'INR' ? 'selected' : '' }}>₹ INR</option>
        <option value="USD" {{ session('currency') == 'USD' ? 'selected' : '' }}>$ USD</option>
        <option value="EUR" {{ session('currency') == 'EUR' ? 'selected' : '' }}>€ EUR</option>
    </select>
</form>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"
                           style="color: {{ $settings->nav_text_color ?? '#ffffff' }} !important;">
                            Login/Register
                        </a>
                    </li>
                   
                @else
                     {{--  Admin Dropdown --}}
                    @if(Auth::user()->role->role_id == 1)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               style="color: {{ $settings->nav_text_color ?? '#ffffff' }} !important;">
                                Admin Panel
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><h6 class="dropdown-header">Store & Package</h6></li>
                                <li><a class="dropdown-item" href="{{ route('package.index') }}">Store</a></li>
                                <li><a class="dropdown-item" href="{{ route('category.index') }}">Package Category</a></li>
                              
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header">Admin Control</h6></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard.index') }}">Overview</a></li>
                                <li><a class="dropdown-item" href="{{ route('usereditor.index') }}">User Manager</a></li>
                                <li><a class="dropdown-item" href="{{ route('alert.index') }}">Announcements</a></li>
                                <li><a class="dropdown-item" href="{{ route('serverconsole') }}">Server Console</a></li>
                                <li><a class="dropdown-item" href="{{ route('trash.index') }}">Trash</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header">System</h6></li>
                                <li><a class="dropdown-item" href="{{ route('settings.index') }}">General Settings</a></li>
                                <li><a class="dropdown-item" href="{{ route('paymentmethod.index') }}">Payment Setup</a></li>
                                
                            </ul>
                        </li>
                    @endif

                     {{--  User Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           style="color: {{ $settings->nav_text_color ?? '#ffffff' }} !important;">
                            {{ Auth::user()->name }}
                        </a>
						
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><h6 class="dropdown-header">General</h6></li>
                            <li><a class="dropdown-item" href="{{ route('claim.index') }}">Your Packages</a></li>
                            <li><a class="dropdown-item" href="{{ route('history.index') }}">Activity History</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header">Account</h6></li>
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile Settings</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

 {{--  Dynamic Padding + Active Link Hover Effect --}}
<style>
    body { 
        padding-top: 86px; 
    }
    @media (max-width: 991px) {
        body { padding-top: 76px; }
    }

    /*  Primary Color */
    .navbar .nav-link:hover,
    .navbar .nav-link.active {
        color: {{ $settings->primary_color ?? '#4e73df' }} !important;
        font-weight: 700;
    }

    .dropdown-item:hover {
        background: {{ $settings->primary_color ?? '#4e73df' }}22;
        color: {{ $settings->primary_color ?? '#4e73df' }};
    }

    /* Custom CSS from Admin Panel */
    {!! $settings->custom_css ?? '' !!}
</style>