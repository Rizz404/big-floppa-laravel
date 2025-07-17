<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyCartRequest;
use App\Http\Requests\StoreCartRequest;
use App\Models\CartItem;
use Illuminate\Http\HttpCartRequest;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cartItems = CartItem::where('cart_id', $user->cart->id)
            ->with('listing.primaryPhoto', 'listing.breed')
            ->latest()
            ->paginate(10);

        return view('pages.user.cart.index', compact('cartItems'));
    }

    public function store(StoreCartRequest $request)
    {
        $validated = $request->validated();

        $cart = Auth::user()->cart;

        CartItem::firstOrCreate(
            [
                'cart_id' => $cart->id,
                'listing_id' => $validated['listing_id'],
            ]
        );

        // * Hapus cache agar dihitung ulang pada request berikutnya
        $cart->forgetItemsCountCache();

        toast("Cat added to your cart!", "success");
        return back()->with('success', 'Cat added to your cart!');
    }

    public function destroy(DestroyCartRequest $request)
    {
        $validated = $request->validated();

        $cart = Auth::user()->cart;

        $deletedCount = CartItem::whereIn('id', $validated['item_ids'])
            ->where('cart_id', Auth::user()->cart->id)
            ->delete();

        if ($deletedCount > 0) {
            // * Hapus cache karena ada item yang dihapus
            $cart->forgetItemsCountCache();
        }

        if ($deletedCount === 0) {
            return back()->with('error', 'No items were deleted. Please try again.');
        }

        toast($deletedCount . ' item(s) removed from your cart.', "success");
        return back()->with('success', $deletedCount . ' item(s) removed from your cart.');
    }
}
