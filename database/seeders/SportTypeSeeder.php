<?php

namespace Database\Seeders;

use App\Models\SportType;
use Illuminate\Database\Seeder;

class SportTypeSeeder extends Seeder
{
    public function run(): void
    {
        $sports = [
            ['name' => 'Fútbol',      'icon' => '⚽'],
            ['name' => 'Baloncesto',  'icon' => '🏀'],
            ['name' => 'Tenis',       'icon' => '🎾'],
            ['name' => 'Voleibol',    'icon' => '🏐'],
            ['name' => 'Pádel',       'icon' => '🏓'],
        ];

        foreach ($sports as $sport) {
            SportType::create($sport);
        }
    }
}