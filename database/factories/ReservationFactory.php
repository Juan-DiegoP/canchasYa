<?php

namespace Database\Factories;

use App\Models\Field;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    public function definition(): array
    {
        $start = $this->faker->numberBetween(6, 20);
        $end   = $start + $this->faker->numberBetween(1, 3);

        return [
            'field_id'    => Field::factory(),
            'user_id'     => User::factory(),
            'status'      => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'date'        => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'start_time'  => str_pad($start, 2, '0', STR_PAD_LEFT) . ':00',
            'end_time'    => str_pad($end, 2, '0', STR_PAD_LEFT) . ':00',
            'total_price' => $this->faker->randomElement([40000, 80000, 120000, 160000]),
            'notes'       => $this->faker->optional()->sentence(),
        ];
    }
}