<x-user-layout title="Checkout">
    <div class="container-wide py-12">
        <h1 class="text-3xl font-bold mb-8">Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            {{-- * Kolom Kiri: Detail Pesanan --}}
            <div class="lg:col-span-2 space-y-4">
                {{-- * Alamat Pengiriman --}}
                <div class="card">
                    <div class="card-header flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Shipping Address</h3>
                        <a href="{{ route('profile.addresses.index') }}" class="text-sm font-medium">Change</a>
                    </div>
                    <div class="card-body">
                        <address class="not-italic text-neutral-600">
                            <strong>{{ $userPrimaryAddress->label }}</strong><br>
                            {{ $userPrimaryAddress->address_line_1 }}<br>
                            {{ $userPrimaryAddress->city }}, {{ $userPrimaryAddress->province }}
                            {{ $userPrimaryAddress->postal_code }}
                        </address>
                    </div>
                </div>

                {{-- * Item Pesanan --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Order Items</h3>
                    </div>
                    <div class="card-body divide-y">
                        @foreach ($cartItems as $item)
                            <div class="flex items-center gap-4 py-3">
                                <img src="{{ $item->listing->primaryPhoto?->path ?? 'https://placekitten.com/200/200' }}"
                                    alt="{{ $item->listing->title }}"
                                    class="w-16 h-16 object-cover rounded-md flex-shrink-0">
                                <div class="flex-grow">
                                    <p class="font-bold">{{ $item->listing->title }}</p>
                                    <p class="text-sm text-neutral-500">1 item</p>
                                </div>
                                <div class="font-semibold">
                                    Rp {{ number_format($item->listing->price, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- * Kolom Kanan: Ringkasan & Tombol Bayar --}}
            <div class="lg:col-span-1">
                <div class="card sticky top-24">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Order Summary</h3>
                    </div>
                    <div class="card-body">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mt-2">
                            <span>Shipping</span>
                            <span class="font-medium">Free</span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-semibold">Total</span>
                            <span class="text-xl font-bold text-primary-600">Rp
                                {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <form id="checkout-form">
                            @foreach ($cartItems->pluck('id') as $itemId)
                                <input type="hidden" name="cart_item_ids[]" value="{{ $itemId }}">
                            @endforeach
                            <input type="hidden" name="address_id" value="{{ $userPrimaryAddress->id }}">

                            <x-ui.button type="submit" variant="primary" class="w-full">
                                Place Order & Pay
                            </x-ui.button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- * Pastikan SweetAlert sudah di-load di layout utama Anda --}}
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <script>
            document.getElementById('checkout-form').addEventListener('submit', async function(event) {
                event.preventDefault();

                const form = this;
                const button = form.querySelector('button[type="submit"]');
                const originalButtonHtml = button.innerHTML;

                // --- UI State: Loading ---
                button.disabled = true;
                button.innerHTML = '<span class="loading-spinner mr-2"></span> Processing...';

                // --- Membangun payload JSON dengan benar ---
                const formData = new FormData(form);
                const payload = {
                    cart_item_ids: formData.getAll('cart_item_ids[]'),
                    address_id: formData.get('address_id')
                };

                try {
                    const response = await fetch('{{ route('orders.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload)
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        // Menangani error validasi dari Laravel (422) atau error server (500)
                        const errorMessage = data.message || 'An error occurred.';
                        let errorList = '';
                        if (data.errors) {
                            errorList = '<ul class="text-left text-sm list-disc list-inside mt-2">';
                            for (const key in data.errors) {
                                errorList += `<li>${data.errors[key][0]}</li>`;
                            }
                            errorList += '</ul>';
                        }

                        Swal.fire({
                            icon: 'error',
                            title: errorMessage,
                            html: errorList,
                        });

                        button.disabled = false;
                        button.innerHTML = originalButtonHtml;
                        return; // Stop eksekusi
                    }

                    if (data.snap_token) {
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                Swal.fire('Payment Success!', 'Thank you for your purchase.', 'success')
                                    .then(() => {
                                        window.location.href = '{{ route('orders.index') }}';
                                    });
                            },
                            onPending: function(result) {
                                Swal.fire('Payment Pending', 'Waiting for your payment.', 'info')
                                    .then(() => {
                                        window.location.href = '{{ route('orders.index') }}';
                                    });
                            },
                            onError: function(result) {
                                Swal.fire('Payment Failed', 'Please try again.', 'error');
                                button.disabled = false;
                                button.innerHTML = originalButtonHtml;
                            },
                            onClose: function() {
                                console.log('Payment popup closed without finishing');
                                button.disabled = false;
                                button.innerHTML = originalButtonHtml;
                            }
                        });
                    } else {
                        throw new Error(data.error || 'Snap token not found.');
                    }

                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Could not process the order. Please try again later.'
                    });
                    button.disabled = false;
                    button.innerHTML = originalButtonHtml;
                }
            });
        </script>
    @endpush
</x-user-layout>
