<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Helpers\EventLogger;
use App\Models\Cart;
use App\Models\CartItem;

class CartItemController extends Controller
{
    public function store(Request $request)
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['session_id' => session()->getId()]
        );

        $cartItem = CartItem::updateOrCreate(
            [
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
            ],
            [
                'quantity' => DB::raw('quantity + ' . $request->quantity),
            ]
        );

        EventLogger::log('Cart Item Create', 'Item added to cart', [
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json(['message' => 'Item added to cart successfully!', 'cartItem' => $cartItem]);
    }

    public function update(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        EventLogger::log('Cart Item Update', 'Cart item updated', [
            'cart_item_id' => $cartItem->id,
            'quantity' => $request->quantity,
        ]);

        return response()->json(['message' => 'Cart item updated successfully!', 'cartItem' => $cartItem]);
    }

    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);

        EventLogger::log('Cart Item Delete', 'Cart item removed', [
            'cart_item_id' => $cartItem->id,
        ]);

        $cartItem->delete();

        return response()->json(['message' => 'Cart item removed successfully!']);
    }

    public function increment($id)
    {
        $cartItem = CartItem::findOrFail($id);

        $cartItem->update([
            'quantity' => $cartItem->quantity + 1,
        ]);

        EventLogger::log('Cart Item Increment', 'Cart item quantity incremented', [
            'cart_item_id' => $cartItem->id,
            'quantity' => $cartItem->quantity,
        ]);

        return response()->json(['message' => 'Cart item updated successfully!', 'cartItem' => $cartItem]);
    }

    public function decrement($id)
    {
        $cartItem = CartItem::findOrFail($id);

        if ($cartItem->quantity > 1) {
            $cartItem->update([
                'quantity' => $cartItem->quantity - 1,
            ]);

            EventLogger::log('Cart Item Decrement', 'Cart item quantity decremented', [
                'cart_item_id' => $cartItem->id,
                'quantity' => $cartItem->quantity,
            ]);

            return response()->json(['message' => 'Cart item updated successfully!', 'cartItem' => $cartItem]);
        } else {
            $cartItem->delete();

            EventLogger::log('Cart Item Delete', 'Cart item removed due to zero quantity', [
                'cart_item_id' => $cartItem->id,
            ]);

            return response()->json(['message' => 'Cart item removed successfully!']);
        }
    }
}
