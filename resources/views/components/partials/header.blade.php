@props([
    'sticky' => true,
    'transparent' => false,
])

@php
    $cartItemCount = 0;
    if (auth()->check()) {
        // Panggil metode baru yang sudah menggunakan cache
        $cartItemCount = auth()->user()->cart?->getCachedItemsCount() ?? 0;
    }
@endphp

<header
    class="relative {{ $sticky ? 'sticky top-0 z-40' : '' }} {{ $transparent ? 'bg-transparent' : 'bg-white' }} shadow-sm border-b border-neutral-200 transition-all duration-300"
    x-data="{
        mobileMenuOpen: false,
        searchOpen: false,
        scrolled: false,
    }" x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 10; })"
    :class="{ 'backdrop-blur-md bg-white/90': scrolled && {{ $transparent ? 'true' : 'false' }} }">

    {{-- * Top Bar (Optional promotional bar) --}}
    <div class="bg-primary-500 text-white text-sm py-2 text-center" x-data="{ show: true }" x-show="show">
        <div class="container mx-auto flex items-center justify-between px-4">
            <div class="flex-1 text-center">
                <i class="fas fa-shipping-fast mr-2"></i>
                Free shipping untuk pembelian di atas Rp 500.000
            </div>
            <button @click="show = false" class="text-white hover:text-neutral-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

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
                        <h1 class="text-xl font-display font-bold text-neutral-900">CatShop</h1>
                        <p class="text-xs text-neutral-500 -mt-1">Pet Store</p>
                    </div>
                </a>
            </div>

            {{-- * Desktop Navigation --}}
            <nav class="hidden lg:flex items-center space-x-8">
                <a href="{{ route('landing') }}"
                    class="nav-link {{ request()->routeIs('landing') ? 'nav-link-active' : '' }} ">
                    <i class="fas fa-home mr-1"></i>
                    Home
                </a>
                <a href="{{ route('cats.index') }}"
                    class="nav-link {{ request()->routeIs('cats.index') ? 'nav-link-active' : '' }} ">
                    <i class="fas fa-cat mr-1"></i>
                    Cats
                </a>
                <a href="{{ route('about') }}"
                    class="nav-link {{ request()->routeIs('about') ? 'nav-link-active' : '' }}">
                    <i class="fas fa-info-circle mr-1"></i>
                    About
                </a>
                <a href="{{ route('contact') }}"
                    class="nav-link {{ request()->routeIs('contact') ? 'nav-link-active' : '' }}">
                    <i class="fas fa-envelope mr-1"></i>
                    Contact
                </a>
            </nav>

            {{-- * Search Bar (Desktop) --}}
            <div class="hidden lg:flex items-center flex-1 max-w-md mx-8">
                <div class="relative w-full">
                    <form action="{{ route('cats.index') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari kucing impianmu..."
                            class="form-input pl-10 pr-4 w-full rounded-full border-neutral-300 focus:border-primary-500">
                        <button type="submit"
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-400 hover:text-primary-500">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- * Right Side Actions --}}
            <div class="flex items-center space-x-4">
                {{-- * Search Button (Mobile) --}}
                <button @click="searchOpen = !searchOpen"
                    class="lg:hidden text-neutral-600 hover:text-primary-600 transition-colors">
                    <i class="fas fa-search text-lg"></i>
                </button>

                @auth
                    {{-- * Cart --}}
                    <a href="{{ route('cart.index') }}"
                        class="relative text-neutral-600 hover:text-primary-600 transition-colors">
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
                        <button @click="userMenuOpen = !userMenuOpen"
                            class="flex items-center text-neutral-600 hover:text-primary-600 transition-colors cursor-pointer">
                            <img src="{{ auth()->user()->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                alt="Avatar" class="w-8 h-8 rounded-full object-cover border-2 border-neutral-200">
                        </button>

                        {{-- * User Dropdown --}}
                        <div x-show="userMenuOpen" @click.away="userMenuOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-neutral-200 z-50">
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
                                        @method('POST')

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
                    <x-ui.button :href="route('login')" variant="primary" size="sm">
                        Login
                    </x-ui.button>
                @endauth

                {{-- * Mobile Menu Button --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden text-neutral-600 hover:text-primary-600 transition-colors">
                    <i class="fas fa-bars text-lg" x-show="!mobileMenuOpen"></i>
                    <i class="fas fa-times text-lg" x-show="mobileMenuOpen" style="display: none;"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- * Mobile Search Bar --}}
    <div x-show="searchOpen" @click.away="searchOpen = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="lg:hidden border-t border-neutral-200 bg-white px-4 py-3">
        <form action="{{ route('cats.index') }}" method="GET" class="relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kucing..."
                class="form-input pl-10 pr-4 w-full rounded-full">
            <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-400">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    {{-- * Mobile Menu --}}
    <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" x-transition
        class="lg:hidden border-t border-neutral-200 bg-white">
        <div class="px-4 py-3 space-y-2">
            <a href="{{ route('landing') }}"
                class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors">
                <i class="fas fa-home fa-fw mr-2"></i>Home
            </a>
            <a href="{{ route('cats.index') }}"
                class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors">
                <i class="fas fa-cat fa-fw mr-2"></i>Cats
            </a>
            <a href="{{ route('about') }}"
                class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors">
                <i class="fas fa-info-circle fa-fw mr-2"></i>About
            </a>
            <a href="{{ route('contact') }}"
                class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors">
                <i class="fas fa-envelope fa-fw mr-2"></i>Contact
            </a>
        </div>
    </div>
</header>
