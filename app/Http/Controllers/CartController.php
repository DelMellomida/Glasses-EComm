<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Helpers\EventLogger;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductImage;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['session_id' => session()->getId()]
        );

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Increment the quantity if the product already exists in the cart
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Create a new cart item if it doesn't exist
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        EventLogger::log('Cart Update', 'Item added to cart', [
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json(['message' => 'Item added to cart successfully!', 'cartItem' => $cartItem]);
    }

    public function showCart()
    {
        $cart = Cart::with('items.product')
            ->where('user_id', Auth::id())
            ->orWhere('session_id', session()->getId())
            ->first();

        $productImages = collect(); // default empty collection

        if ($cart && $cart->items && $cart->items->count()) {
            $productImages = ProductImage::whereIn('product_id', $cart->items->pluck('product.product_id'))->get();
        }

        return view('cart.cart-home', compact('cart', 'productImages'));
    }

    
}
