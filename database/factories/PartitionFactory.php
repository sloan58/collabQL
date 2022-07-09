<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partition>
 */
class PartitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'pkid' => $this->faker->uuid(),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(4),
        ];
    }
}
