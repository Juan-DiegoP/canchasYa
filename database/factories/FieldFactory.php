<?php

namespace Database\Factories;

use App\Models\SportType;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

class FieldFactory extends Factory
{
    public function definition(): array
    {
        return [
            'venue_id'       => Venue::factory(),
            'sport_type_id'  => SportType::factory(),
            'name'           => 'Cancha ' . $this->faker->numberBetween(1, 20),
            'description'    => $this->faker->sentence(),
            'price_per_hour' => $this->faker->randomElement([40000, 50000, 60000, 80000, 100000]),
            'capacity'       => $this->faker->randomElement([4, 6, 10, 12, 22]),
            'surface'        => $this->faker->randomElement(['grass', 'synthetic', 'cement']),
            'active'         => true,
        ];
    }
}