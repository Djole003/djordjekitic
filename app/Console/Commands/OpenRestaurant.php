<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OpenRestaurant extends Command
{
    protected $signature = 'restaurant:open';
    protected $description = 'Otvara restoran (cron / admin)';

    public function handle()
    {
        DB::table('restaurant_status')->update([
            'is_open' => true,
            'updated_at' => now(),
        ]);

        $this->info('✅ Restoran je OTVOREN');
        return 0;
    }
}
