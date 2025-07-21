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

                {{-- Penjelasan Benefit dan Cost --}}
                <div class="alert alert-info mt-6">
                    <h3 class="font-semibold text-secondary-700 mb-2">Understanding Benefit vs Cost Criteria</h3>
                    <div class="grid md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <h4 class="font-medium mb-1">
                                <i class="fas fa-thumbs-up text-success-600 mr-1"></i>
                                <span class="badge badge-success">Benefit Criteria</span>
                            </h4>
                            <p class="text-success-600">
                                Higher scores (8-10) indicate you want <strong>more</strong> of this trait.
                                These are positive qualities you desire in your ideal cat.
                            </p>
                        </div>
                        <div>
                            <h4 class="font-medium mb-1">
                                <i class="fas fa-thumbs-down text-danger-600 mr-1"></i>
                                <span class="badge badge-danger">Cost Criteria</span>
                            </h4>
                            <p class="text-danger-600">
                                Higher scores (8-10) indicate you want <strong>less</strong> of this trait.
                                These represent challenges or drawbacks you want to minimize.
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('recommendations.store') }}" method="POST" class="mt-8 space-y-8">
                    @csrf

                    @foreach ($criteria as $criterion)
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 mb-2">
                                {{-- Badge berdasarkan tipe menggunakan class CSS custom --}}
                                @if ($criterion->type === 'benefit')
                                    <span class="badge badge-success">
                                        <i class="fas fa-plus-circle mr-1"></i>
                                        Benefit
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fas fa-minus-circle mr-1"></i>
                                        Cost
                                    </span>
                                @endif

                                <h3 class="font-medium text-neutral-900">{{ $criterion->name }}</h3>
                            </div>

                            <x-ui.slider :name="'weights[' . $criterion->id . ']'" :label="$criterion->name" :value="5" />

                            <div class="px-1 space-y-1">
                                <p class="text-sm text-neutral-600">
                                    {{ $criterion->description }}
                                </p>

                                {{-- Scale guide --}}
                                <div class="form-help flex justify-between mt-1">
                                    @if ($criterion->type === 'benefit')
                                        <span>1 = Not important</span>
                                        <span>10 = Very important</span>
                                    @else
                                        <span>1 = Can tolerate</span>
                                        <span>10 = Want to avoid</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if ($errors->any())
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
                            Find My Perfect Cat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-user-layout>
