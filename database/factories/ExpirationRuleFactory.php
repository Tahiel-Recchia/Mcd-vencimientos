<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExpirationRule>
 */
class ExpirationRuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "product_id" => Product::factory(),
            "location" =>  $this->faker->unique()->word,
            "duration_minutes" =>  $this->faker->numberBetween(1,60),
            "defrosting" =>  0,
            "defrosting_time" =>  0,
        ];
    }
}
