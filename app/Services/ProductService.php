<?php

namespace App\Services;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductMedia;

class ProductService
{
    protected MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function getProducts($filters = [])
    {
        $products = Product::query()->with(['images', 'images.media']);
        return $this->handleFilters($products, $filters);
    }

    public function handleFilters($products, $filters)
    {
        // filter products
        if(isset($filters['category'])){
            $products = $products->where('category_id', $filters['category']);
        }
        if(isset($filters['brand'])){
            $products = $products->where('brand_id', $filters['brand']);
        }
        if(isset($filters['name'])){
            $products = $products->where('name', 'like', '%'.$filters['name'].'%');
        }
        if (isset($filters['condition'])) {
            $products = $products->where('condition', $filters['condition']);
        }
        if(isset($filters['sold'])){
            $products = $products->where('sold', $filters['sold']);
        }
        if(isset($filters['isApproved'])){
            $products = $products->where('is_approved', $filters['isApproved']);
        }
        if(isset($filters['price-range'])){
            $priceRange = explode('-', $filters['price-range']);
            $products = $products->whereBetween('price', [$priceRange[0], $priceRange[1]]);
        }
        if(isset($filters['sort'])){
            $products = $products->orderBy('price', $filters['sort']);
        }
        // handle the pagination
        if(isset($filters['perPage'])){
            $products = $products->paginate($filters['perPage']);
        }else{
            $products = $products->get();
        }
        return $products;
    }

    public function createProduct($data)
    {
        $product = Product::create($data);

        if (isset($data['images'])) {
            foreach ($data['images'] as $image) {
                ProductMedia::create([
                    'product_id' => $product->id,
                    'media_id' => $image,
                    'is_featured' => $image == $data['images'][0] ? true : false,
                ]);
            }
        }

        return $product;
    }

    public function updateProduct($data, $id)
    {
        return Product::where('id', $id)->update($data);
    }

    public function deleteProduct($id)
    {
        $product =  Product::where('id', $id)->with('images')->first();
        foreach ($product->images as $image) {
            $this->mediaService->deleteMedia($image->media_id);
        }
        return Product::where('id', $id)->delete();
    }

    public function getProduct($id)
    {
        return Product::where('id', $id)->first();
    }

    public function approveProduct($id)
    {
        return Product::where('id', $id)->update(['is_approved' => true]);
    }

    public function disapproveProduct($id)
    {
        return Product::where('id', $id)->update(['is_approved' => false]);
    }

    public function markAsSold($id)
    {
        return Product::where('id', $id)->update(['sold' => true]);
    }

    public function markAsUnsold($id)
    {
        return Product::where('id', $id)->update(['sold' => false]);
    }

    public function getProductsByUser($userId, $filters = [])
    {
        $products = Product::where('user_id', $userId)->get();
        return $this->handleFilters($products, $filters);
    }
}
