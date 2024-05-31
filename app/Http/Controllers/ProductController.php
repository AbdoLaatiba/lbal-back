<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all();
        $products = $this->productService->getProducts($filters);
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $product = $this->productService->createProduct($data);
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $product = $this->productService->updateProduct($data, $product->id);
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        $this->productService->deleteProduct($product->id);
        return response()->json(['message' => 'Product deleted successfully']);
    }

    /**
     * Approve the specified resource.
     */
    public function approve(Product $product): JsonResponse
    {
        $this->productService->approveProduct($product->id);
        return response()->json(['message' => 'Product approved successfully']);
    }

    /**
     * Disapprove the specified resource.
     */
    public function disapprove(Product $product): JsonResponse
    {
        $this->productService->disapproveProduct($product->id);
        return response()->json(['message' => 'Product disapproved successfully']);
    }

    /**
     * Archive the specified resource.
     */
    public function archive(Product $product): JsonResponse
    {
        $this->productService->archiveProduct($product->id);
        return response()->json(['message' => 'Product archived successfully']);
    }
}
