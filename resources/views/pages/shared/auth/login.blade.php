<x-user-layout title="Login" :showHeader="false">
    <div class="container-narrow py-12">
        <div class="card max-w-lg mx-auto">
            <div class="card-header">
                <h2 class="text-2xl font-bold text-center">Welcome Back!</h2>
                <p class="text-center text-neutral-500 mt-1">Sign in to continue.</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <x-ui.input type="email" name="email" label="Email Address" :value="old('email')" required
                        autocomplete="email" />

                    <x-ui.input type="password" name="password" label="Password" required
                        autocomplete="current-password" />

                    <div class="flex items-center justify-between">
                        <x-ui.checkbox name="remember_me" label="Remember Me" />
                        {{-- <a href="#" class="text-sm font-medium">
                            Forgot password?
                        </a> --}}
                    </div>

                    <x-ui.button type="submit" variant="primary" class="w-full">
                        Log In
                    </x-ui.button>
                </form>
            </div>
            <div class="card-footer text-center">
                <p class="text-sm text-neutral-500">
                    Don't have an account?
                    <a href="{{ route('register.form') }}" class="font-medium">
                        Sign Up
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-user-layout>
