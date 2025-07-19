<x-user-layout title="Register" :showHeader="false">
    <div class="container-narrow py-12">
        <div class="card max-w-lg mx-auto">
            <div class="card-header">
                <h2 class="text-2xl font-bold text-center">Create Your Account</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <x-ui.input name="name" label="Full Name" :value="old('name')" required autocomplete="name" />

                    <x-ui.input type="email" name="email" label="Email Address" :value="old('email')" required
                        autocomplete="email" />

                    <x-ui.input type="password" name="password" label="Password" required autocomplete="new-password" />

                    <x-ui.input type="password" name="password_confirmation" label="Confirm Password" required
                        autocomplete="new-password" />

                    <x-ui.checkbox name="remember_me" label="Remember Me" />

                    <x-ui.button type="submit" variant="primary" class="w-full">
                        Create Account
                    </x-ui.button>
                </form>
            </div>
            <div class="card-footer text-center">
                <p class="text-sm text-neutral-500">
                    Already have an account?
                    <a href="{{ route('login.form') }}" class="font-medium">
                        Log In
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-user-layout>
