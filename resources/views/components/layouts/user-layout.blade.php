@props([
    'title' => '',
    'description' => '',
    'keywords' => '',
    'ogImage' => '',
    'showHeader' => true,
    'showFooter' => false,
    'containerClass' => '',
])

<x-app-layout :title="$title" :description="$description" :keywords="$keywords" :og-image="$ogImage">
    {{-- * Header --}}
    @if ($showHeader)
        <x-partials.header />
    @endif

    {{-- * Main Content Area --}}
    <main class="flex-1 {{ $containerClass }}">
        {{-- * Breadcrumb Section (jika diperlukan) --}}
        {{-- @if (isset($breadcrumbs) && $breadcrumbs)
            <div class="container-custom py-4">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        {{ $breadcrumbs }}
                    </ol>
                </nav>
            </div>
        @endif --}}

        {{-- * Page Content --}}
        <div class="min-h-screen">
            {{ $slot }}
        </div>
    </main>

    {{-- * Footer --}}
    @if ($showFooter)
        <x-partials.footer />
    @endif

    {{-- * Back to Top Button --}}
    {{-- <button id="back-to-top"
        class="fixed bottom-8 right-8 z-40 hidden p-3 rounded-full bg-primary-500 text-white shadow-lg hover:bg-primary-600 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" aria-label="Back to top">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button> --}}

    {{-- @push('scripts')
        <script>
            // Back to top button functionality
            window.addEventListener('scroll', function() {
                const backToTopBtn = document.getElementById('back-to-top');
                if (window.pageYOffset > 300) {
                    backToTopBtn.classList.remove('hidden');
                } else {
                    backToTopBtn.classList.add('hidden');
                }
            });

            // Smooth scroll enhancement
            document.documentElement.style.scrollBehavior = 'smooth';
        </script>
    @endpush --}}
</x-app-layout>
