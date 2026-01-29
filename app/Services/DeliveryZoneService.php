<?php

namespace App\Services;

class DeliveryZoneService
{
    protected $zones;

    public function __construct()
    {
        // Učitavamo zone iz config fajla
        $this->zones = config('delivery_zones');
    }

    /**
     * Odredi zonu dostave na osnovu koordinata korisnika
     *
     * @param float $lat
     * @param float $lng
     * @return array|null  ['name' => ..., 'price' => ...] ili null ako nije u zoni
     */
    public function getZoneForCoordinates($lat, $lng)
    {
        foreach ($this->zones as $zone) {
            $distance = $this->calculateDistance(
                $lat,
                $lng,
                $zone['center'][0],
                $zone['center'][1]
            );

            if ($distance <= $zone['radius']) {
                return [
                    'name' => $zone['name'],
                    'price' => $zone['price']
                ];
            }
        }

        // Nije u nijednoj zoni
        return null;
    }

    /**
     * Calculate distance between two coordinates in meters
     */
    protected function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371000; // metara

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lng2 - $lng1);

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        $distance = $earthRadius * $c;

        return $distance;
    }
}
