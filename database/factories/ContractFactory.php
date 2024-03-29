<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'       => fake()->jobTitle,
            'author'     => fake()->name,
            'content'    => fake()->randomHtml,
            'created_at' => fake()->dateTimeBetween('-7 days', '+7 days')
        ];
    }
}
