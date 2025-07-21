<x-user-layout title="Contact Us">
    <section class="bg-gradient-to-br from-primary-100 via-white to-secondary-100 py-16 text-center">
        <div class="container-wide">
            <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 mb-4">
                Get In Touch </h1>
            <p class="text-lg text-neutral-600 max-w-3xl mx-auto">
                Have a question or need support? We're here to help. Reach out to us anytime.
        </div>
    </section>

    <div class="container-wide py-16">
        @if (session('success'))
            <div class="alert alert-success mb-8">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-12">
            <div class="lg:col-span-1">
                <h3 class="text-2xl font-bold mb-4">Contact Information</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <i class="fas fa-map-marker-alt text-primary-500 text-xl mt-1"></i>
                        <div>
                            <h4 class="font-semibold">Our Address</h4>
                            <p class="text-neutral-600">101 Happy Cat Street, Jakarta, Indonesia</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <i class="fas fa-envelope text-primary-500 text-xl mt-1"></i>
                        <div>
                            <h4 class="font-semibold">Email Us</h4>
                            <p class="text-neutral-600">support@bigfloppa.store</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <i class="fas fa-phone text-primary-500 text-xl mt-1"></i>
                        <div>
                            <h4 class="font-semibold">Call Us</h4>
                            <p class="text-neutral-600">+62 21 1234 5678</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2 bg-white p-8 rounded-lg shadow-md border">
                <h3 class="text-2xl font-bold mb-6">Send Us a Message</h3>
                <form action="" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-4">
                        <x-ui.input name="name" label="Full Name" placeholder="Your Name" required />
                        <x-ui.input name="email" type="email" label="Email Address" placeholder="you@example.com"
                            required />
                    </div>
                    <x-ui.input name="subject" label="Subject" placeholder="What is your message about?" required />
                    <x-ui.textarea name="message" label="Message" placeholder="Write your message here..."
                        rows="5" required />

                    <div class="text-right">
                        <x-ui.button type="submit" size="lg">Send Message</x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-user-layout>
