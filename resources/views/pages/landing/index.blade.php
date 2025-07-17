<x-user-layout title="Landing"
    description="Welcome to Catopia, the best place to find and adopt your new furry friend. We have a wide variety of breeds and lovely cats waiting for a home."
    containerClass="bg-neutral-100">

    {{-- * Hero Section --}}
    <section class="relative text-center py-20 sm:py-24 md:py-32 gradient-hero text-neutral-800">
        <div class="container-narrow">
            <h1 class="text-4xl md:text-6xl font-extrabold text-neutral-900 !font-display tracking-tight">
                Find Your <span class="text-primary-600">Purrfect</span> Companion
            </h1>
            <p class="mt-4 text-lg md:text-xl max-w-2xl mx-auto text-neutral-600">
                Discover loving cats waiting for a forever home. Start your journey to find a new best friend today.
            </p>
            <div class="mt-8 flex justify-center gap-4">
                <a href="#" class="btn btn-primary btn-lg">
                    <i class="fas fa-cat mr-2"></i> View Available Cats
                </a>
                <a href="#" class="btn btn-outline btn-lg">
                    Learn About Adoption
                </a>
            </div>
        </div>
    </section>

    {{-- * Features Section --}}
    <section class="py-16 sm:py-20 bg-white">
        <div class="container-wide">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-4">
                    <div class="inline-block p-4 bg-primary-100 rounded-full mb-4">
                        <i class="fas fa-heart text-3xl text-primary-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-neutral-900">Healthy & Happy Cats</h3>
                    <p class="mt-2 text-neutral-600">All our cats are vet-checked, vaccinated, and socialized to ensure
                        they are ready for their new homes.</p>
                </div>
                <div class="p-4">
                    <div class="inline-block p-4 bg-secondary-100 rounded-full mb-4">
                        <i class="fas fa-shield-alt text-3xl text-secondary-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-neutral-900">Lifetime Support</h3>
                    <p class="mt-2 text-neutral-600">We provide guidance and support for you and your new cat for life,
                        ensuring a smooth transition and happy life.</p>
                </div>
                <div class="p-4">
                    <div class="inline-block p-4 bg-success-100 rounded-full mb-4">
                        <i class="fas fa-users text-3xl text-success-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-neutral-900">Community Focused</h3>
                    <p class="mt-2 text-neutral-600">Join a community of cat lovers. We host events, share stories, and
                        support local shelters.</p>
                </div>
            </div>
        </div>
    </section>


    {{-- * Popular Breeds Section --}}
    <section class="py-16 sm:py-20 bg-neutral-100">
        <div class="container-wide">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-neutral-900">Popular Breeds</h2>
                <p class="mt-3 text-lg text-neutral-600 max-w-xl mx-auto">Get to know some of the most popular breeds we
                    feature.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($breeds as $breed)
                    <a href="#" class="block group">
                        <div class="card overflow-hidden">
                            <img class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                                src="{{ $breed->photo_url }}" alt="{{ $breed->name }}">
                            <div class="card-body">
                                <h4 class="font-bold text-lg text-neutral-800">{{ $breed->name }}</h4>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- * Recommendation CTA Section --}}
    <section class="py-16 sm:py-20 bg-primary-100">
        <div class="container-narrow text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-neutral-900">Not Sure Which Cat to Choose?</h2>
            <p class="mt-3 text-lg text-neutral-600 max-w-2xl mx-auto">
                Are you hesitant about which cat personality fits your lifestyle? Take our short quiz to get a
                personalized recommendation!
            </p>
            <div class="mt-8">
                <a href="{{ route('recommendations.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-question-circle mr-2"></i> Find My Match
                </a>
            </div>
        </div>
    </section>

    {{-- * Popular Cats Section --}}
    <section class="py-16 sm:py-20 bg-white">
        <div class="container-wide">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-neutral-900">Ready for a Home</h2>
                <p class="mt-3 text-lg text-neutral-600 max-w-xl mx-auto">These lovely cats are looking for a warm lap
                    and a loving family.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($cats as $cat)
                    <x-cards.landing-cat :cat="$cat" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- * Testimonials Section --}}
    <section class="py-16 sm:py-20 bg-neutral-100">
        <div class="container-wide">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-neutral-900">Happy Tails</h2>
                <p class="mt-3 text-lg text-neutral-600 max-w-xl mx-auto">Hear from families who found their perfect
                    companion with us.</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-sm">
                    <p class="text-neutral-600 italic">"The whole process was so smooth. We adopted Mittens a month
                        ago, and she has brought so much joy to our home. The team was incredibly supportive!"</p>
                    <p class="mt-4 font-bold text-neutral-800">- The Johnson Family</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-sm">
                    <p class="text-neutral-600 italic">"I was nervous about adopting my first cat, but the
                        recommendation quiz was spot on! Jasper is the perfect fit for my apartment life. Thank you!"
                    </p>
                    <p class="mt-4 font-bold text-neutral-800">- Sarah L.</p>
                </div>
            </div>
        </div>
    </section>

</x-user-layout>
