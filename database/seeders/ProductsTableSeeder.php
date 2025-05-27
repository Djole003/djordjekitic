<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Pekinška Patka',
                'description' => 'Ukusno jelo od patke iz Kine.',
                'price' => 1200.00,
                'category' => 'Glavno jelo',
                'image_path' => 'assets/pekinska-patka.jpg',
            ],
            [
                'name' => 'General Tso Piletina',
                'description' => 'Kinesko jelo sa piletinom u sočnom sosu.',
                'price' => 900.00,
                'category' => 'Glavno jelo',
                'image_path' => 'assets/General Tso Chicken.jpg',
            ],
            [
                'name' => 'Dim Sum',
                'description' => 'Kineski specijalitet sa punjenjem od mesa i povrća.',
                'price' => 600.00,
                'category' => 'Dezert',
                'image_path' => 'assets/dim-sum.jpg',
            ],
            [
                'name' => 'Kung Pao Piletina',
                'description' => 'Piletina u ljutom i slatkom sosu sa kikirikijem.',
                'price' => 850.00,
                'category' => 'Glavno jelo',
                'image_path' => 'assets/kung-pao.jpg',
            ],
            [
                'name' => 'Slatko-ljuta Svinjetina',
                'description' => 'Svinjsko meso u slatko-ljutom sosu.',
                'price' => 950.00,
                'category' => 'Glavno jelo',
                'image_path' => 'assets/Sweet and Sour Pork.webp',
            ],
            [
                'name' => 'Cao Mein Nudle',
                'description' => 'Kineski nudli sa povrćem i mesom.',
                'price' => 700.00,
                'category' => 'Glavno jelo',
                'image_path' => 'assets/Cao-mein-nudle.jpg',
            ],
            [
                'name' => 'Govedina sa Brokolijem',
                'description' => 'Govedina sa brokolijem u sočnom sosu.',
                'price' => 950.00,
                'category' => 'Glavno jelo',
                'image_path' => 'assets/govedina-sa-brokolijem.jpg',
            ],
            [
                'name' => 'Hrskava Patka',
                'description' => 'Hrskava patka sa posebnom marinadom.',
                'price' => 1400.00,
                'category' => 'Glavno jelo',
                'image_path' => 'assets/Hrskava-Patka.jpg',
            ],
            [
                'name' => 'Prolećne rolnice',
                'description' => 'Pržene kineske rolne sa povrćem.',
                'price' => 550.00,
                'category' => 'Dezert',
                'image_path' => 'assets/prolecne-rolnice.jpg',
            ],
            [
                'name' => 'Wonton Supa',
                'description' => 'Tradicionalna kineska supa sa wonton knedlama.',
                'price' => 500.00,
                'category' => 'Supa',
                'image_path' => 'assets/wonton-supa.jpg',
            ],
            [
                'name' => 'Supa sa Tofuom',
                'description' => 'Supa sa tofu sirom i povrćem.',
                'price' => 450.00,
                'category' => 'Supa',
                'image_path' => 'assets/supa-sa-tofuom.jpg',
            ],
            [
                'name' => 'Supa sa kineskim gljivama',
                'description' => 'Ukusna supa sa gljivama i začinima.',
                'price' => 400.00,
                'category' => 'Supa',
                'image_path' => 'assets/supa-sa-gljivama.jpg',
            ],
            [
                'name' => 'Kiselo-ljuta Supa',
                'description' => 'Kineska supa sa začinima i kiselkastim ukusom.',
                'price' => 350.00,
                'category' => 'Supa',
                'image_path' => 'assets/kiselo-ljuta-supa.jpg',
            ],
            [
                'name' => 'Zeleni Čaj',
                'description' => 'Osvežavajući kineski zeleni čaj.',
                'price' => 300.00,
                'category' => 'Piće',
                'image_path' => 'assets/zeleni-caj.webp',
            ],
            [
                'name' => 'Kineski Crni Čaj',
                'description' => 'Kineski crni čaj sa bogatim ukusom.',
                'price' => 350.00,
                'category' => 'Piće',
                'image_path' => 'assets/crni-caj.webp',
            ],
            [
                'name' => 'Kineska limunada',
                'description' => 'Osvežavajuća limunada sa kineskim začinima.',
                'price' => 400.00,
                'category' => 'Piće',
                'image_path' => 'assets/kineska-limunada.jpg',
            ],
            [
                'name' => 'Svetla piva',
                'description' => 'Kineska svetla piva sa blagim ukusom.',
                'price' => 500.00,
                'category' => 'Piće',
                'image_path' => 'assets/svetla-piva.webp',
            ],
            [
                'name' => 'Torta od limunke',
                'description' => 'Ukusna limun-torta sa kineskim začinima.',
                'price' => 650.00,
                'category' => 'Dezert',
                'image_path' => 'assets/torta-od-limonke.webp',
            ],
            [
                'name' => 'Mu Šu Svinjetina',
                'description' => 'Svinjsko meso sa povrćem, servira se sa palačinkama.',
                'price' => 1000.00,
                'category' => 'Glavno jelo',
                'image_path' => 'assets/svinjetina-mu-su.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
