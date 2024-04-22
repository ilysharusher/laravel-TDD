<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->title(10),
            'content' => fake()->text(100),
            'image' => fake()->url()
        ];
    }
}
