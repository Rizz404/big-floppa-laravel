<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('buyer_id', Auth::user()->id)
            ->with('items.listing.primaryPhoto', 'payment')
            ->filter($request->only(['status', 'payment_status', 'payment_method']))
            ->sort($request->sort_by, $request->sort_direction)
            ->paginate(10)
            ->withQueryString();

        return view('pages.user.order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // $this->authorize('view', $order);

        $order->load('items.listing.primaryPhoto', 'payment', 'buyer.primaryAddress');

        return view('pages.user.order.show', compact('order'));
    }

    public function prepareCheckout(Request $request)
    {
        $validated = $request->validate([
            'selectedItems' => ['required', 'array', 'min:1'],
            'selectedItems.*' => ['ulid', 'exists:cart_items,id'],
        ]);

        // * Simpan ID item yang dipilih ke session
        session(['checkout_cart_item_ids' => $validated['selectedItems']]);

        return response()->json([
            'redirect_url' => route('orders.create')
        ]);
    }

    /**
     * Menampilkan halaman konfirmasi checkout.
     */
    public function create(Request $request)
    {
        $user = Auth::user();

        if (!$user->userPrimaryAddress) {
            return redirect()->route('profile.addresses.index')
                ->with('error', 'Please set a primary address before checking out.');
        }

        // * Ambil item dari session yang sudah kita siapkan
        $itemIds = session('checkout_cart_item_ids', []);

        if (empty($itemIds)) {
            return redirect()->route('cart.index')->with('error', 'Your checkout session has expired. Please select items again.');
        }

        $cartItems = $user->cart->items()
            ->whereIn('id', $itemIds)
            ->with('listing.primaryPhoto', 'listing.breed')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Selected items could not be found.');
        }

        // * Hapus session setelah digunakan agar tidak bisa diakses kembali
        $request->session()->forget('checkout_cart_item_ids');

        $subtotal = $cartItems->sum(fn($item) => $item->listing->price);

        return view('pages.user.order.create', [
            'cartItems' => $cartItems,
            'userPrimaryAddress' => $user->userPrimaryAddress,
            'subtotal' => $subtotal,
        ]);
    }

    /**
     * Proses pembuatan order dan pembayaran.
     */
    public function store(StoreOrderRequest $request)
    {
        $user = Auth::user();

        if (!$user->userPrimaryAddress) {
            return response()->json(['message' => 'Primary address is not set.'], 422);
        }

        $cartItemIds = $request->validated()['cart_item_ids'];

        // * Gunakan DB transaction untuk memastikan semua proses berhasil atau tidak sama sekali
        return DB::transaction(function () use ($cartItemIds, $user) {
            $cartItems = CartItem::whereIn('id', $cartItemIds)
                ->where('cart_id', $user->cart->id)
                ->with('listing')
                ->lockForUpdate() // * Kunci baris untuk mencegah race condition
                ->get();

            if ($cartItems->isEmpty() || $cartItems->count() !== count($cartItemIds)) {
                return response()->json(['message' => 'One or more selected items are invalid.'], 404);
            }

            $totalAmount = $cartItems->sum(function ($item) {
                // * Tambahan: Pastikan listing masih ada
                if (!$item->listing) {
                    throw new \Exception("Listing for cart item {$item->id} not found.");
                }
                return $item->listing->price;
            });

            $order = Order::create([
                'buyer_id' => $user->id,
                'total_amount' => $totalAmount,
            ]);

            $orderItemsPayload = $cartItems->map(function ($cartItem) use ($order) {
                return [
                    'order_id' => $order->id,
                    'listing_id' => $cartItem->listing->id,
                    'price_at_purchase' => $cartItem->listing->price,
                ];
            })->all();
            $order->items()->createMany($orderItemsPayload);

            Payment::create([
                'order_id' => $order->id,
                'amount' => $totalAmount,
                'payment_method' => 'midtrans_snap',
            ]);

            // * Hapus item dari keranjang dan bersihkan cache
            CartItem::destroy($cartItemIds);
            $user->cart->forgetItemsCountCache();

            // * Coba dapatkan token Midtrans
            try {
                $midtransItemsPayload = $cartItems->map(fn($item) => [
                    'id' => $item->listing->id,
                    'price' => (int) $item->listing->price,
                    'quantity' => 1,
                    'name' => substr($item->listing->title, 0, 50) // * Midtrans punya batas 50 char
                ])->all();

                $params = [
                    'transaction_details' => ['order_id' => $order->id, 'gross_amount' => (int) $totalAmount],
                    'customer_details' => ['first_name' => $user->name, 'email' => $user->email, 'phone' => $user->userProfile->phone_number],
                    'item_details' => $midtransItemsPayload
                ];

                $snapToken = Snap::getSnapToken($params);
                return response()->json(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                // * Jika Midtrans gagal, kembalikan error spesifik
                DB::rollBack();
                Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
                return response()->json(['message' => 'Failed to connect to payment gateway.', 'error' => $e->getMessage()], 503);
            }
        });
    }
}
