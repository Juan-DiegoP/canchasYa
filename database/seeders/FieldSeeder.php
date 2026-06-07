<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    public function run(): void
    {
        // Venue 1
        Field::create([
            'venue_id'       => 1,
            'sport_type_id'  => 1,
            'name'           => 'Cancha de Fútbol 1',
            'description'    => 'Cancha de fútbol 11 con césped sintético.',
            'price_per_hour' => 80000,
            'capacity'       => 22,
            'surface'        => 'synthetic',
            'active'         => true,
        ]);

        Field::create([
            'venue_id'       => 1,
            'sport_type_id'  => 2,
            'name'           => 'Cancha de Baloncesto',
            'description'    => 'Cancha de baloncesto techada.',
            'price_per_hour' => 50000,
            'capacity'       => 10,
            'surface'        => 'cement',
            'active'         => true,
        ]);

        // Venue 2
        Field::create([
            'venue_id'       => 2,
            'sport_type_id'  => 1,
            'name'           => 'Cancha de Fútbol 5',
            'description'    => 'Cancha de fútbol 5 iluminada.',
            'price_per_hour' => 60000,
            'capacity'       => 10,
            'surface'        => 'synthetic',
            'active'         => true,
        ]);

        Field::create([
            'venue_id'       => 2,
            'sport_type_id'  => 3,
            'name'           => 'Cancha de Tenis',
            'description'    => 'Cancha de tenis profesional.',
            'price_per_hour' => 40000,
            'capacity'       => 4,
            'surface'        => 'cement',
            'active'         => true,
        ]);
    }
}