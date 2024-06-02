<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(): JsonResponse
    {
        $cart = Cart::where('user_id', auth()->id())->with(['product', 'product.images', 'product.images.media'])->get();
        return response()->json($cart);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id|unique:carts,product_id,NULL,id,user_id,' . auth()->id(),
        ], [
            'product_id.unique' => 'Product already in cart',
        ]);

        $cart = Cart::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ]);
        return response()->json($cart);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();
        $cart->delete();
        return response()->json([
            'message' => 'Product removed from cart',
        ]);
    }

    public function clearCart()
    {
        $cart = Cart::where('user_id', auth()->id())->delete();
        return response()->json([
            'message' => 'Cart cleared',
        ]);
    }

}
