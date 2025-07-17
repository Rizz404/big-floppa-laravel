<x-user-layout :title="$cat->title">
    <div class="container-wide py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- * Kolom Kiri: Detail Kucing --}}
            <div class="md:col-span-2">
                <div class="card">
                    {{-- * Carousel Gambar --}}
                    @if ($cat->photos->isNotEmpty())
                        <div class="relative">
                            {{-- * Kontainer foto yang bisa di-scroll --}}
                            <div class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth rounded-t-lg"
                                id="gallery">
                                @foreach ($cat->photos as $photo)
                                    <div id="photo-{{ $loop->index }}" class="snap-center flex-shrink-0 w-full h-96">
                                        <img src="{{ $photo->path }}"
                                            alt="{{ $photo->caption ?? $cat->title . ' - Photo ' . $loop->iteration }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>

                            {{-- * Navigasi titik-titik di bawah --}}
                            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                                @foreach ($cat->photos as $photo)
                                    <a href="#photo-{{ $loop->index }}"
                                        class="w-3 h-3 bg-white/70 rounded-full hover:bg-white transition"></a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        {{-- * Fallback jika tidak ada foto sama sekali --}}
                        <img src="https://placekitten.com/800/600" alt="{{ $cat->title }}"
                            class="w-full h-96 object-cover rounded-t-lg">
                    @endif

                    <div class="card-body">
                        {{-- * Judul dan Status --}}
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h1 class="text-3xl font-bold text-neutral-900">{{ $cat->title }}</h1>
                                <p class="text-lg text-neutral-500">{{ $cat->breed?->name ?? 'Breed Tidak Diketahui' }}
                                </p>
                            </div>
                            <span
                                class="badge {{ $cat->status == 'available' ? 'badge-success' : 'badge-danger' }} text-base">{{ Str::ucfirst($cat->status) }}</span>
                        </div>

                        {{-- * Deskripsi --}}
                        <div class="prose max-w-none text-neutral-700">
                            <p>{{ $cat->description }}</p>
                        </div>

                        {{-- * Detail Spesifik --}}
                        <div class="mt-6 border-t border-neutral-200 pt-6">
                            <h3 class="text-xl font-semibold mb-4">Details</h3>
                            <dl class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                <dt class="font-medium text-neutral-600">Gender:</dt>
                                <dd>{{ Str::ucfirst($cat->gender) }}</dd>

                                <dt class="font-medium text-neutral-600">Birth Date:</dt>
                                <dd>{{ \Carbon\Carbon::parse($cat->birth_date)->format('d F Y') }}</dd>

                                <dt class="font-medium text-neutral-600">Age:</dt>
                                <dd>{{ \Carbon\Carbon::parse($cat->birth_date)->age }} years old</dd>

                                <dt class="font-medium text-neutral-600">Location:</dt>
                                <dd>{{ $cat->location }}</dd>

                                <dt class="font-medium text-neutral-600">Vaccinated:</dt>
                                <dd>
                                    @if ($cat->is_vaccinated)
                                        <i class="fas fa-check-circle text-success-500"></i> Yes
                                    @else
                                        <i class="fas fa-times-circle text-danger-500"></i> No
                                    @endif
                                </dd>
                                <dt class="font-medium text-neutral-600">Dewormed:</dt>
                                <dd>
                                    @if ($cat->is_dewormed)
                                        <i class="fas fa-check-circle text-success-500"></i> Yes
                                    @else
                                        <i class="fas fa-times-circle text-danger-500"></i> No
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            {{-- * Kolom Kanan: Penjual & Aksi --}}
            <div class="md:col-span-1">
                <div class="card sticky top-24">
                    <div class="card-body text-center">
                        <div class="card-body text-center">
                            <img src="https://i.pravatar.cc/150?u={{ $cat->seller->id }}"
                                alt="{{ $cat->seller->name }}" class="w-24 h-24 rounded-full mx-auto shadow-lg">
                            <h3 class="mt-4 text-xl font-bold">{{ $cat->seller->name }}</h3>
                            <p class="text-sm text-neutral-500">Seller</p>
                        </div>

                        {{-- * TODO: Tambahkan detail penjual lain jika ada --}}
                    </div>
                    <form method="POST" action="{{ route('cart.store') }}" class="card-footer">
                        @csrf

                        <x-ui.input type="hidden" name="listing_id" value="{{ $cat->id }}" />
                        @if ($cat->status == 'available')
                            <x-ui.button type="submit" variant="primary" size="lg" class="w-full">
                                <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                            </x-ui.button>
                        @else
                            <button class="btn btn-neutral w-full btn-lg" disabled>
                                <i class="fas fa-ban mr-2"></i> Already Sold
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>
