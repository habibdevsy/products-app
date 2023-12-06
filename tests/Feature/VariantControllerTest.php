<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Variant;

class VariantControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testStore()
    {
        $product = Product::factory()->create();
        $data = [
            'name' => 'New Variant',
            'price_difference' => 5.00,
            'product_id' => $product->id,
        ];

        $response = $this->post(route('variants.store'), $data);

        $response->assertStatus(201)
            ->assertJson(['data' => ['name' => 'New Variant']])
            ->assertJsonStructure(['data' => ['id', 'name', 'price_difference']]);
    }

    public function testShow()
    {
        $variant = Variant::factory()->create();

        $response = $this->get(route('variants.show', $variant->id));

        $response->assertStatus(200)
            ->assertJson(['data' => ['id' => $variant->id]])
            ->assertJsonStructure(['data' => ['id', 'name', 'price_difference']]);
    }

    public function testUpdate()
    {
        $product = Product::factory()->create();
        $variant = Variant::factory()->create();
        $updatedData = [
            'name' => 'Updated Variant',
            'price_difference' => 8.00,
            'product_id' => $product->id,
        ];

        $response = $this->put(route('variants.update', $variant->id), $updatedData);

        $response->assertStatus(200)
            ->assertJson(['data' => ['name' => 'Updated Variant']])
            ->assertJsonStructure(['data' => ['id', 'name', 'price_difference']]);
    }

    public function testDestroy()
    {
        $variant = Variant::factory()->create();

        $response = $this->delete(route('variants.destroy', $variant->id));

        $response->assertStatus(200)
            ->assertJson(['message' => 'variant deleted successfully']);

        $this->assertDatabaseMissing('variants', ['id' => $variant->id]);
    }
}