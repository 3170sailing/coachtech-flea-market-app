<?php

namespace Database\Factories;

use App\Models\Condition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'condition_id' => Condition::factory(),
            'name' => $this->faker->word(),
            'brand' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(100, 100000),
            'image' => 'items/test.png',
        ];
    }
}