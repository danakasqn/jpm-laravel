<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap + Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #8ECAE6;
            font-family: 'Figtree', sans-serif;
        }

        .sidebar {
            background-color: #2E2E2E;
            width: 210px;
        }

        .sidebar .nav-link {
            color: #E0F1F8;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .sidebar .nav-link:hover {
            background-color: rgb(160, 75, 18);
            color: #fff;
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background-color: #FB8500;
            color: white !important;
            font-weight: bold;
        }

        .topbar {
            background-color: rgb(228, 87, 0);
            color: #023047;
            height: 60px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .topbar h5 {
            font-weight: 600;
            margin: 0;
        }

        .logo-img {
            height: 32px;
            max-width: 100%;
            object-fit: contain;
        }

        main {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="d-flex flex-column min-vh-100">
        <!-- Topbar -->
        <div class="topbar d-flex align-items-center justify-content-between px-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
            <h5 class="text-center flex-grow-1">Property Manager</h5>
            <div style="width: 32px;"></div> {{-- pusty div dla równowagi --}}
        </div>

        <!-- Layout -->
        <div class="d-flex flex-grow-1">
            <!-- Sidebar -->
            <aside class="sidebar d-flex flex-column p-3">
                @include('layouts.navigation')
            </aside>

            <!-- Main Content -->
            <main class="flex-grow-1 p-4">
                @hasSection('content')
                    @yield('content')
                @else
                    {{ $slot ?? '' }}
                @endif
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Tooltip Init -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            tooltipTriggerList.forEach(function (el) {
                new bootstrap.Tooltip(el);
            });
        });
    </script>
</body>
</html>
