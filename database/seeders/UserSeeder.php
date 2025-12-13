<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.rs',
            'password' => bcrypt('admin'),
            'telefon' => '0640531932',
            'adresa' => 'Breza 8',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Editor User',
            'email' => 'editor@gmail.rs',
            'password' => bcrypt('editor'),
            'telefon' => '0652345678',
            'adresa' => 'Ulica Jovana 2, Novi Sad',
            'role' => 'editor',
        ]);

        User::create([
            'name' => 'Marko Kitic',
            'email' => 'markokitic@gmail.rs',
            'password' => bcrypt('user'),
            'telefon' => '0653456789',
            'adresa' => 'Ulica Petra 3, Niš',
            'role' => 'user',
        ]);
    }
}
