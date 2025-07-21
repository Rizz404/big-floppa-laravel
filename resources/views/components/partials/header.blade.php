@props([
    'sticky' => true,
    'transparent' => false,
])

@php
    $cartItemCount = auth()->check() ? auth()->user()->cart?->getCachedItemsCount() ?? 0 : 0;
@endphp

<header
    class="relative {{ $sticky ? 'sticky top-0 z-40' : '' }} {{ $transparent ? 'bg-transparent' : 'bg-white' }} shadow-sm border-b border-neutral-200 transition-all duration-300"
    x-data="{
        mobileMenuOpen: false,
        searchModalOpen: false,
        scrolled: false,
    }" x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 10; })" @keydown.escape.window="searchModalOpen = false"
    :class="{ 'backdrop-blur-md bg-white/90': scrolled && {{ $transparent ? 'true' : 'false' }} }">

    {{-- * Top Bar (Optional promotional bar) --}}
    {{-- <div class="bg-primary-500 text-white text-sm py-2 text-center" x-data="{ show: true }" x-show="show">
        <div class="container-wide flex items-center justify-between">
            <div class="flex-1 text-center">
                <i class="fas fa-shipping-fast mr-2"></i>
                Free shipping untuk pembelian di atas Rp 500.000
            </div>
            <button @click="show = false" class="text-white hover:text-neutral-200 px-2"
                aria-label="Dismiss promotional bar">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div> --}}

    {{-- * Main Header --}}
    <div class="container-wide">
        <div class="flex items-center justify-between h-16 lg:h-20">
            {{-- * Logo --}}
            <div class="flex items-center">
                <a href="{{ route('landing') }}" class="flex items-center space-x-2 group">
                    <div
                        class="w-10 h-10 bg-gradient-primary rounded-full flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                        <i class="fas fa-cat text-white text-xl"></i>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-display font-bold text-neutral-900">Big Floppa Store</h1>
                        <p class="text-xs text-neutral-500 -mt-1">Your Pet's Favorite Place</p>
                    </div>
                </a>
            </div>

            {{-- * Desktop Navigation --}}
            <nav class="hidden lg:flex items-center space-x-8">
                <a href="{{ route('landing') }}"
                    class="nav-link {{ request()->routeIs('landing') ? 'nav-link-active' : '' }}">Home</a>
                <a href="{{ route('cats.index') }}"
                    class="nav-link {{ request()->routeIs('cats.index') ? 'nav-link-active' : '' }}">Cats</a>
                <a href="{{ route('breeds.index') }}"
                    class="nav-link {{ request()->routeIs('breeds.index') ? 'nav-link-active' : '' }}">Breeds</a>
                <a href="{{ route('about') }}"
                    class="nav-link {{ request()->routeIs('about') ? 'nav-link-active' : '' }}">About</a>
                <a href="{{ route('contact') }}"
                    class="nav-link {{ request()->routeIs('contact') ? 'nav-link-active' : '' }}">Contact</a>
            </nav>

            {{-- * Right Side Actions --}}
            <div class="flex items-center space-x-4">
                {{-- * Search Button (All devices) --}}
                <button @click="searchModalOpen = true"
                    class="text-neutral-600 hover:text-primary-600 transition-colors" aria-label="Open search">
                    <i class="fas fa-search text-lg"></i>
                </button>

                @auth
                    {{-- * Cart --}}
                    <a href="{{ route('cart.index') }}"
                        class="relative text-neutral-600 hover:text-primary-600 transition-colors"
                        aria-label="View shopping cart">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        @if ($cartItemCount > 0)
                            <span
                                class="absolute -top-2 -right-2 bg-primary-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $cartItemCount }}
                            </span>
                        @endif
                    </a>

                    {{-- * User Menu --}}
                    <div class="relative" x-data="{ userMenuOpen: false }">
                        <button @click="userMenuOpen = !userMenuOpen" class="block" aria-label="Open user menu">
                            <img src="{{ auth()->user()->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random' }}"
                                alt="Avatar"
                                class="w-8 h-8 rounded-full object-cover border-2 border-neutral-200 hover:border-primary-500 transition">
                        </button>

                        {{-- Dropdown --}}
                        <div x-show="userMenuOpen" @click.away="userMenuOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-neutral-200 z-50"
                            style="display: none;">
                            <div class="py-1">
                                <div class="px-4 py-3 border-b border-neutral-200">
                                    <p class="text-sm font-medium text-neutral-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-neutral-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <div class="py-1">
                                    <a href="{{ route('profile.show') }}"
                                        class="block px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-100 hover:text-primary-600">
                                        <i class="fas fa-user fa-fw mr-2"></i>Profile
                                    </a>
                                    <a href="{{ route('orders.index') }}"
                                        class="block px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-100 hover:text-primary-600">
                                        <i class="fas fa-shopping-bag fa-fw mr-2"></i>Orders
                                    </a>
                                </div>
                                <div class="py-1 border-t border-neutral-200">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-danger-600 hover:bg-danger-50 hover:text-danger-700 cursor-pointer">
                                            <i class="fas fa-sign-out-alt fa-fw mr-2"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <x-ui.button :href="route('login.form')" variant="primary" size="sm">
                        Login
                    </x-ui.button>
                @endauth

                {{-- * Mobile Menu Button --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden text-neutral-600 hover:text-primary-600 transition-colors"
                    aria-label="Open main menu">
                    <i class="fas fa-bars text-lg" x-show="!mobileMenuOpen"></i>
                    <i class="fas fa-times text-lg" x-show="mobileMenuOpen" style="display: none;"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- * Mobile Menu --}}
    <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" x-transition
        class="lg:hidden border-t border-neutral-200 bg-white" style="display: none;">
        <div class="px-4 py-3 space-y-2">
            <a href="{{ route('landing') }}"
                class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors"><i
                    class="fas fa-home fa-fw mr-2"></i>Home</a>
            <a href="{{ route('cats.index') }}"
                class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors"><i
                    class="fas fa-cat fa-fw mr-2"></i>Cats</a>
            <a href="{{ route('breeds.index') }}"
                class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors"><i
                    class="fas fa-paw fa-fw mr-2"></i>Breeds</a>
            <a href="{{ route('about') }}"
                class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors"><i
                    class="fas fa-info-circle fa-fw mr-2"></i>About</a>
            <a href="{{ route('contact') }}"
                class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors"><i
                    class="fas fa-envelope fa-fw mr-2"></i>Contact</a>
        </div>
    </div>

    {{-- * Search Modal --}}
    <div x-show="searchModalOpen" class="fixed inset-0 z-50 flex items-start justify-center pt-16 sm:pt-24"
        style="display: none;">
        {{-- Overlay --}}
        <div x-show="searchModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            @click="searchModalOpen = false" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

        {{-- Dialog --}}
        <div x-show="searchModalOpen" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative w-full max-w-lg bg-white rounded-lg shadow-xl p-6 mx-4">
            <h3 class="text-xl font-bold mb-4">Search for Cats</h3>
            <form action="{{ route('cats.index') }}" method="GET">
                <div class="flex gap-2 items-center">
                    <div class="flex-grow">
                        <x-ui.input name="search" :value="request('search')"
                            placeholder="Cari berdasarkan nama, ras, atau deskripsi..." />
                    </div>
                    <x-ui.button type="submit" size="lg">
                        <i class="fas fa-search"></i>
                    </x-ui.button>
                </div>
            </form>
        </div>
    </div>
</header>
