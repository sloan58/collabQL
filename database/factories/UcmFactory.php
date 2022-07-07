<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ucm>
 */
class UcmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => implode(' ', $this->faker->words(2)),
            'ipAddress' => $this->faker->localIpv4(),
            'username' => 'Administrator',
            'password' => $this->faker->password(),
            'version' => $this->faker->randomElement(['14.0', '12.5', '11.5']),
        ];
    }
}
