<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Bidan Rinawati', 'password' => Hash::make('password')]
        );
        $user->assignRole('super_admin');

        $user = User::firstOrCreate(
            ['email' => 'user@admin.com'],
            ['name' => 'Rosita dewi', 'password' => Hash::make('password')]

            
        );
        $user->assignRole('user');

        $user = User::firstOrCreate(
            ['email' => 'bidan@admin.com'],
            ['name' => 'Bidan Rina Milany', 'password' => Hash::make('password')]

            
        );
        $user->assignRole('bidan');
    }
}
