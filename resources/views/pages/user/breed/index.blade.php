<x-user-layout title="Cat Breeds" :description="'Browse through various cat breeds and find listings for your ideal feline companion. Filter by origin country and search by breed name.'" :keywords="'cat breeds, feline breeds, cat types, pet breeds, cat listings'" container-class="">
    {{-- * Hero Section --}}
    <section class="bg-gradient-to-br from-primary-100 via-white to-secondary-100 py-16">
        <div class="container-wide">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 mb-4">
                    Discover Cat Breeds
                </h1>
                <p class="text-lg text-neutral-600 mb-8">
                    Explore different cat breeds and find your perfect feline companion from trusted sellers
                </p>

                {{-- * Quick Stats --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-2xl mx-auto">
                    <div class="bg-white/80 backdrop-blur-sm rounded-lg p-4 shadow-md">
                        <div class="text-2xl font-bold text-primary-600">{{ $breeds->total() }}</div>
                        <div class="text-sm text-neutral-600">Cat Breeds</div>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm rounded-lg p-4 shadow-md">
                        <div class="text-2xl font-bold text-success-600">{{ $breeds->sum('listings_count') }}</div>
                        <div class="text-sm text-neutral-600">Available Cats</div>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm rounded-lg p-4 shadow-md">
                        <div class="text-2xl font-bold text-secondary-600">{{ $countries->count() }}</div>
                        <div class="text-sm text-neutral-600">Countries</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- * Filters Section --}}
    <section class="bg-white border-b border-neutral-200 sticky top-0 z-30 shadow-sm">
        <div class="container-wide py-4">
            <form method="GET" action="{{ route('breeds.index') }}" class="flex flex-wrap items-center gap-4">
                {{-- * Search --}}
                <div class="flex-1 min-w-64">
                    <div class="relative">
                        <x-ui.input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search breeds or countries..." class="pl-10 pr-4" />
                        <i
                            class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-400"></i>
                    </div>
                </div>

                {{-- * Country Filter --}}
                <div class="min-w-48">
                    <x-ui.dropdown name="country">
                        <option value="">All Countries</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country }}"
                                {{ request('country') == $country ? 'x-ui.dropdown' : '' }}>
                                {{ $country }}
                            </option>
                        @endforeach
                    </x-ui.dropdown>
                </div>

                {{-- * Sort --}}
                <div class="min-w-40">
                    <x-ui.dropdown name="sort">
                        <option value="name" {{ request('sort') == 'name' ? 'x-ui.dropdown' : '' }}>Sort by Name
                        </option>
                        <option value="origin_country" {{ request('sort') == 'origin_country' ? 'x-ui.dropdown' : '' }}>
                            Sort
                            by Country</option>
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'x-ui.dropdown' : '' }}>Sort by
                            Date
                        </option>
                    </x-ui.dropdown>
                </div>

                {{-- * Sort Order --}}
                <div class="flex items-center gap-2">
                    <x-ui.button type="submit" name="order" variant="ghost"
                        value="{{ request('order') == 'desc' ? 'asc' : 'desc' }}" class="p-2"
                        title="Toggle sort order">
                        <i class="fas fa-sort-amount-{{ request('order') == 'desc' ? 'up' : 'down' }}"></i>
                    </x-ui.button>
                </div>

                {{-- * Submit Button --}}
                <x-ui.button type="submit" class="">
                    <i class="fas fa-filter mr-2"></i>Filter
                </x-ui.button>

                {{-- * Clear Filters --}}
                @if (request()->hasAny(['search', 'country', 'sort', 'order']))
                    <x-ui.button href="{{ route('breeds.index') }}" variant="ghost">
                        <i class="fas fa-times mr-2"></i>Clear
                    </x-ui.button>
                @endif
            </form>
        </div>
    </section>

    {{-- * Breeds Grid --}}
    <section class="py-12">
        <div class="container-wide">
            @if ($breeds->isEmpty())
                {{-- * Empty State --}}
                <div class="text-center py-16">
                    <div class="text-6xl text-neutral-300 mb-4">
                        <i class="fas fa-cat"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-neutral-700 mb-2">No breeds found</h3>
                    <p class="text-neutral-500 mb-6">Try adjusting your search or filter criteria</p>
                    <a href="{{ route('breeds.index') }}" class="btn btn-primary">
                        View All Breeds
                    </a>
                </div>
            @else
                {{-- * Results Info --}}
                <div class="flex justify-between items-center mb-8">
                    <div class="text-neutral-600">
                        Showing {{ $breeds->firstItem() }}-{{ $breeds->lastItem() }} of {{ $breeds->total() }} breeds
                    </div>
                </div>

                {{-- * Breeds Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
                    @foreach ($breeds as $breed)
                        <div class="card group cursor-pointer transform transition-all duration-300 hover:scale-105">
                            <a href="{{ route('breeds.show', $breed) }}" class="block">
                                {{-- * Breed Image --}}
                                <div
                                    class="relative h-48 bg-gradient-to-br from-neutral-100 to-neutral-200 overflow-hidden">
                                    @if ($breed->photo_url)
                                        <img src="{{ $breed->photo_url }}" alt="{{ $breed->name }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                            loading="lazy">
                                    @else
                                        <div class="flex items-center justify-center h-full text-neutral-400">
                                            <i class="fas fa-cat text-4xl"></i>
                                        </div>
                                    @endif

                                    {{-- * Listings Count Badge --}}
                                    @if ($breed->listings_count > 0)
                                        <div
                                            class="absolute top-3 right-3 bg-success-500 text-white text-xs px-2 py-1 rounded-full">
                                            {{ $breed->listings_count }} available
                                        </div>
                                    @endif
                                </div>

                                {{-- * Breed Info --}}
                                <div class="card-body">
                                    <h3
                                        class="text-lg font-semibold text-neutral-900 mb-2 group-hover:text-primary-600 transition-colors">
                                        {{ $breed->name }}
                                    </h3>

                                    @if ($breed->origin_country)
                                        <p class="text-sm text-neutral-500 mb-2">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ $breed->origin_country }}
                                        </p>
                                    @endif

                                    @if ($breed->description)
                                        <p class="text-sm text-neutral-600 line-clamp-2">
                                            {{ Str::limit($breed->description, 80) }}
                                        </p>
                                    @endif

                                    {{-- * Action Hint --}}
                                    <div
                                        class="flex items-center justify-between mt-4 pt-4 border-t border-neutral-200">
                                        <span class="text-sm font-medium text-primary-600 group-hover:text-primary-700">
                                            View Details
                                        </span>
                                        <i
                                            class="fas fa-arrow-right text-primary-500 group-hover:translate-x-1 transition-transform"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                {{-- * Pagination --}}
                <div class="flex justify-center">
                    {{ $breeds->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- * CTA Section --}}
    @if (!$breeds->isEmpty())
        <section class="bg-gradient-to-r from-primary-500 to-primary-600 py-16">
            <div class="container-wide text-center">
                <h2 class="text-3xl font-bold text-white mb-4">Not Sure Which Cat to Choose?</h2>
                <p class="text-primary-100 mb-8 max-w-2xl mx-auto">
                    Are you hesitant about which cat personality fits your lifestyle? Take our short quiz to get a
                    personalized recommendation! </p>
                <div class="flex flex-col sm:flex-row justify-center items-center">
                    <a href="{{ route('recommendations.create') }}"
                        class="btn bg-white text-primary-600 hover:bg-primary-50">
                        <i class="fas fa-question-circle mr-2"></i> Find My Match </a>
                </div>
            </div>
        </section>
    @endif

    @push('styles')
        <style>
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        </style>
    @endpush
</x-user-layout>
