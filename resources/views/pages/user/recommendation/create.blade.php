<x-user-layout title="Find Recommendation">

    {{-- * Sisipkan CSS khusus untuk halaman ini ke dalam layout --}}
    @push('styles')
        <style>
            /* Custom slider thumb style agar terlihat bagus dengan Tailwind */
            input[type=range]::-webkit-slider-thumb {
                -webkit-appearance: none;
                appearance: none;
                width: 24px;
                height: 24px;
                background: #ffffff;
                border: 2px solid #3b82f6;
                /* blue-600 */
                border-radius: 9999px;
                cursor: pointer;
                margin-top: -8px;
                /* Center thumb on track */
            }

            input[type=range]::-moz-range-thumb {
                width: 24px;
                height: 24px;
                background: #ffffff;
                border: 2px solid #3b82f6;
                border-radius: 9999px;
                cursor: pointer;
            }
        </style>
    @endpush

    <div class="container mx-auto px-4 py-12">
        <div class="w-full max-w-2xl mx-auto bg-white rounded-2xl shadow-lg p-8 space-y-6" x-data="recommendationForm({
            criteria: {{ json_encode($criteria->map(fn($c) => ['id' => $c->id, 'name' => $c->name, 'weight' => round(100 / $criteria->count())])) }}
        })"
            x-init="init()">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900">Temukan Ras Kucing Idealmu</h1>
                <p class="mt-2 text-gray-600">Geser slider untuk menyesuaikan preferensi. Total bobot akan selalu 100%.
                </p>
            </div>

            <form action="{{ route('recommendations.store') }}" method="POST" class="space-y-8">
                @csrf

                <template x-for="(criterion, index) in criteria" :key="criterion.id">
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <label :for="'weight_' + criterion.id" class="font-semibold text-gray-700"
                                x-text="criterion.name"></label>
                            <div class="bg-blue-100 text-blue-800 text-sm font-bold px-3 py-1 rounded-full">
                                {{-- Gunakan input hidden untuk mengirim nilai integer ke backend --}}
                                <input type="hidden" :name="`weights[${criterion.id}]`"
                                    :value="Math.round(criterion.weight)">
                                <span x-text="Math.round(criterion.weight)"></span>%
                            </div>
                        </div>
                        <input :id="'weight_' + criterion.id" type="range" min="0" max="100"
                            step="1" x-model.number="criterion.weight" @input.debounce.10ms="adjustWeights(index)"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                            style="background-image: linear-gradient(to right, #3b82f6, #3b82f6); background-repeat: no-repeat;"
                            x-effect="$el.style.backgroundSize = `${criterion.weight}% 100%`">
                    </div>
                </template>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
                        <strong class="font-bold">Oops!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                        Temukan Rekomendasi 🐈
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- * Sisipkan JavaScript khusus untuk halaman ini ke dalam layout --}}
    @push('scripts')
        <script>
            function recommendationForm(initialData) {
                return {
                    criteria: initialData.criteria,
                    oldTotal: 100,

                    init() {
                        this.normalizeWeights();
                    },

                    normalizeWeights(skipIndex = -1) {
                        let total = this.criteria.reduce((sum, c) => sum + c.weight, 0);
                        if (total === 0) return;

                        this.criteria.forEach((c, index) => {
                            if (index !== skipIndex) {
                                c.weight = (c.weight / total) * 100;
                            }
                        });

                        // Pastikan total tepat 100 karena masalah floating point
                        let finalTotal = this.criteria.reduce((sum, c) => sum + c.weight, 0);
                        let roundingError = 100 - finalTotal;

                        // Cari index yang tidak di-skip untuk menampung error pembulatan
                        let adjustmentIndex = this.criteria.findIndex((c, i) => i !== skipIndex);
                        if (adjustmentIndex === -1) adjustmentIndex = 0; // fallback jika hanya ada 1 item

                        this.criteria[adjustmentIndex].weight += roundingError;
                    },

                    adjustWeights(changedIndex) {
                        let changedValue = this.criteria[changedIndex].weight;
                        let totalBeforeChange = this.oldTotal;

                        // Ambil sisa bobot dari slider lain
                        let remainingTotal = totalBeforeChange - this.criteria[changedIndex].weight;

                        // Hitung total baru tanpa slider yang diubah
                        let otherSlidersTotal = 0;
                        this.criteria.forEach((c, index) => {
                            if (index !== changedIndex) {
                                otherSlidersTotal += c.weight;
                            }
                        });

                        if (otherSlidersTotal > 0) {
                            let scaleFactor = remainingTotal / otherSlidersTotal;
                            this.criteria.forEach((c, index) => {
                                if (index !== changedIndex) {
                                    c.weight *= scaleFactor;
                                }
                            });
                        }

                        this.normalizeWeights(changedIndex);
                        this.oldTotal = this.criteria.reduce((sum, c) => sum + c.weight, 0);
                    }
                }
            }
        </script>
    @endpush
</x-user-layout>
