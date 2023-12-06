<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Variant;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Requests\VariantRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->all());
        if ($request->has('variants')) {
            foreach ($request->variants as $variant) {
                $variantRequest = new VariantRequest($variant);
                $this->validate($variantRequest, [ 
                     'name' => ['required', 'max:150'],
                     'price_difference'  => ['required', 'numeric'],
                    ]);
                $newVariant = new Variant;
                $newVariant->name = $variant['name'];
                $newVariant->price_difference = $variant['price_difference'];
                $product->variants()->save($newVariant);
            }
        }
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::where('id', $id)->first();
        if (!$product) {
            return $this->return_not_found();
        }
        
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::where('id', $id)->first();
        if (!$product) {
            return $this->return_not_found();
        }

        $product->update($request->all());
        
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::where('id', $id)->first();
        if (!$product) {
            return $this->return_not_found();
        }

        $product->variants()->delete();
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
