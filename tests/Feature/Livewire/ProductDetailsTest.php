<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\ProductDetails;
use App\Models\Product;
use App\Models\Variant;

class ProductDetailsTest extends TestCase
{
    public function test_component_exists_on_the_page()
    {
        $product = Product::factory()->create();
 
        $this->get(route('product.details', $product->id))
            ->assertSeeLivewire(ProductDetails::class);
    }
 
    public function test_can_set_current_price()
    {
        $product = Product::factory()->create();
        $variant = Variant::factory()->create(['product_id' => $product->id]);
 
        Livewire::test(ProductDetails::class, ['id' => $product->id])
            ->call('priceWithVariant', $variant->price_difference)
            ->assertSet('current_price', $product->price + $variant->price_difference);
    }
 }
