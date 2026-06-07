<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SportTypeFactory extends Factory
{
    public function definition(): array
    {
        $sports = [
            ['name' => 'Fútbol',     'icon' => '⚽'],
            ['name' => 'Baloncesto', 'icon' => '🏀'],
            ['name' => 'Tenis',      'icon' => '🎾'],
            ['name' => 'Voleibol',   'icon' => '🏐'],
            ['name' => 'Pádel',      'icon' => '🏓'],
        ];

        $sport = $this->faker->randomElement($sports);

        return [
            'name' => $sport['name'],
            'icon' => $sport['icon'],
        ];
    }
}