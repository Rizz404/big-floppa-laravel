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
    <title>{{ $title }} | {{ config('app.name') }}</title>

    {{-- * Preconnect untuk optimasi font loading --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- * Font loading sesuai dengan CSS theme --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    {{-- * Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    {{-- * Alpine.js untuk interaktivitas --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen text-rendering-optimized bg-white text-neutral-600 overflow-y-scroll">
    {{-- * Main content wrapper --}}
    <div id="main-content" class="flex flex-col min-h-screen">
        {{ $slot }}
    </div>

    {{-- * Scripts --}}
    @stack('scripts')

    {{-- * TinyMCE --}}
    <script src="https://cdn.tiny.cloud/1/k6ku73yji6yg6uj9uf34s52ziusmyequhc5pb92bv8pbow9n/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    @include('sweetalert::alert')
</body>

</html>
