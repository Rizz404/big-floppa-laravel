<x-user-layout title="Browse Cat Listings">
    <div class="container-wide py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            {{-- * KOLOM FILTER --}}
            <aside class="col-span-1">
                <form method="GET" action="{{ route('cats.index') }}" class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold"><i class="fas fa-filter mr-2"></i>Filters</h3>
                    </div>
                    <div class="card-body space-y-6">
                        {{-- * Sorting --}}
                        <div>
                            <x-ui.dropdown label="Sort By" name="sort_by">
                                <option value="created_at" @selected(request('sort_by', 'created_at') == 'created_at')>Newest</option>
                                <option value="title" @selected(request('sort_by') == 'title')>Title</option>
                                <option value="updated_at" @selected(request('sort_by') == 'updated_at')>Last Updated</option>
                            </x-ui.dropdown>
                            <div class="mt-2">
                                <x-ui.dropdown name="sort_direction">
                                    <option value="desc" @selected(request('sort_direction', 'desc') == 'desc')>Descending</option>
                                    <option value="asc" @selected(request('sort_direction') == 'asc')>Ascending</option>
                                </x-ui.dropdown>
                            </div>
                        </div>

                        {{-- * Gender --}}
                        <div>
                            <x-ui.dropdown label="Gender" name="gender">
                                <option value="">All</option>
                                <option value="male" @selected(request('gender') == 'male')>Male</option>
                                <option value="female" @selected(request('gender') == 'female')>Female</option>
                            </x-ui.dropdown>
                        </div>

                        {{-- * Umur --}}
                        <div>
                            <label class="form-label">Age (years)</label>
                            <div class="flex items-center gap-2">
                                <x-ui.input type="number" name="age_min" placeholder="Min"
                                    value="{{ request('age_min') }}" />
                                <span>-</span>
                                <x-ui.input type="number" name="age_max" placeholder="Max"
                                    value="{{ request('age_max') }}" />
                            </div>
                        </div>

                        {{-- * Status Kesehatan --}}
                        <div>
                            <label class="form-label">Health Status</label>
                            <div class="space-y-2 mt-1">
                                <x-ui.checkbox name="is_vaccinated" label="Vaccinated" value="1"
                                    :checked="request()->has('is_vaccinated')" />
                                <x-ui.checkbox name="is_dewormed" label="Dewormed" value="1" :checked="request()->has('is_dewormed')" />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer flex items-center gap-4">
                        <x-ui.button type="submit" variant="primary" class="w-full">Apply</x-ui.button>
                        <x-ui.button variant="ghost" :href="route('cats.index')">Reset</x-ui.button>
                    </div>
                </form>
            </aside>

            {{-- * KOLOM HASIL LISTING --}}
            <main class="col-span-1 lg:col-span-3">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($cats as $cat)
                        <x-cards.cat-cat :cat="$cat" />
                    @empty
                        <div class="md:col-span-2 xl:col-span-3 text-center py-16 card">
                            <h3 class="text-xl font-semibold">No Listings Found</h3>
                            <p class="mt-2 text-neutral-500">Try adjusting your filters to find your perfect cat.</p>
                        </div>
                    @endforelse
                </div>

                {{-- * Paginasi --}}
                {{-- Todo: Benerin paginasi belum tampil --}}
                <div class="mt-8">
                    {{ $cats->withQueryString()->links() }}
                </div>
            </main>
        </div>
    </div>
</x-user-layout>
