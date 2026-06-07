<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        Venue::create([
            'name'        => 'Complejo Deportivo El Poblado',
            'address'     => 'Calle 10 # 43-50',
            'city'        => 'Medellín',
            'description' => 'Complejo deportivo con múltiples canchas en El Poblado.',
            'phone'       => '6042345678',
            'active'      => true,
        ]);

        Venue::create([
            'name'        => 'Canchas La Estrella',
            'address'     => 'Carrera 50 # 30-20',
            'city'        => 'Envigado',
            'description' => 'Canchas sintéticas de última generación.',
            'phone'       => '6049876543',
            'active'      => true,
        ]);
    }
}