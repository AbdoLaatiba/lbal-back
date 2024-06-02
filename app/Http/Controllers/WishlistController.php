<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(): JsonResponse
    {
        $wishlist = Wishlist::where('user_id', auth()->id())->with(['product', 'product.images', 'product.images.media'])->get();
        return response()->json($wishlist);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlist = Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        return response()->json($wishlist);
    }

    public function destroy($id): JsonResponse
    {
        $wishlist = Wishlist::where('user_id', auth()->id())->where('product_id', $id)->first();
        if (!$wishlist){
            return response()->json([
                'message' => 'Product not found in wishlist',
            ], 404);
        }
        $wishlist->delete();

        return response()->json([
            'message' => 'Product removed from wishlist',
        ]);
    }

    public function clear(): JsonResponse
    {
        $wishlist = Wishlist::where('user_id', auth()->id())->delete();

        return response()->json([
            'message' => 'Wishlist cleared',
        ]);
    }
}
