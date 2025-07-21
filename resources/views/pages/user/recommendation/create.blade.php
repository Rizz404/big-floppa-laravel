<x-user-layout title="Find Your Ideal Cat">

    <div class="container-narrow py-12 sm:py-16">
        <div class="card">
            <div class="card-body p-6 sm:p-8">
                <div class="text-center">
                    <h1 class="text-3xl">Find Your Ideal Cat</h1>
                    <p class="mt-2 text-neutral-600">
                        Set your preferences on a scale of 1 to 10 to find the perfect breed for you.
                    </p>
                </div>

                <form action="{{ route('recommendations.store') }}" method="POST" class="mt-8 space-y-8">
                    @csrf

                    @foreach ($criteria as $criterion)
                        <div class=" space-y-2">
                            <x-ui.slider :name="'weights[' . $criterion->id . ']'" :label="$criterion->name" :value="5" />
                            <p class="text-sm text-neutral-500 px-1">
                                {{ $criterion->description }}
                            </p>
                        </div>
                    @endforeach

                    @if ($errors->any())
                        {{-- Menggunakan komponen 'alert' untuk error --}}
                        <div class="alert alert-danger" role="alert">
                            <strong class="font-bold">Oops! Something went wrong.</strong>
                            <ul class="list-disc list-inside mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary btn-lg w-full justify-center cursor-pointer">
                            <i class="fas fa-paw mr-2"></i>
                            Find Recommendation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-user-layout>
