@php
    $settings = \App\GeneralSettings::first();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Dynamic Page Title - This is the magic line you needed! --}}
    <title>
        {{ $settings->website_name }}
        @hasSection('title')
            - @yield('title')
        @else
            {{ $settings->site_tagline ? ' - ' . $settings->site_tagline : '' }}
        @endif
    </title>

    <!-- Favicon -->
{{-- FAVICON - Fixed & Multiple Formats (just in case) --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap 5 + Icons + Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Global Theme CSS -->
   <style>
        :root {
            --primary: {{ $settings->primary_color ?? '#6C5CE7' }};
            --bg-dark: {{ $settings->background_color ?? '#0a0a1f' }};
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-dark);
            color: #e0e0ff;
            min-height: 100vh;
            background-image: url('{{ $settings->background_image ?? asset('uploads/backend/background/home_bg.png') }}');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }

        /*  HERO */
        .hero {
            min-height: 80vh;
            display: flex;
            align-items: center;
            background: transparent;
        }

        .hero h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(3rem, 10vw, 7rem);
            font-weight: 900;
            color: #ffffff;
            text-shadow: 0 0 60px rgba(108,92,231,0.7);
        }

        .server-name {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(3rem, 9vw, 7rem);
            font-weight: 900;
            background: linear-gradient(45deg, var(--primary), #00d4ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 60px rgba(108,92,231,0.6);
        }

        .btn-store {
            background: linear-gradient(45deg, var(--primary), #00d4ff);
            border: none;
            padding: 18px 50px;
            font-size: 1.4rem;
            font-weight: 700;
            border-radius: 60px;
            color: white;
            box-shadow: 0 15px 40px rgba(108,92,231,0.5);
            transition: 0.4s;
        }

        .btn-store:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 25px 60px rgba(108,92,231,0.7);
        }
		
        /*  GLASS CARDS */
        .glass {
            background: rgba(20, 25, 55, 0.7);
            border-radius: 20px;
            border: 1px solid rgba(108,92,231,0.3);
            backdrop-filter: blur(16px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.4);
            transition: 0.4s;
        }

        .glass:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: 0 30px 70px rgba(108,92,231,0.3);
        }

        .tag-glow {
            background: linear-gradient(45deg, #ff4757, #ff6b6b);
            padding: 6px 16px;
            border-radius: 50px;
            font-weight: bold;
            box-shadow: 0 0 20px rgba(255,71,87,0.6);
        }

        .discord-frame {
            border: 2px solid var(--primary);
            border-radius: 20px;
            overflow: hidden;
        }

        /*  ADMIN CUSTOM CSS */
        {!! $settings->custom_css ?? '' !!}
    </style>
<style>
        :root {
            --primary: {{ $settings->primary_color ?? '#6C5CE7' }};
            --dark: #0a0a1f;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--dark);
            color: #e0e0ff;
            min-height: 100vh;
            background-image: url('{{ $settings->background_image ?? "/uploads/backend/background/store_bg.png" }}');
            background-size: cover;
            background-attachment: fixed;
        }

        /*  HERO (NO GRADIENT) */
        .hero {
            min-height: 80vh;
            display: flex;
            align-items: center;
            background: transparent; 
	
        }

        .hero h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(3rem, 10vw, 7rem);
            font-weight: 900;
            color: #ffffff;
            text-shadow: 0 0 60px rgba(108,92,231,0.7);
        }

        /* Category Sidebar */
        .category-sidebar {
            background: rgba(20,25,55,0.9);
            border-radius: 20px;
            padding: 1.5rem;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(108,92,231,0.3);
            position: sticky;
            top: 100px;
        }

        .category-package {
            padding: 14px 20px;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.35s ease;
            font-weight: 600;
            margin-bottom: 10px;
            background: rgba(50,55,80,0.6);
            border-left: 4px solid transparent;
        }

        .category-package:hover {
            background: rgba(108,92,231,0.4);
            transform: translateX(10px);
            border-left-color: var(--primary);
        }

        .category-package.active {
            background: var(--primary);
            color: white !important;
            font-weight: 700;
            box-shadow: 0 0 30px rgba(108,92,231,0.6);
            border-left-color: #00d4ff;
        }

        /* Cyber Cards */
        .cyber-card {
            position: relative;
            height: 100%;
            background: rgba(0,0,0,0.35);
            border-radius: 16px;
            overflow: hidden;
            backdrop-filter: blur(8px);
            box-shadow: 0 0 25px rgba(255,215,0,0.08);
            transition: all 0.5s ease;
        }

        .cyber-card:hover {
            transform: translateY(-20px) scale(1.05);
            box-shadow: 0 30px 80px rgba(0,255,255,0.4);
        }

        .cyber-glow {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 0.7s;
            background: radial-gradient(circle at 50% 30%, #00ffff, #ff00ff, transparent 70%);
            filter: blur(40px);
            z-index: -1;
        }

        .cyber-card:hover .cyber-glow {
            opacity: 1;
        }

        @media (max-width: 992px) {
            .category-sidebar {
                position: static;
                margin-bottom: 2rem;
            }
            .category-package {
                text-align: center;
            }
        }

        {!! $settings->custom_css ?? '' !!}
    </style>
	
    @stack('styles')
</head>
<body>
    <div id="app">
        @include('elements.navbar')

        <main class="container-fluid mt-5 pt-4">
            @yield('content')
        </main>

        @include('elements.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>