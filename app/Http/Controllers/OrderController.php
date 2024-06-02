<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        $orders = Order::where('user_id', auth()->id())->get();

        return response()->json($orders);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $total = collect($request->items)->sum(fn($item) => $item['price']);

        $order = Order::create([
            'total' => $total,
            'user_id' => auth()->id()
        ]);

        $order->items()->createMany($request->items);

        return response()->json([
            'order' => $order
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:pending,processed,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);

        $order->update($request->only('status'));

        return response()->json([
            'order' => $order
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $order = auth()->user()->orders()->findOrFail($id);

        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully'
        ]);
    }
}
