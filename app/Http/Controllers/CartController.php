<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

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
                'quantity' => $request->quantity, // Set the quantity directly
            ]
        );

        return response()->json(['message' => 'Item added to cart successfully!', 'cartItem' => $cartItem]);
    }

    public function showCart()
    {
        $cart = Cart::with('items.product') // Eager load the product relationship
            ->where('user_id', auth()->id())
            ->orWhere('session_id', session()->getId())
            ->first();

        return view('cart.cart-home', compact('cart'));
    }

    
}
