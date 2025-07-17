<x-user-layout title="Edit Address">
    <div class="container-wide py-12">
        <div class="max-w-3xl mx-auto">
            <div class="flex items-center gap-4 mb-6">
                <a href="{{ route('profile.addresses.index') }}" class="btn btn-ghost !px-3"><i
                        class="fas fa-arrow-left"></i></a>
                <h1 class="text-3xl font-bold">Add New Address</h1>
            </div>

            <div class="card">
                <form method="POST" action="{{ route('profile.addresses.store') }}">
                    @csrf
                    @method('PATCH')

                    <div class="card-body grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <x-ui.input name="label" label="Address Label" placeholder="e.g., Home, Office"
                                required />
                        </div>
                        <x-ui.input name="country" label="Country" value="{{ old('country', $address->country) }}"
                            required />
                        <x-ui.input name="province" label="Province" required
                            value="{{ old('province', $address->province) }}" />
                        <x-ui.input name="city" label="City / Regency" required
                            value="{{ old('city', $address->city) }}" />
                        <x-ui.input name="district" label="District (Kecamatan)" required
                            value="{{ old('district', $address->district) }}" />
                        <x-ui.input name="subdistrict" label="Sub-district (Kelurahan)" required
                            value="{{ old('subdistrict', $address->subdistrict) }}" />
                        <x-ui.input name="postal_code" label="Postal Code" required
                            value="{{ old('postal_code', $address->postal_code) }}" />
                        <div class="md:col-span-2">
                            <x-ui.input name="address_line_1" label="Address Line 1" required
                                value="{{ old('address_line_1', $address->address_line_1) }}" />
                        </div>
                        <div class="md:col-span-2">
                            <x-ui.input name="address_line_2" label="Address Line 2 (Optional)"
                                value="{{ old('address_line_2', $address->address_line_2) }}" />
                        </div>
                        <div class="md:col-span-2">
                            <x-ui.checkbox name="is_primary" label="Set as primary address"
                                value="{{ old('is_primary', $address->is_primary) }}" />
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <x-ui.button type="submit" variant="primary">Save Address</x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-user-layout>
