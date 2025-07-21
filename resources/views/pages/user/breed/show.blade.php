<x-user-layout :title="$breed->name . ' Cats for Sale - Find Your Perfect ' . $breed->name" :description="'Find ' .
    $breed->name .
    ' cats for sale. Browse available cats from trusted sellers with detailed information about each cat.'" :keywords="$breed->name . ' cats, ' . $breed->name . ' for sale, cat cats, pet cats'" container-class="">
    {{-- * Breadcrumb --}}
    <nav class="bg-neutral-50 border-b border-neutral-200" aria-label="Breadcrumb">
        <div class="container-wide py-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('breeds.index') }}" class="text-neutral-500 hover:text-primary-600">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li>
                    <i class="fas fa-chevron-right text-neutral-400"></i>
                </li>
                <li>
                    <a href="{{ route('breeds.index') }}" class="text-neutral-500 hover:text-primary-600">
                        Breeds
                    </a>
                </li>
                <li>
                    <i class="fas fa-chevron-right text-neutral-400"></i>
                </li>
                <li class="text-neutral-700 font-medium">
                    {{ $breed->name }}
                </li>
            </ol>
        </div>
    </nav>

    {{-- * Breed Header --}}
    <section class="bg-gradient-to-br from-primary-50 to-secondary-50 py-12">
        <div class="container-wide">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                {{-- * Breed Image --}}
                <div class="order-2 lg:order-1">
                    <div class="relative h-80 lg:h-96 bg-white rounded-2xl shadow-lg overflow-hidden">
                        @if ($breed->photo_url)
                            <img src="{{ $breed->photo_url }}" alt="{{ $breed->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-neutral-400">
                                <i class="fas fa-cat text-6xl"></i>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- * Breed Info --}}
                <div class="order-1 lg:order-2">
                    <h1 class="text-4xl lg:text-5xl font-bold text-neutral-900 mb-4">
                        {{ $breed->name }}
                    </h1>

                    @if ($breed->origin_country)
                        <div class="flex items-center text-neutral-600 mb-4">
                            <i class="fas fa-map-marker-alt text-primary-500 mr-2"></i>
                            <span class="font-medium">Origin: {{ $breed->origin_country }}</span>
                        </div>
                    @endif

                    @if ($breed->description)
                        <p class="text-neutral-600 text-lg leading-relaxed mb-6">
                            {{ $breed->description }}
                        </p>
                    @endif

                    {{-- * Quick Stats --}}
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-white rounded-lg p-4 text-center shadow-md">
                            <div class="text-2xl font-bold text-success-600">{{ $cats->total() }}</div>
                            <div class="text-sm text-neutral-600">Available Cats</div>
                        </div>
                        @if ($priceRange && $priceRange->min_price && $priceRange->max_price)
                            <div class="bg-white rounded-lg p-4 text-center shadow-md">
                                <div class="text-lg font-bold text-primary-600">
                                    Rp {{ number_format($priceRange->min_price, 0, ',', '.') }}
                                    @if ($priceRange->min_price != $priceRange->max_price)
                                        - {{ number_format($priceRange->max_price, 0, ',', '.') }}
                                    @endif
                                </div>
                                <div class="text-sm text-neutral-600">Price Range</div>
                            </div>
                        @endif
                    </div>

                    {{-- * CTA Button --}}
                    <div class="flex gap-4">
                        <x-ui.button href="#cats" variant="primary" size="lg">
                            <i class="fas fa-paw mr-2"></i>
                            View Available Cats
                        </x-ui.button>
                        <x-ui.button variant="outline" size="lg" onclick="window.history.back()">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Breeds
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- * Filters Section --}}
    <section id="cats" class="bg-white border-b border-neutral-200 sticky top-0 z-30 shadow-sm">
        <div class="container-wide py-6">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-4">
                <h2 class="text-2xl font-bold text-neutral-900">
                    Available {{ $breed->name }} Cats
                    <span class="text-lg text-neutral-500 font-normal">({{ $cats->total() }})</span>
                </h2>
            </div>

            <form method="GET" action="{{ route('breeds.show', $breed) }}"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-4" x-data="{ showAdvanced: false }">
                {{-- * Search --}}
                <div class="lg:col-span-2">
                    <x-ui.input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search cats..." class="form-x-ui.input w-full" />
                </div>

                {{-- * Gender --}}
                <div>
                    <x-ui.dropdown name="gender" class="w-full">
                        <option value="">All Genders</option>
                        <option value="male" {{ request('gender') == 'male' ? 'x-ui.dropdowned' : '' }}>Male</option>
                        <option value="female" {{ request('gender') == 'female' ? 'x-ui.dropdowned' : '' }}>Female
                        </option>
                    </x-ui.dropdown>
                </div>

                {{-- * Sort --}}
                <div>
                    <x-ui.dropdown name="sort" class="w-full">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'x-ui.dropdowned' : '' }}>
                            Newest
                        </option>
                        <option value="price" {{ request('sort') == 'price' ? 'x-ui.dropdowned' : '' }}>Price</option>
                        <option value="birth_date" {{ request('sort') == 'birth_date' ? 'x-ui.dropdowned' : '' }}>Age
                        </option>
                    </x-ui.dropdown>
                </div>

                {{-- * Actions --}}
                <div class="flex gap-2">
                    <x-ui.button type="submit" variant="primary" class=" flex-1">
                        Filter
                    </x-ui.button>
                    <x-ui.button type="button" @click="showAdvanced = !showAdvanced" variant="ghost">
                        <i class="fas fa-sliders-h"></i>
                    </x-ui.button>
                </div>

                {{-- * Advanced Filters --}}
                <div x-show="showAdvanced" x-transition
                    class="lg:col-span-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-4 border-t border-neutral-200">
                    {{-- * Price Range --}}
                    <div>
                        <x-ui.input label="Min Price" type="number" name="min_price"
                            value="{{ request('min_price') }}" placeholder="0" />
                    </div>
                    <div>
                        <x-ui.input label="Max Price" type="number" name="max_price"
                            value="{{ request('max_price') }}" placeholder="No limit" />
                    </div>

                    {{-- * Health Status --}}
                    <div>
                        <label class="form-label">Vaccination</label>
                        <x-ui.dropdown name="vaccinated" class="form-x-ui.dropdown">
                            <option value="">Any</option>
                            <option value="1" {{ request('vaccinated') == '1' ? 'x-ui.dropdowned' : '' }}>
                                Vaccinated
                            </option>
                            <option value="0" {{ request('vaccinated') == '0' ? 'x-ui.dropdowned' : '' }}>Not
                                Vaccinated
                            </option>
                        </x-ui.dropdown>
                    </div>
                    <div>
                        <label class="form-label">Dewormed</label>
                        <x-ui.dropdown name="dewormed" class="form-x-ui.dropdown">
                            <option value="">Any</option>
                            <option value="1" {{ request('dewormed') == '1' ? 'x-ui.dropdowned' : '' }}>Dewormed
                            </option>
                            <option value="0" {{ request('dewormed') == '0' ? 'x-ui.dropdowned' : '' }}>Not
                                Dewormed
                            </option>
                        </x-ui.dropdown>
                    </div>
                </div>

                {{-- * Clear Filters --}}
                @if (request()->hasAny(['search', 'gender', 'sort', 'min_price', 'max_price', 'vaccinated', 'dewormed']))
                    <div class="lg:col-span-6">
                        <a href="{{ route('breeds.show', $breed) }}" variant="ghost" class=" text-sm">
                            <i class="fas fa-times mr-2"></i>Clear All Filters
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </section>

    {{-- * Listings Grid --}}
    <section class="py-12">
        <div class="container-wide">
            @if ($cats->isEmpty())
                {{-- * Empty State --}}
                <div class="text-center py-16">
                    <div class="text-6xl text-neutral-300 mb-4">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-neutral-700 mb-2">No cats found</h3>
                    <p class="text-neutral-500 mb-6">
                        @if (request()->hasAny(['search', 'gender', 'sort', 'min_price', 'max_price', 'vaccinated', 'dewormed']))
                            Try adjusting your search or filter criteria
                        @else
                            There are currently no {{ $breed->name }} cats available for sale
                        @endif
                    </p>
                    @if (request()->hasAny(['search', 'gender', 'sort', 'min_price', 'max_price', 'vaccinated', 'dewormed']))
                        <a href="{{ route('breeds.show', $breed) }}" variant="primary" class="">
                            Clear Filters
                        </a>
                    @endif
                </div>
            @else
                {{-- * (Kode Anda sebelumnya...) --}}

                {{-- * Listings Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach ($cats as $cat)
                        <div
                            class="card group cursor-pointer transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                            <a href="{{ route('cats.show', $cat) }}" class="block">
                                {{-- * Listing Image --}}
                                <div
                                    class="relative h-64 bg-gradient-to-br from-neutral-100 to-neutral-200 overflow-hidden">
                                    @if ($cat->primaryPhoto)
                                        <img src="{{ $cat->primaryPhoto->path }}" alt="{{ $cat->title }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="flex items-center justify-center h-full text-neutral-400">
                                            <i class="fas fa-paw text-5xl"></i>
                                        </div>
                                    @endif
                                </div>

                                {{-- * Listing Details --}}
                                <div class="card-body">
                                    <h3 class="font-semibold text-lg text-neutral-800 truncate mb-2 group-hover:text-primary-600"
                                        title="{{ $cat->title }}">
                                        {{ $cat->title }}
                                    </h3>
                                    <div class="text-2xl font-bold text-primary-600 mb-3">
                                        Rp
                                        {{ number_format($cat->price, 0, ',', '.') }}
                                    </div>
                                    <div class="flex items-center text-sm text-neutral-500 space-x-4 mb-4">
                                        <span title="Gender"><i class="fas fa-venus-mars mr-1"></i>
                                            {{ ucfirst($cat->gender) }}</span>
                                        <span title="Age"><i class="fas fa-birthday-cake mr-1"></i>
                                            {{ $cat->birth_date->diffForHumans(null, true) }}</span>
                                    </div>
                                    <div class="flex flex-wrap gap-2 text-xs">
                                        @if ($cat->is_vaccinated)
                                            <span class="badge badge-success"><i class="fas fa-syringe mr-1"></i>
                                                Vaccinated</span>
                                        @endif
                                        @if ($cat->is_dewormed)
                                            <span class="badge badge-secondary"><i class="fas fa-pills mr-1"></i>
                                                Dewormed</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                {{-- * Pagination --}}
                <div class="flex justify-center">
                    {{ $cats->withQueryString()->links() }}
                </div>

            @endif
        </div>
    </section>
</x-user-layout>
