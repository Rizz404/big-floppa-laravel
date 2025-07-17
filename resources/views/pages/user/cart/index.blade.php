<x-user-layout title="My Cart">
    <div class="container-wide py-12">
        @if ($cartItems->isNotEmpty())
            <form method="POST" action="{{ route('cart.destroy') }}" x-ref="deleteForm" @submit.prevent="confirmDelete"
                x-data="{
                    selectedItems: [],
                    items: {{ $cartItems->pluck('id') }},
                    itemsWithPrices: {{ $cartItems->mapWithKeys(function ($item) {
                        return [$item->id => $item->listing->price];
                    }) }},
                    // Method baru untuk handle checkout
                    async goToCheckout() {
                        if (this.selectedItems.length === 0) {
                            Swal.fire('No Items Selected', 'Please select items to checkout.', 'warning');
                            return;
                        }
                
                        const button = this.$refs.checkoutButton;
                        const originalButtonHtml = button.innerHTML;
                        button.disabled = true;
                        button.innerHTML = `<span class='loading-spinner mr-2'></span> Preparing...`;
                
                        try {
                            const response = await fetch('{{ route('orders.prepare') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ selectedItems: this.selectedItems })
                            });
                
                            const data = await response.json();
                
                            if (response.ok && data.redirect_url) {
                                window.location.href = data.redirect_url;
                            } else {
                                throw new Error(data.message || 'Failed to prepare checkout.');
                            }
                        } catch (error) {
                            Swal.fire('Error', error.message, 'error');
                            button.disabled = false;
                            button.innerHTML = originalButtonHtml;
                        }
                    },
                    itemsWithImages: {{ $cartItems->mapWithKeys(function ($item) {
                        $imagePath = $item->listing->primaryPhoto?->path ?? 'https://placekitten.com/200/200';
                        return [$item->id => asset($imagePath)];
                    }) }},
                    get isAllSelected() {
                        return this.items.length > 0 && this.selectedItems.length === this.items.length;
                    },
                    toggleAll() {
                        if (this.isAllSelected) {
                            this.selectedItems = [];
                        } else {
                            this.selectedItems = [...this.items];
                        }
                    },
                    get selectedTotal() {
                        return this.selectedItems.reduce((total, id) => {
                            return total + (Number(this.itemsWithPrices[id]) || 0);
                        }, 0);
                    },
                    formatCurrency(value) {
                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
                    },
                
                    confirmDelete() {
                        if (this.selectedItems.length === 0) {
                            return;
                        }
                        const imagesHtml = this.selectedItems.map(id => {
                            const imageUrl = this.itemsWithImages[id];
                            return `<img src='${imageUrl}' class='w-16 h-16 object-cover rounded-md border-2 border-neutral-200'>`;
                        }).join('');
                        const imagesContainerHtml = `<div class='flex justify-center gap-2 flex-wrap my-4'>${imagesHtml}</div>`;
                        Swal.fire({
                            title: 'Are you sure?',
                            html: `You are about to remove ${this.selectedItems.length} item(s) from your cart.` + imagesContainerHtml,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete them!',
                            cancelButtonText: 'Cancel',
                            customClass: {
                                confirmButton: 'btn btn-danger',
                                cancelButton: 'btn btn-ghost'
                            },
                            buttonsStyling: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.$refs.deleteForm.submit();
                            }
                        })
                    }
                }">

                @csrf
                @method('DELETE')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                    <div class="lg:col-span-2">
                        <div class="card mb-4">
                            <div class="card-body flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <input type="checkbox" class="form-checkbox" @click="toggleAll()"
                                        :checked="isAllSelected">
                                    <label class="form-label !mb-0">Select All</label>
                                </div>
                                <x-ui.button type="submit" variant="danger" size="sm"
                                    x-bind:disabled="selectedItems.length === 0">
                                    <i class="fas fa-trash-alt mr-2"></i>
                                    Delete Selected (<span x-text="selectedItems.length"></span>)
                                </x-ui.button>
                            </div>
                        </div>

                        {{-- Sisanya tidak perlu diubah --}}
                        <div class="space-y-4">
                            @foreach ($cartItems as $item)
                                <div class="card card-body flex flex-col sm:flex-row items-start sm:items-center gap-4 transition-all"
                                    :class="{
                                        'bg-primary-100 border-primary-500': selectedItems.includes(
                                            '{{ $item->id }}')
                                    }">
                                    <input type="checkbox" class="form-checkbox flex-shrink-0" name="item_ids[]"
                                        value="{{ $item->id }}" x-model="selectedItems">
                                    <img src="{{ $item->listing->primaryPhoto?->path ?? 'https://placekitten.com/200/200' }}"
                                        alt="{{ $item->listing->title }}"
                                        class="w-24 h-24 object-cover rounded-md flex-shrink-0">
                                    <div class="flex-grow">
                                        <a href="{{ route('cats.show', $item->listing) }}"
                                            class="text-lg font-bold hover:text-primary-600">{{ $item->listing->title }}</a>
                                        <p class="text-neutral-500">{{ $item->listing->breed->name }}</p>
                                        <p class="text-sm text-neutral-500">{{ $item->listing->location }}</p>
                                    </div>
                                    <div class="font-semibold text-lg sm:ml-auto">
                                        Rp {{ number_format($item->listing->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $cartItems->links() }}
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="card sticky top-24">
                            <div class="card-header">
                                <h3 class="text-lg font-semibold">Order Summary</h3>
                            </div>
                            <div class="card-body space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-neutral-600">Subtotal (<span x-text="selectedItems.length"></span>
                                        items)</span>
                                    <span class="font-medium" x-text="formatCurrency(selectedTotal)"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-neutral-600">Shipping</span>
                                    <span class="text-sm text-neutral-500">Calculated later</span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-lg font-semibold">Total</span>
                                    <span class="text-xl font-bold text-primary-600"
                                        x-text="formatCurrency(selectedTotal)"></span>
                                </div>
                                <button type="button" class="btn btn-primary w-full"
                                    x-bind:disabled="selectedItems.length === 0" @click="goToCheckout()"
                                    x-ref="checkoutButton">
                                    Proceed to Checkout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <div class="text-center py-16 card">
                <i class="fas fa-shopping-cart fa-3x text-neutral-300 mb-4"></i>
                <h3 class="text-xl font-semibold">Your Cart is Empty</h3>
                <p class="mt-2 text-neutral-500">Looks like you haven't added any cats to your cart yet.</p>
                <x-ui.button :href="route('cats.index')" variant="primary" class="mt-6">
                    Browse Cats
                </x-ui.button>
            </div>
        @endif
    </div>
</x-user-layout>
