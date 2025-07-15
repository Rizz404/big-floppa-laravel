@props([
    'sticky' => true,
    'transparent' => false,
])

{{-- Todo: Nanti routenya benerin semuanya --}}
<header
    class="relative {{ $sticky ? 'sticky top-0 z-40' : '' }} {{ $transparent ? 'bg-transparent' : 'bg-white' }} shadow-sm border-b border-neutral-200 transition-all duration-300"
    x-data="{
        mobileMenuOpen: false,
        cartOpen: false,
        searchOpen: false,
        scrolled: false,
        cartCount: 0
    }" x-init="window.addEventListener('scroll', () => {
        scrolled = window.pageYOffset > 10;
    });
    // Initialize cart count from session/localStorage if available
    cartCount = parseInt(localStorage.getItem('cart_count') || '0');"
    :class="{ 'backdrop-blur-md bg-white/90': scrolled && {{ $transparent ? 'true' : 'false' }} }">

    {{-- Top Bar (Optional promotional bar) --}}
    <div class="bg-primary-500 text-white text-sm py-2 text-center" x-data="{ show: true }" x-show="show">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex-1 text-center">
                <i class="fas fa-shipping-fast mr-2"></i>
                Free shipping untuk pembelian di atas Rp 500.000
            </div>
            <button @click="show = false" class="text-white hover:text-neutral-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    {{-- Main Header --}}
    <div class="container mx-auto">
        <div class="flex items-center justify-between h-16 lg:h-20">
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="#" class="flex items-center space-x-2 group">
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

            {{-- Desktop Navigation --}}
            <nav class="hidden lg:flex items-center space-x-8">
                <a href="#" class="nav-link nav-link-active">
                    <i class="fas fa-home mr-1"></i>
                    Home
                </a>
                <div class="relative group">
                    <a href="#" class="nav-link flex items-center">
                        <i class="fas fa-box mr-1"></i>
                        Products
                        <i class="fas fa-chevron-down ml-1 text-xs transition-transform group-hover:rotate-180"></i>
                    </a>
                    {{-- Dropdown Menu --}}
                    <div
                        class="absolute top-full left-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-neutral-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <div class="py-2">
                            <a href="#"
                                class="block px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-100 hover:text-primary-600">
                                <i class="fas fa-utensils mr-2"></i>
                                Makanan Kucing
                            </a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-100 hover:text-primary-600">
                                <i class="fas fa-dice mr-2"></i>
                                Mainan
                            </a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-100 hover:text-primary-600">
                                <i class="fas fa-tshirt mr-2"></i>
                                Aksesoris
                            </a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-100 hover:text-primary-600">
                                <i class="fas fa-heartbeat mr-2"></i>
                                Kesehatan
                            </a>
                        </div>
                    </div>
                </div>
                <a href="#" class="nav-link">
                    <i class="fas fa-info-circle mr-1"></i>
                    About
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-envelope mr-1"></i>
                    Contact
                </a>
            </nav>

            {{-- Search Bar (Desktop) --}}
            <div class="hidden lg:flex items-center flex-1 max-w-md mx-8">
                <div class="relative w-full">
                    <form action="#" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari produk kucing..."
                            class="form-input pl-10 pr-4 w-full rounded-full border-neutral-300 focus:border-primary-500">
                        <button type="submit"
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-400 hover:text-primary-500">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Right Side Actions --}}
            <div class="flex items-center space-x-4">
                {{-- Search Button (Mobile) --}}
                <button @click="searchOpen = !searchOpen"
                    class="lg:hidden text-neutral-600 hover:text-primary-600 transition-colors">
                    <i class="fas fa-search text-lg"></i>
                </button>

                {{-- Wishlist --}}
                @auth
                    <a href="#" class="relative text-neutral-600 hover:text-primary-600 transition-colors">
                        <i class="fas fa-heart text-lg"></i>
                        <span
                            class="absolute -top-2 -right-2 bg-danger-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{-- {{ auth()->user()->wishlist()->count() }} --}} 0
                        </span>
                    </a>
                @endauth

                {{-- Cart --}}
                <button @click="cartOpen = !cartOpen"
                    class="relative text-neutral-600 hover:text-primary-600 transition-colors">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span
                        class="absolute -top-2 -right-2 bg-primary-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"
                        x-text="cartCount" x-show="cartCount > 0"></span>
                </button>

                {{-- User Menu --}}
                @auth
                    <div class="relative" x-data="{ userMenuOpen: false }">
                        <button @click="userMenuOpen = !userMenuOpen"
                            class="flex items-center text-neutral-600 hover:text-primary-600 transition-colors">
                            <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                alt="Avatar" class="w-8 h-8 rounded-full object-cover border-2 border-neutral-200">
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>

                        {{-- User Dropdown --}}
                        <div x-show="userMenuOpen" @click.away="userMenuOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-neutral-200 z-50">
                            <div class="py-2">
                                <div class="px-4 py-2 border-b border-neutral-200">
                                    <p class="text-sm font-medium text-neutral-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-neutral-500">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-100 hover:text-primary-600">
                                    <i class="fas fa-user mr-2"></i>
                                    Profile
                                </a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-100 hover:text-primary-600">
                                    <i class="fas fa-shopping-bag mr-2"></i>
                                    Orders
                                </a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-100 hover:text-primary-600">
                                    <i class="fas fa-heart mr-2"></i>
                                    Wishlist
                                </a>
                                <div class="border-t border-neutral-200 mt-2 pt-2">
                                    <form method="POST" action="#">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-danger-600 hover:bg-danger-50">
                                            <i class="fas fa-sign-out-alt mr-2"></i>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="#" class="btn btn-outline btn-sm">
                        <i class="fas fa-sign-in-alt mr-1"></i>
                        Login
                    </a>
                @endauth

                {{-- Mobile Menu Button --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden text-neutral-600 hover:text-primary-600 transition-colors">
                    <i class="fas fa-bars text-lg" x-show="!mobileMenuOpen"></i>
                    <i class="fas fa-times text-lg" x-show="mobileMenuOpen"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Search Bar --}}
    <div x-show="searchOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="lg:hidden border-t border-neutral-200 bg-white px-4 py-3">
        <form action="#" method="GET" class="relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk kucing..."
                class="form-input pl-10 pr-4 w-full rounded-full">
            <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-400">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4" class="lg:hidden border-t border-neutral-200 bg-white">
        <div class="px-4 py-3 space-y-2">
            <a href="#" class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors">
                <i class="fas fa-home mr-2"></i>
                Home
            </a>
            <a href="#" class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors">
                <i class="fas fa-box mr-2"></i>
                Products
            </a>
            <a href="#" class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors">
                <i class="fas fa-info-circle mr-2"></i>
                About
            </a>
            <a href="#" class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors">
                <i class="fas fa-envelope mr-2"></i>
                Contact
            </a>

            @guest
                <div class="border-t border-neutral-200 pt-4 mt-4">
                    <a href="#" class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login
                    </a>
                    <a href="#" class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors">
                        <i class="fas fa-user-plus mr-2"></i>
                        Register
                    </a>
                </div>
            @endguest
        </div>
    </div>

    {{-- Cart Slide Panel --}}
    <div x-show="cartOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 bg-black bg-opacity-50" @click="cartOpen = false">
        <div x-show="cartOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-xl" @click.stop>
            <div class="flex flex-col h-full">
                {{-- Cart Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-neutral-200">
                    <h3 class="text-lg font-semibold text-neutral-900">Shopping Cart</h3>
                    <button @click="cartOpen = false" class="text-neutral-400 hover:text-neutral-600">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                {{-- Cart Content --}}
                <div class="flex-1 overflow-y-auto p-6">
                    <div id="cart-items">
                        {{-- Cart items akan di-load via JavaScript --}}
                        <div class="text-center py-8">
                            <i class="fas fa-shopping-cart text-4xl text-neutral-300 mb-4"></i>
                            <p class="text-neutral-500">Keranjang Anda kosong</p>
                        </div>
                    </div>
                </div>

                {{-- Cart Footer --}}
                <div class="border-t border-neutral-200 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold">Total:</span>
                        <span class="text-xl font-bold text-primary-600" id="cart-total">Rp 0</span>
                    </div>
                    <div class="space-y-2">
                        <a href="#" class="btn btn-outline w-full">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            View Cart
                        </a>
                        <a href="#" class="btn btn-primary w-full">
                            <i class="fas fa-credit-card mr-2"></i>
                            Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
