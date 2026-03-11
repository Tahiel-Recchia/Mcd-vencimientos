<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\ExpirationRule;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActiveTimer>
 */
class ActiveTimerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startedAt = now();
        $expiresAt = $startedAt->copy()->addHours(rand(1, 4));

        return [
            'product_id' => Product::factory(),
            'expiration_rule_id' => ExpirationRule::factory(),
            'category_id' => Category::factory(),
            'started_at' => $startedAt,
            'expires_at' => $expiresAt,
            'is_active' => true,
        ];
    }

    public function expired()
    {
        return $this->state(function (array $attributes) {
            return [
                'started_at' => now()->subHours(5),
                'expires_at' => now()->subHours(1),
            ];
        });
    }

    public function minusOneHour(){
        return $this->state(function (array $attributes) {
            return [
                'started_at' => now()->subHours(1)
                ];
        });
    }

    public function inactive()
    {
        return $this->state(fn (array $attributes) => ['is_active' => false]);
    }

    public function customCategory($category){
        return $this->state(fn (array $attributes) => ['category_id' => $category->id]);
    }

    public function customProduct($product){
        return $this->state(fn (array $attributes) => ['product_id' => $product->id]);
    }

    public function eliminated(){
        return $this->state(fn (array $attributes) => ['state' => 'eliminated']);
    }

}
