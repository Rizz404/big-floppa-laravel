<x-user-layout title="My Orders">
    <div class="container-wide py-12">
        {{-- * Filter Form --}}
        <div class="card mb-6">
            <form method="GET" action="{{ route('orders.index') }}"
                class="card-body grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 items-center">
                <x-ui.dropdown name="status" label="Order Status" class="col-span-2 md:col-span-2 lg:col-span-2">
                    <option value="">All</option>
                    <option value="pending_payment" @selected(request('status') == 'pending_payment')>Pending Payment</option>
                    <option value="paid" @selected(request('status') == 'paid')>Paid</option>
                    <option value="shipping" @selected(request('status') == 'shipping')>Shipping</option>
                    <option value="completed" @selected(request('status') == 'completed')>Completed</option>
                    <option value="cancelled" @selected(request('status') == 'cancelled')>Cancelled</option>
                </x-ui.dropdown>

                <x-ui.dropdown name="sort_by" label="Sort By" class="col-span-2 md:col-span-2 lg:col-span-2">
                    <option value="created_at" @selected(request('sort_by') == 'created_at')>Order Date</option>
                    <option value="total_amount" @selected(request('sort_by') == 'total_amount')>Total Amount</option>
                    <option value="payment_amount" @selected(request('sort_by') == 'payment_amount')>Paid Amount</option>
                </x-ui.dropdown>

                <x-ui.dropdown name="sort_direction" label="Direction">
                    <option value="desc" @selected(request('sort_direction', 'desc') == 'desc')>Desc</option>
                    <option value="asc" @selected(request('sort_direction') == 'asc')>Asc</option>
                </x-ui.dropdown>

                <x-ui.button type="submit" variant="primary" class="w-full">Filter</x-ui.button>
            </form>
        </div>

        {{-- * Order List --}}
        <div class="space-y-4">
            @forelse ($orders as $order)
                <div class="card">
                    <div class="card-header flex justify-between items-center flex-wrap gap-2">
                        <div>
                            <p class="font-semibold">Order ID: <span
                                    class="text-neutral-600 font-mono">{{ $order->id }}</span></p>
                            <p class="text-sm text-neutral-500">Placed on {{ $order->created_at->format('d M Y') }}</p>
                        </div>
                        <span class="badge badge-primary">{{ Str::title(str_replace('_', ' ', $order->status)) }}</span>
                    </div>
                    <div class="card-body">
                        @foreach ($order->items as $item)
                            <div class="flex items-center gap-4 {{ !$loop->last ? 'mb-3' : '' }}">
                                <img src="{{ $item->listing->primaryPhoto?->path ?? 'https://placekitten.com/200/200' }}"
                                    alt="{{ $item->listing->title }}"
                                    class="w-16 h-16 object-cover rounded-md flex-shrink-0">
                                <div class="flex-grow">
                                    <p class="font-bold">{{ $item->listing->title }}</p>
                                    <p class="text-sm text-neutral-500">Rp
                                        {{ number_format($item->price_at_purchase, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer flex justify-between items-center">
                        <span class="font-semibold">Total: <span class="text-primary-600">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</span></span>
                        <x-ui.button :href="route('orders.show', $order)" variant="outline" size="sm">View Details</x-ui.button>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 card">
                    <i class="fas fa-receipt fa-3x text-neutral-300 mb-4"></i>
                    <h3 class="text-xl font-semibold">No Orders Found</h3>
                    <p class="mt-2 text-neutral-500">You haven't placed any orders yet.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $orders->links() }}</div>
    </div>
</x-user-layout>
