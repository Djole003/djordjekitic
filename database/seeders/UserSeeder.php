<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@pwa.rs',
            'password' => bcrypt('admin'), // Koristi bcrypt za šifrovanje lozinke
            'role' => 'admin', // Postavljanje role za admina
        ]);

        // Kreiranje editor korisnika
        User::create([
            'name' => 'Editor User',
            'email' => 'editor@pwa.rs',
            'password' => bcrypt('editor'), 
            'role' => 'editor', // Postavljanje role za editor
        ]);

        // Kreiranje običnog korisnika
        User::create([
            'name' => 'Regular User',
            'email' => 'user@pwa.rs',
            'password' => bcrypt('user'), 
            'role' => 'user', // Postavljanje role za običnog korisnika
        ]);
    }
}
