<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Variant;
use App\Models\Product;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'price' => $this->faker->randomFloat(1, 500),
            'stock_quantity' => $this->faker->numberBetween(1, 50)
        ];
    }

    public function withVariants(int $count = 1): self
    {
        return $this->afterCreating(
            function (Product $product) use ($count) {
                Variant::factory()->count($count)->create(['product_id' => $product->id]);
            }
        );
    }
}
