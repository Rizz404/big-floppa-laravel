<x-user-layout title="My Profile">
    <div class="container-wide py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
            {{-- * KOLOM KIRI: SIDEBAR NAVIGASI --}}
            <aside class="col-span-1">
                <div class="card">
                    <div class="card-body p-2">
                        <nav class="space-y-1">
                            <a href="{{ route('profile.show') }}"
                                class="nav-link block px-4 py-2 rounded-md font-medium text-base {{ request()->routeIs('profile.show') ? 'nav-link-active bg-primary-100' : 'hover:bg-neutral-50' }}">
                                <i class="fas fa-user-edit fa-fw mr-2"></i>Profile
                            </a>
                            <a href="{{ route('profile.addresses.index') }}"
                                class="nav-link block px-4 py-2 rounded-md font-medium text-base hover:bg-neutral-50">
                                <i class="fas fa-map-marked-alt fa-fw mr-2"></i>Addresses
                            </a>
                            <a href="#"
                                class="nav-link block px-4 py-2 rounded-md font-medium text-base hover:bg-neutral-50">
                                <i class="fas fa-receipt fa-fw mr-2"></i>Order History
                            </a>
                        </nav>
                    </div>
                </div>
            </aside>

            {{-- * KOLOM KANAN: KONTEN UTAMA --}}
            <main class="col-span-1 lg:col-span-3 space-y-8">
                {{-- * FORM UPDATE PROFIL --}}
                <div class="card">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="card-header">
                            <h3 class="text-lg font-semibold">Profile Information</h3>
                            <p class="text-sm text-neutral-500 mt-1">Update your account's profile information and email
                                address.</p>
                        </div>
                        <div class="card-body space-y-4">
                            <x-ui.input name="name" label="Display Name" :value="old('name', $user->name)" required />
                            <x-ui.input type="email" name="email" label="Email Address" :value="old('email', $user->email)"
                                required />
                            <x-ui.input name="fullname" label="Full Name" :value="old('fullname', $user->profile?->fullname)" />
                            <x-ui.input type="number" name="age" label="Age" :value="old('age', $user->profile?->age)" />
                            <x-ui.input name="phone_number" label="Phone Number" :value="old('phone_number', $user->profile?->phone_number)" />
                        </div>
                        <div class="card-footer text-right">
                            <x-ui.button type="submit" variant="primary">Save Changes</x-ui.button>
                        </div>
                    </form>
                </div>

                {{-- * FORM UPDATE PASSWORD --}}
                <div class="card">
                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="card-header">
                            <h3 class="text-lg font-semibold">Change Password</h3>
                            <p class="text-sm text-neutral-500 mt-1">Ensure your account is using a long, random
                                password to stay secure.</p>
                        </div>
                        <div class="card-body space-y-4">
                            <x-ui.input type="password" name="current_password" label="Current Password" required />
                            <x-ui.input type="password" name="new_password" label="New Password" required />
                            <x-ui.input type="password" name="new_password_confirmation" label="Confirm New Password"
                                required />
                        </div>
                        <div class="card-footer text-right">
                            <x-ui.button type="submit" variant="primary">Change Password</x-ui.button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</x-user-layout>
