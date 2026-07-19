<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? '-- |' }}{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;family=Noto+Serif:ital,wght@0,400;0,700;1,400&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .arabic-font {
            font-family: 'Noto Serif', serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .pattern-bg {
            background-image: radial-gradient(circle at 2px 2px, rgba(0, 0, 0, 0.03) 1px, transparent 0);
            background-size: 24px 24px;
        }

        /* Modal styles */
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            transition: opacity 0.3s ease;
        }

        .modal-container {
            transition: all 0.3s ease;
            transform: scale(0.95);
            opacity: 0;
        }

        .modal-container.active {
            transform: scale(1);
            opacity: 1;
        }

        .countdown-timer {
            font-feature-settings: 'tnum';
            font-vari ant-numeric: tabular-nums;
        }

        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .arabic-font {
            font-family: 'Noto Serif', serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .pattern-bg {
            background-image: radial-gradient(circle at 2px 2px, rgba(0, 0, 0, 0.03) 1px, transparent 0);
            background-size: 24px 24px;
        }

        /* Animation for loading */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin-custom {
            animation: spin 1s linear infinite;
        }

        /* Smooth transitions */
        .transition-smooth {
            transition: all 0.3s ease-in-out;
        }

        /* Hover effects */
        .table-row-hover:hover {
            background-color: rgba(16, 185, 129, 0.05);
            transition: all 0.2s ease;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 h-screen flex overflow-hidden">
    @if (Auth::user()->role === 'admin')
        @include('partials.sidebar_admin')
    @elseif(Auth::user()->role === 'editor' || Auth::user()->role === 'teologi' || Auth::user()->role === 'linguistik')
        @include('partials.sidebar')
    @endif

    <div class="flex-1 min-w-0 h-screen overflow-y-auto bg-gray-50">
        @yield('content')
    </div>
</body>

</html>
