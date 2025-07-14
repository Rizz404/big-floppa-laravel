<x-user-layout title="Result">

    <div class="container mx-auto px-4 py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900">Rekomendasi Terbaik Untukmu</h1>
            <p class="mt-3 text-lg text-gray-600">Berdasarkan preferensi yang kamu berikan, berikut adalah ras kucing
                yang paling cocok.</p>
        </div>

        {{-- * Cek jika ada hasil atau tidak --}}
        @if ($rankings->isEmpty())
            <div class="text-center bg-white p-12 rounded-2xl shadow-md max-w-2xl mx-auto">
                <p class="text-xl text-gray-700">Oops! Tidak ada hasil yang bisa ditampilkan saat ini.</p>
                <a href="{{ route('recommendations.create') }}"
                    class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                    Coba Pencarian Baru
                </a>
            </div>
        @else
            {{-- * Tampilkan hasil jika ada --}}
            <div class="space-y-6 max-w-4xl mx-auto">
                @foreach ($rankings as $result)
                    <div
                        class="bg-white rounded-2xl shadow-lg overflow-hidden transition duration-300 hover:shadow-xl hover:scale-[1.02]">
                        <div class="flex flex-col md:flex-row items-stretch">

                            {{-- Kolom Kiri: Peringkat & Skor --}}
                            <div
                                class="w-full md:w-32 bg-blue-600 text-white flex flex-row md:flex-col items-center justify-around md:justify-center p-4 text-center flex-shrink-0">
                                <div class="flex-1 md:flex-none">
                                    <span class="text-sm font-semibold tracking-wider uppercase">Peringkat</span>
                                    <p class="text-5xl font-bold">{{ $result->rank }}</p>
                                </div>
                                <div class="w-px md:w-16 h-16 md:h-px bg-blue-400 my-2 mx-4 md:mx-0"></div>
                                <div class="flex-1 md:flex-none">
                                    <span class="text-sm font-semibold tracking-wider uppercase">Skor</span>
                                    <p class="text-2xl font-bold">{{ number_format($result->final_score, 3) }}</p>
                                </div>
                            </div>

                            {{-- Kolom Kanan: Info Ras Kucing --}}
                            <div class="flex-grow flex items-center p-6">
                                <div class="flex-shrink-0 mr-6">
                                    <img src="{{ $result->breed->photo_url ?? 'https://placehold.co/150x150/e2e8f0/334155?text=Kucing' }}"
                                        alt="Foto {{ $result->breed->name }}"
                                        class="h-28 w-28 md:h-36 md:w-36 rounded-full object-cover ring-4 ring-white shadow-md">
                                </div>
                                <div class="text-center md:text-left">
                                    <h2 class="text-2xl font-bold text-gray-900">{{ $result->breed->name }}</h2>
                                    <p class="mt-2 text-gray-600 text-sm">
                                        {{ $result->breed->description ?? 'Deskripsi untuk ras ini belum tersedia.' }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('recommendations.create') }}"
                    class="inline-block bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                    Ulangi Pencarian
                </a>
            </div>
        @endif
    </div>

</x-user-layout>
