<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $description }}">
    <meta name="keywords" content="{{ $keywords }}">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="robots" content="index, follow">

    {{-- Open Graph / Facebook --}}
    {{-- <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title }} | {{ config('app.name') }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $ogImage }}"> --}}

    {{-- Twitter --}}
    {{-- <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $title }} | {{ config('app.name') }}">
    <meta property="twitter:description" content="{{ $description }}">
    <meta property="twitter:image" content="{{ $ogImage }}"> --}}

    <title>{{ $title }} | {{ config('app.name') }}</title>

    {{-- Preconnect untuk optimasi font loading --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Font loading sesuai dengan CSS theme --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    {{-- <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}"> --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    {{-- Alpine.js untuk interaktivitas --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen text-rendering-optimized bg-white text-neutral-600 overflow-y-scroll">
    {{-- Loading indicator --}}
    {{-- <div id="page-loader" class="fixed inset-0 z-50 flex items-center justify-center bg-white" x-data="{ loading: true }"
        x-show="loading" x-transition.opacity>
        <div class="flex items-center space-x-2">
            <div class="w-6 h-6 border-2 border-primary-500 border-t-transparent rounded-full animate-spin"></div>
            <span class="text-neutral-600">Loading...</span>
        </div>
    </div> --}}

    {{-- Skip to main content untuk accessibility --}}
    {{-- <a href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-primary-500 focus:text-white focus:rounded-md focus:shadow-lg">
        Skip to main content
    </a> --}}

    {{-- Main content wrapper --}}
    <div id="main-content" class="flex flex-col min-h-screen">
        {{ $slot }}
    </div>

    {{-- Scripts --}}
    @stack('scripts')

    {{-- TinyMCE --}}
    <script src="https://cdn.tiny.cloud/1/k6ku73yji6yg6uj9uf34s52ziusmyequhc5pb92bv8pbow9n/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>

    {{-- Page initialization --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hide loading indicator
            setTimeout(() => {
                const loader = document.getElementById('page-loader');
                if (loader) {
                    loader.style.opacity = '0';
                    setTimeout(() => loader.remove(), 300);
                }
            }, 500);

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('[data-alert]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });
    </script> --}}
</body>

</html>
