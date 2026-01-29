<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CloseRestaurant extends Command
{
    protected $signature = 'restaurant:close';
    protected $description = 'Zatvara restoran (cron / admin)';

    public function handle()
    {
        DB::table('restaurant_status')->update([
            'is_open' => false,
            'updated_at' => now(),
        ]);

        $this->info('⛔ Restoran je ZATVOREN');
        return 0;
    }
}
