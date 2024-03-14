<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'state' => rand(0,1),
            'project_id' => rand(1,9),
            'user_id' => rand(1,11),
            'deadline' =>  $this->faker->dateTimeBetween('now', '+1 year'),
            'created_at' =>  Carbon::now()->subDay(),
        ];
    }
}
