<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            // Kreira jednu praznu narudžbinu po korisniku
            Order::create([
                'user_id' => $user->id,
                'status' => 'Na čekanju',
                'total_price' => 0, // biće izračunata kasnije kada korisnik završi porudžbinu
            ]);
        }
    }
}
