<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // buat akun admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'role' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // buat akun user
        User::create([
            'name' => 'Rizal',
            'email' => 'rizal@gmail.com',
            'password' => bcrypt('123456'),
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
