<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Predjela i salate (category_id = 1)
            ['name' => 'Salata sa algama', 'description' => 'alge, povrće, beli luk, začini', 'price' => 320, 'category_id' => 1, 'image_path' => 'assets/salata_sa_algama.JPG'],
            ['name' => 'Salata sa nudlama', 'description' => 'pirinčane nudle, povrće, začini', 'price' => 320, 'category_id' => 1, 'image_path' => 'assets/salata_sa_nudlama.JPG'],
            ['name' => 'Salata sa susamom', 'description' => 'susam, povrće, kukuruz, začini', 'price' => 320, 'category_id' => 1, 'image_path' => 'assets/salata_susam.JPG'],
            ['name' => 'Rolnice sa mesom i povrćem', 'description' => '', 'price' => 300, 'category_id' => 1, 'image_path' => 'assets/rolnice_meso.JPG'],
            ['name' => 'Rolnice sa povrćem', 'description' => '', 'price' => 270, 'category_id' => 1, 'image_path' => 'assets/rolnice_povrce.JPG'],
            ['name' => 'Cips od škampa', 'description' => '', 'price' => 200, 'category_id' => 1, 'image_path' => 'assets/cips.jpg'],

            // Supe (category_id = 2)
            ['name' => 'Tomato supa', 'description' => '', 'price' => 300, 'category_id' => 2, 'image_path' => 'assets/tomato_supa.JPG'],
            ['name' => 'Kiselo ljuta supa', 'description' => '', 'price' => 300, 'category_id' => 2, 'image_path' => 'assets/kiselo_ljuta_supa.JPG'],

            // Morski plodovi (category_id = 3)
            ['name' => 'Pohovani riblji file', 'description' => '', 'price' => 1000, 'category_id' => 3, 'image_path' => ''],
            ['name' => 'Pohovane lignje', 'description' => '', 'price' => 1100, 'category_id' => 3, 'image_path' => ''],

            // Jela bez mesa (category_id = 4)
            ['name' => 'Tofu sir', 'description' => '', 'price' => 300, 'category_id' => 4, 'image_path' => ''],
            ['name' => 'Mesano povrće', 'description' => 'povrće, paprika, kineske pečurke, šampinjoni, sos po želji', 'price' => 750, 'category_id' => 4, 'image_path' => 'assets/mesano_povrce.JPG'],
            ['name' => 'Prženi rezanci', 'description' => '', 'price' => 250, 'category_id' => 4, 'image_path' => ''],
            ['name' => 'Pirinčane nudle', 'description' => '', 'price' => 250, 'category_id' => 4, 'image_path' => ''],

            // Pirinač i nudle (category_id = 5)
            ['name' => 'Beli pirinac', 'description' => '', 'price' => 200, 'category_id' => 5, 'image_path' => 'assets/beli_pirinac.JPG'],
            ['name' => 'Kari pirinac', 'description' => '', 'price' => 250, 'category_id' => 5, 'image_path' => 'assets/kari_pirinac.JPG'],
            ['name' => 'Sareni pirinac', 'description' => 'jaja i povrće', 'price' => 300, 'category_id' => 5, 'image_path' => 'assets/sareni_pirinac.JPG'],
            ['name' => 'Pirinac sa jajima', 'description' => '', 'price' => 200, 'category_id' => 5, 'image_path' => 'assets/jaje_pirinac.JPG'],
            ['name' => 'Pirinac-Meso-Povrće', 'description' => '', 'price' => 450, 'category_id' => 5, 'image_path' => 'assets/pmp.JPG'],

            // Dezerti (category_id = 6)
            ['name' => 'Pohovani ananas', 'description' => '', 'price' => 300, 'category_id' => 6, 'image_path' => 'assets/poh_ananas.JPG'],
            ['name' => 'Pohovana banana', 'description' => '', 'price' => 300, 'category_id' => 6, 'image_path' => 'assets/poh_banana.JPG'],
            ['name' => 'Pohovana cokolada', 'description' => '', 'price' => 350, 'category_id' => 6, 'image_path' => 'assets/poh_cokolada.JPG'],
            ['name' => 'Pohovana jabuka', 'description' => '', 'price' => 300, 'category_id' => 6, 'image_path' => 'assets/poh_jabuka.JPG'],

            // Jela sa mesom (category_id = 7)
            ['name' => 'Bambus-Kineske Pecurke', 'description' => 'povrće, šampinjoni, bambus, kineske pečurke, sos', 'price' => 750, 'category_id' => 7, 'image_path' => 'assets/bambus_kin_pecurke.JPG'],
            ['name' => 'Meso u kari sosu', 'description' => 'Povrće, sos', 'price' => 700, 'category_id' => 7, 'image_path' => 'assets/kari_sos.JPG'],
            ['name' => 'Meso u kiselo ljutom sosu', 'description' => 'Povrće, sos', 'price' => 700, 'category_id' => 7, 'image_path' => 'assets/kiselo_ljuti.JPG'],
            ['name' => 'Kraljevska Piletina', 'description' => 'Kupus na dnu, susam piletina, ananas, tomato sos', 'price' => 800, 'category_id' => 7, 'image_path' => 'assets/kralj.JPG'],
            ['name' => 'Kung pao piletina', 'description' => 'krastavac, paprika, krompir, šargarepa, kikiriki, tomato sos', 'price' => 850, 'category_id' => 7, 'image_path' => 'assets/kung_pao.JPG'],
            ['name' => 'Meso u ostriga sosu', 'description' => 'Kupus na dnu, meso, sos', 'price' => 700, 'category_id' => 7, 'image_path' => 'assets/ostriga_sos.JPG'],
            ['name' => 'Meso sa paprikom u peking sosu', 'description' => 'paprika, šampinjoni, šargarepa, sos', 'price' => 750, 'category_id' => 7, 'image_path' => 'assets/paprika_peking.JPG'],
            ['name' => 'Meso sa prazilukom u peking sosu', 'description' => 'praziluk, šampinjoni, šargarepa, sos', 'price' => 750, 'category_id' => 7, 'image_path' => 'assets/praziluk_peking.JPG'],
            ['name' => 'Meso sa kikirikijem', 'description' => 'povrće, kikiriki, sos', 'price' => 700, 'category_id' => 7, 'image_path' => 'assets/sa_kikirikijem.JPG'],
            ['name' => 'Meso sa bademom', 'description' => 'povrće, badem, sos', 'price' => 750, 'category_id' => 7, 'image_path' => 'assets/sa_bademom.JPG'],
            ['name' => 'Meso sa indijskim orahom', 'description' => 'povrće, indijski orah, sos', 'price' => 750, 'category_id' => 7, 'image_path' => 'assets/sa_indijskim_orahom.JPG'],
            ['name' => 'Meso sa nudlama', 'description' => 'povrće, šampinjoni, nudle, sos', 'price' => 750, 'category_id' => 7, 'image_path' => 'assets/sa_nudlama.JPG'],
            ['name' => 'Meso sa sampinjonima', 'description' => 'povrće, šampinjoni, sos', 'price' => 700, 'category_id' => 7, 'image_path' => 'assets/sa_sampinjonima.JPG'],
            ['name' => 'Meso sa sitaki pecurkama', 'description' => 'povrće, šitaki pečurke, sos', 'price' => 750, 'category_id' => 7, 'image_path' => 'assets/sitaki.JPG'],
            ['name' => 'Susam piletina', 'description' => 'povrće, šampinjoni, sos po želji', 'price' => 750, 'category_id' => 7, 'image_path' => 'assets/susam_pile.JPG'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
