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
                            <label for="sort_by" class="form-label">Sort By</label>
                            <select name="sort_by" id="sort_by" class="form-select">
                                <option value="created_at" @selected(request('sort_by', 'created_at') == 'created_at')>Newest</option>
                                <option value="title" @selected(request('sort_by') == 'title')>Title</option>
                                <option value="updated_at" @selected(request('sort_by') == 'updated_at')>Last Updated</option>
                            </select>
                            <select name="sort_direction" class="form-select mt-2">
                                <option value="desc" @selected(request('sort_direction', 'desc') == 'desc')>Descending</option>
                                <option value="asc" @selected(request('sort_direction') == 'asc')>Ascending</option>
                            </select>
                        </div>

                        {{-- * Gender --}}
                        <div>
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="">All</option>
                                <option value="male" @selected(request('gender') == 'male')>Male</option>
                                <option value="female" @selected(request('gender') == 'female')>Female</option>
                            </select>
                        </div>

                        {{-- * Umur --}}
                        <div>
                            <label class="form-label">Age (years)</label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="age_min" placeholder="Min" value="{{ request('age_min') }}"
                                    class="form-input">
                                <span>-</span>
                                <input type="number" name="age_max" placeholder="Max" value="{{ request('age_max') }}"
                                    class="form-input">
                            </div>
                        </div>

                        {{-- * Status Kesehatan --}}
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_vaccinated" value="1" @checked(request('is_vaccinated'))
                                    class="form-checkbox">
                                <span class="ml-2">Vaccinated</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_dewormed" value="1" @checked(request('is_dewormed'))
                                    class="form-checkbox">
                                <span class="ml-2">Dewormed</span>
                            </label>
                        </div>
                    </div>
                    <div class="card-footer flex items-center gap-4">
                        <button type="submit" class="btn btn-primary w-full">Apply</button>
                        <a href="{{ route('cats.index') }}" class="btn btn-ghost">Reset</a>
                    </div>
                </form>
            </aside>

            {{-- * KOLOM HASIL LISTING --}}
            <main class="col-span-1 lg:col-span-3">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($cats as $cat)
                        <div class="card">
                            <a href="{{ route('cats.show', $cat) }}">
                                <img src="{{ $cat->primaryPhoto?->path ? $cat->primaryPhoto->path : 'https://placekitten.com/400/300?image=' . $loop->iteration }}"
                                    alt="{{ $cat->title }}" class="w-full h-48 object-cover"> </a>
                            <div class="card-body">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-lg text-neutral-900">
                                        <a href="{{ route('cats.show', $cat) }}"
                                            class="hover:text-primary-600">{{ $cat->title }}</a>
                                    </h4>
                                    <span
                                        class="badge {{ $cat->status == 'available' ? 'badge-success' : 'badge-danger' }}">{{ Str::ucfirst($cat->status) }}</span>
                                </div>
                                <p class="text-sm text-neutral-500">{{ $cat->breed->name }}</p>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @if ($cat->is_vaccinated)
                                        <span class="badge badge-secondary">Vaccinated</span>
                                    @endif
                                    @if ($cat->is_dewormed)
                                        <span class="badge badge-secondary">Dewormed</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="md:col-span-2 xl:col-span-3 text-center py-16 card">
                            <h3 class="text-xl font-semibold">No Listings Found</h3>
                            <p class="mt-2 text-neutral-500">Try adjusting your filters to find your perfect cat.</p>
                        </div>
                    @endforelse
                </div>

                {{-- * Paginasi --}}
                <div class="mt-8">
                    {{ $cats->links() }}
                </div>
            </main>
        </div>
    </div>
</x-user-layout>
