<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $products = Product::factory(3)->create();

        $response = $this->get(route('products.index'));
        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure(['data' => [['id', 'name', 'price', 'stock_quantity']]]);
    }

    public function testStoreًWithVariants()
    {
        $data = [
            'name' => 'Test Product',
            'price' => 10.99,
            'description' => 'description',
            'stock_quantity' => 50,
            'variants' => [
                ['name' => 'Variant 1', 'price_difference' => 5.00],
                ['name' => 'Variant 2', 'price_difference' => 8.00],
            ],
        ];

        $response = $this->post(route('products.store', $data));
        $response->assertStatus(201)
            ->assertJson(['data' => ['name' => 'Test Product']])
            ->assertJsonStructure(['data' => ['id', 'name', 'price', 'stock_quantity', 'variants']]);
    }

    public function testStoreًWithoutVariants()
    {
        $data = [
            'name' => 'Test Product',
            'price' => 10.99,
            'description' => 'description',
            'stock_quantity' => 50,
        ];

        $response = $this->post(route('products.store', $data));
        $response->assertStatus(201)
            ->assertJson(['data' => ['name' => 'Test Product']])
            ->assertJsonStructure(['data' => ['id', 'name', 'price', 'stock_quantity']]);
    }


    public function testShowWithoutVariants()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.show', $product->id));

        $response->assertStatus(200)
            ->assertJson(['data' => ['id' => $product->id]])
            ->assertJsonStructure(['data' => ['id', 'name', 'price', 'stock_quantity']]);
    }

    public function testShowWithVariants()
    {
        $product = Product::factory()->withVariants()->create();

        $response = $this->get(route('products.show', ['product' => $product->id, 'variants' => 'true']));

        $response->assertStatus(200)
            ->assertJson(['data' => ['id' => $product->id]])
            ->assertJsonStructure(['data' => ['id', 'name', 'price', 'stock_quantity', 'variants']]);
    }

    public function testUpdate()
    {
        $product = Product::factory()->create();
        $updatedData = [
            'name' => 'Updated Product',
            'price' => 10.99,
            'description' => 'description',
            'stock_quantity' => 50
        ];

        $response = $this->put(route('products.update', $product->id), $updatedData);
        $response->assertStatus(200)
            ->assertJson(['data' => [
                  'name' => 'Updated Product',
                  'price' => 10.99,
                  'description' => 'description',
                  'stock_quantity' => 50
                ]])
            ->assertJsonStructure(['data' => ['id', 'name', 'price', 'stock_quantity']]);
    }

    public function testDestroy()
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('products.destroy', $product->id));

        $response->assertStatus(200)
            ->assertJson(['message' => 'Product deleted successfully']);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        $this->assertDatabaseMissing('variants', ['product_id' => $product->id]);
    }
}
