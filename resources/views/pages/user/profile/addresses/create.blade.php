<x-user-layout title="Add New Address">
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
                    <div class="card-body grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <x-ui.input name="label" label="Address Label" placeholder="e.g., Home, Office"
                                required />
                        </div>
                        <x-ui.input name="country" label="Country" value="Indonesia" required />
                        <x-ui.input name="province" label="Province" required />
                        <x-ui.input name="city" label="City / Regency" required />
                        <x-ui.input name="district" label="District (Kecamatan)" required />
                        <x-ui.input name="subdistrict" label="Sub-district (Kelurahan)" required />
                        <x-ui.input name="postal_code" label="Postal Code" required />
                        <div class="md:col-span-2">
                            <x-ui.input name="address_line_1" label="Address Line 1" required />
                        </div>
                        <div class="md:col-span-2">
                            <x-ui.input name="address_line_2" label="Address Line 2 (Optional)" />
                        </div>
                        <div class="md:col-span-2">
                            <x-ui.checkbox name="is_primary" label="Set as primary address" value="1" />
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
