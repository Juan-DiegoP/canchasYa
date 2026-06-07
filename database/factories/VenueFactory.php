<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VenueFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->company() . ' Sports',
            'address'     => $this->faker->streetAddress(),
            'city'        => $this->faker->randomElement(['Medellín', 'Bogotá', 'Cali', 'Envigado', 'Bello']),
            'description' => $this->faker->paragraph(),
            'phone'       => $this->faker->numerify('60########'),
            'active'      => true,
        ];
    }
}