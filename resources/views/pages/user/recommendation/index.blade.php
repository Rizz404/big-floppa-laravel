<x-user-layout title="Your Cat Breed Recommendation">

    <div class="container-narrow py-12 sm:py-16">
        <div class="text-center mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold">Here Are Your Top Matches!</h1>
            <p class="mt-2 text-neutral-600 max-w-2xl mx-auto">
                Based on the preferences you set, these cat breeds are your most compatible companions.
            </p>
        </div>

        {{-- * Daftar Hasil Peringkat --}}
        <div class="space-y-6">
            @forelse ($rankings as $ranking)
                <div class="card animate-slide-up" style="animation-delay: {{ $loop->index * 100 }}ms;">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row items-start gap-6">
                            {{-- * Peringkat & Foto --}}
                            <div class="flex-shrink-0 text-center w-full sm:w-40">
                                <div
                                    class="relative mx-auto w-24 h-24 sm:w-32 sm:h-32 rounded-full overflow-hidden shadow-lg border-4 {{ $loop->first ? 'border-primary-500' : 'border-neutral-200' }}">
                                    <img src="{{ $ranking->breed->photo_url ?? 'https://placekitten.com/200/200' }}"
                                        alt="{{ $ranking->breed->name }}" class="w-full h-full object-cover">
                                    <div
                                        class="absolute -top-2 -right-2 w-10 h-10 bg-primary-500 text-white flex items-center justify-center rounded-full text-lg font-bold shadow-md">
                                        {{ $ranking->rank }}
                                    </div>
                                </div>
                            </div>

                            {{-- * Detail Ras --}}
                            <div class="flex-grow w-full">
                                <div class="flex justify-between items-baseline">
                                    <h2 class="text-2xl font-bold text-neutral-900">{{ $ranking->breed->name }}</h2>
                                    <span class="badge badge-success">{{ round($ranking->final_score * 100) }}%
                                        Match</span>
                                </div>
                                <p class="text-sm text-neutral-500 mt-1">
                                    <i class="fas fa-map-marker-alt fa-fw mr-1"></i>
                                    Origin: {{ $ranking->breed->origin_country ?? 'Unknown' }}
                                </p>
                                <p class="mt-3 text-neutral-600 leading-relaxed">
                                    {{ Str::limit($ranking->breed->description, 200) }}
                                </p>
                                <div class="mt-4 text-right">
                                    {{-- * Tombol ini bisa diarahkan ke halaman detail ras atau halaman listing --}}
                                    <a href="{{ route('breeds.show', $ranking->breed) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-search mr-2"></i>
                                        View Available {{ $ranking->breed->name }}s
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- * Tampilan jika tidak ada hasil --}}
                <div class="card">
                    <div class="card-body text-center py-16">
                        <div class="w-20 h-20 bg-neutral-100 rounded-full mx-auto flex items-center justify-center">
                            <i class="fas fa-cat text-4xl text-neutral-400"></i>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold">No Recommendations Found</h3>
                        <p class="mt-2 text-neutral-500">We couldn't generate a recommendation based on this session.
                        </p>
                        <a href="{{ route('recommendations.create') }}" class="btn btn-primary mt-6">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Try Again
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- * Tombol untuk Mencoba Lagi --}}
        <div class="mt-12 text-center">
            <a href="{{ route('recommendations.create') }}" class="btn btn-outline btn-lg">
                <i class="fas fa-redo-alt mr-2"></i>
                Recalculate with New Preferences
            </a>
        </div>
    </div>

</x-user-layout>
