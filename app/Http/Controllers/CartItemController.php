<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart; // Import the Cart model
use App\Models\CartItem; // Import the CartItem model

class CartItemController extends Controller
{
    public function store(Request $request)
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id()],
            ['session_id' => session()->getId()]
        );

        $cartItem = CartItem::updateOrCreate(
            [
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
            ],
            [
                'quantity' => \DB::raw('quantity + ' . $request->quantity),
            ]
        );

        return response()->json(['message' => 'Item added to cart successfully!', 'cartItem' => $cartItem]);
    }

    public function update(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return response()->json(['message' => 'Cart item updated successfully!', 'cartItem' => $cartItem]);
    }

    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);

        $cartItem->delete();

        return response()->json(['message' => 'Cart item removed successfully!']);
    }
}
