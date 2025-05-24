<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap + Icons + Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #F1F5F9;
            font-family: 'Figtree', sans-serif;
            margin: 0;
        }

        .topbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            height: 60px;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar {
            background-color: #1e293b;
            width: 280px;
            color: white;
            min-height: 100vh;
            transition: left 0.3s ease;
        }

        .sidebar .nav-link {
            color: #94a3b8;
            padding: 9px 16px;
            margin-bottom: 6px;
            border-radius: 6px;
            font-size: 0.94rem;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .sidebar .nav-link:hover {
            background-color: #334155;
            color: #f1f5f9;
        }

        .sidebar .nav-link.active {
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
        }

        .sidebar .bi {
            font-size: 1rem;
            opacity: 0.9;
        }

        .logo-img {
            height: 48px;
        }

        .user-box {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .user-box img {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            object-fit: cover;
            position: relative;
        }

        .user-box .status-dot {
            position: absolute;
            top: 0;
            right: -2px;
            width: 10px;
            height: 10px;
            background-color: #22c55e;
            border: 2px solid #1e293b;
            border-radius: 50%;
        }

        .user-box .info .name {
            font-weight: 600;
            font-size: 0.95rem;
            color: #fff;
        }

        .user-box .info .email {
            font-size: 0.8rem;
            color: #cbd5e1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        main {
            background-color: #f8fafc;
            padding: 30px;
            flex-grow: 1;
        }

        .mobile-toggle {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #333;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -100%;
                top: 0;
                width: 240px;
                height: 100vh;
                background-color: #1e293b;
                z-index: 999;
                display: block;
            }

            .sidebar.active {
                left: 0;
            }

            .topbar {
                justify-content: space-between;
            }

            .mobile-toggle {
                display: inline-block;
            }

            main {
                margin-left: 0 !important;
                padding: 1rem;
            }
        }

        .dot {
            height: 8px;
            width: 8px;
            background-color: red;
            border-radius: 50%;
            display: inline-block;
            margin-left: 6px;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <aside class="sidebar d-flex flex-column p-3" id="sidebar">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img mx-auto d-block">
            <div class="text-light fw-semibold mt-2 small">Property Manager</div>
        </div>

        <div class="user-box">
            <div class="position-relative">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=0D8ABC&color=fff" alt="Avatar">
                <span class="status-dot"></span>
            </div>
            <div class="info">
                <div class="name">{{ Auth::user()->name ?? 'Zalogowany' }}</div>
                <div class="email">{{ Auth::user()->email ?? '' }}</div>
            </div>
        </div>

        @include('layouts.navigation')
    </aside>

    <!-- Page Content -->
    <div class="flex-grow-1 d-flex flex-column">
        <!-- Topbar -->
        <div class="topbar">
            <span id="mobile-toggle-btn" class="mobile-toggle d-md-none"><i class="bi bi-list"></i></span>
            <h5 class="mb-0">Panel Główny</h5>
            <div class="dropdown">
                <button class="btn btn-sm bg-white border-0 p-0" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle fs-4 text-muted"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userMenu">
                    <li class="px-3 py-2 text-muted small">{{ Auth::user()->name ?? 'Użytkownik' }}</li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">
                                <i class="bi bi-box-arrow-right me-2"></i>Wyloguj
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <main>
            @hasSection('content')
                @yield('content')
            @else
                {{ $slot ?? '' }}
            @endif
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggle = document.getElementById("mobile-toggle-btn");
        const sidebar = document.getElementById("sidebar");

        if (toggle && sidebar) {
            toggle.addEventListener("click", () => {
                sidebar.classList.toggle("active");
            });
        }
    });
</script>

@stack('scripts') {{-- ✅ TO BYŁO BRAKUJĄCE --}}
</body>
</html>
