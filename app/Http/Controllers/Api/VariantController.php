<?php

namespace App\Http\Controllers\Api;

use App\Models\Variant;
use App\Models\Product;
use App\Http\Requests\VariantRequest;
use App\Http\Resources\VariantResource;

class VariantController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(VariantRequest $request)
    {
        $variant = new Variant; 
        $variant->name = $request->name;
        $variant->price_difference = $request->price_difference;
        $product = Product::find($request->product_id);
        $product->variants()->save($variant);
        return new VariantResource($variant);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $variant = Variant::where('id', $id)->first();
        if (!$variant) {
            return $this->return_not_found();
        }
        return new VariantResource($variant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VariantRequest $request, string $id)
    {
        $variant = Variant::where('id', $id)->first();
        if (!$variant) {
            return $this->return_not_found();
        }
        $variant->name = $request->name;
        $variant->price_difference = $request->price_difference;
        $variant->save();
        return new VariantResource($variant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $variant = Variant::where('id', $id)->first();
        if (!$variant) {
            return $this->return_not_found();
        }
        $variant->delete();
        return response()->json(['message' => 'variant deleted successfully'], 200);
    }
}
