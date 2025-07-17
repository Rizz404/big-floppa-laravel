<x-user-layout title="My Addresses">
    <div class="container-wide py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
            {{-- * KOLOM KIRI: SIDEBAR NAVIGASI --}}
            <aside class="col-span-1">
                <div class="card">
                    <div class="card-body p-2">
                        <nav class="space-y-1">
                            <a href="{{ route('profile.show') }}"
                                class="nav-link block px-4 py-2 rounded-md font-medium text-base hover:bg-neutral-50">
                                <i class="fas fa-user-edit fa-fw mr-2"></i>Profile
                            </a>
                            <a href="{{ route('profile.addresses.index') }}"
                                class="nav-link block px-4 py-2 rounded-md font-medium text-base {{ request()->routeIs('profile.addresses.*') ? 'nav-link-active bg-primary-100' : 'hover:bg-neutral-50' }}">
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
            <main class="col-span-1 lg:col-span-3 space-y-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">My Addresses</h2>
                    <x-ui.button :href="route('profile.addresses.create')" variant="primary" size="sm">
                        <i class="fas fa-plus mr-2"></i>Add New Address
                    </x-ui.button>
                </div>

                <div class="space-y-4">
                    @forelse ($userAddresses as $userAddress)
                        <div class="card card-body">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <h4 class="font-bold text-lg">{{ $userAddress->label }}</h4>
                                        @if ($userAddress->is_primary)
                                            <span class="badge badge-primary">Primary</span>
                                        @endif
                                    </div>
                                    <address class="not-italic text-neutral-600">
                                        {{ $userAddress->address_line_1 }}<br>
                                        @if ($userAddress->address_line_2)
                                            {{ $userAddress->address_line_2 }}<br>
                                        @endif
                                        {{ $userAddress->subdistrict }}, {{ $userAddress->district }}<br>
                                        {{ $userAddress->city }}, {{ $userAddress->province }}
                                        {{ $userAddress->postal_code }}<br>
                                        {{ $userAddress->country }}
                                    </address>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    <x-ui.button size="sm" variant="outline" :href="route('profile.addresses.edit', $userAddress)">Edit</x-ui.button>
                                    <form action="{{ route('profile.addresses.destroy', $userAddress) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this address?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.button type="submit" size="sm" variant="danger">Delete</x-ui.button>
                                    </form>
                                </div>
                            </div>
                            @if (!$userAddress->is_primary)
                                <div class="border-t pt-3 mt-3">
                                    <form action="{{ route('profile.addresses.setPrimary', $userAddress) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="text-sm font-medium text-primary-600 hover:underline">Set as
                                            primary</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12 card">
                            <i class="fas fa-map-marker-alt fa-3x text-neutral-300 mb-4"></i>
                            <h3 class="text-xl font-semibold">No Addresses Found</h3>
                            <p class="mt-2 text-neutral-500">You haven't added any userAddresses yet.</p>
                        </div>
                    @endforelse
                </div>
            </main>
        </div>
    </div>
</x-user-layout>
