<x-user-layout :title="'Order Details ' . $order->id">
    <div class="container-wide py-12">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('orders.index') }}" class="btn btn-ghost !px-3"><i class="fas fa-arrow-left"></i></a>
            <div>
                <h1 class="text-3xl font-bold">Order Details</h1>
                <p class="text-neutral-500 font-mono">{{ $order->id }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <div class="lg:col-span-2 space-y-6">
                {{-- * Order Items --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Items Ordered ({{ $order->items->count() }})</h3>
                    </div>
                    <div class="card-body divide-y">
                        @foreach ($order->items as $item)
                            <div class="flex items-center gap-4 py-3">
                                <img src="{{ $item->listing->primaryPhoto?->path ?? 'https://placekitten.com/200/200' }}"
                                    alt="{{ $item->listing->title }}"
                                    class="w-16 h-16 object-cover rounded-md flex-shrink-0">
                                <div class="flex-grow">
                                    <p class="font-bold">{{ $item->listing->title }}</p>
                                    <p class="text-sm text-neutral-500">1 item</p>
                                </div>
                                <div class="font-semibold">Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- * Payment Details --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Payment Details</h3>
                    </div>
                    <div class="card-body">
                        <dl class="grid grid-cols-2 gap-x-4 gap-y-2">
                            <dt class="text-neutral-500">Payment Method</dt>
                            <dd class="font-medium text-right">
                                {{ Str::title(str_replace('_', ' ', $order->payment->payment_method)) }}</dd>
                            <dt class="text-neutral-500">Payment Status</dt>
                            <dd class="font-medium text-right">{{ Str::title($order->payment->status) }}</dd>
                            <dt class="text-neutral-500">Transaction ID</dt>
                            <dd class="font-mono text-sm text-right">
                                {{ $order->payment->external_transaction_id ?? '-' }}</dd>
                            <dt class="text-neutral-500">Paid At</dt>
                            <dd class="font-medium text-right">
                                {{ $order->payment->paid_at ? $order->payment->paid_at->format('d M Y, H:i') : 'Not paid yet' }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                {{-- * Order Summary --}}
                <div class="card sticky top-24">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Order Summary</h3>
                    </div>
                    <div class="card-body space-y-2">
                        <div class="flex justify-between"><span>Subtotal</span><span class="font-medium">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</span></div>
                        <div class="flex justify-between"><span>Shipping</span><span class="font-medium">Rp
                                {{ number_format($order->shipping_cost, 0, ',', '.') }}</span></div>
                        <hr class="my-2">
                        <div class="flex justify-between text-lg font-bold"><span>Total</span><span
                                class="text-primary-600">Rp
                                {{ number_format($order->total_amount + $order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @if ($order->status == 'pending_payment')
                        <div class="card-footer">
                            <x-ui.button type="button" variant="primary" class="w-full">Pay Now</x-ui.button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-user-layout>
