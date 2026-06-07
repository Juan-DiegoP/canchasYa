<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@canchas.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'telefono' => '3001234567',
        ]);

        User::create([
            'name'     => 'Cliente Demo',
            'email'    => 'cliente@canchas.com',
            'password' => Hash::make('password'),
            'role'     => 'customer',
            'telefono' => '3007654321',
        ]);
    }
}