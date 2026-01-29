<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\RadnoVreme;
use Illuminate\Support\Facades\DB;

class RestaurantStatusService
{
    public static function isOpen(): bool
    {
        $restaurantId = session('restaurant_id');

        // Ako nema izabranog lokala → NE MOŽE PORUDŽBINA
        if (!$restaurantId) {
            return false;
        }

        /**
         * 1️⃣ RUČNI STATUS (admin / editor)
         */
        $globalStatus = DB::table('restaurant_status')
            ->where('restaurant_id', $restaurantId)
            ->value('is_open');

        // Ako nema reda → podrazumevano OTVOREN
        if ($globalStatus === null) {
            $globalStatus = 1;
        }

        if (!$globalStatus) {
            return false;
        }

        /**
         * 2️⃣ RADNO VREME
         */
        $now = Carbon::now('Europe/Belgrade');
        $dan = $now->dayOfWeek; // 0–6
        $vreme = $now->format('H:i:s');

        return RadnoVreme::where('restaurant_id', $restaurantId)
            ->where('dan', $dan)
            ->where('otvara_se', '<=', $vreme)
            ->where('zatvara_se', '>=', $vreme)
            ->exists();
    }
}
