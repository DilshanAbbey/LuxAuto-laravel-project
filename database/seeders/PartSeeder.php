<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Part;

class PartSeeder extends Seeder
{
    public function run()
    {
        $parts = [
            [
                'idPart' => '001',
                'partName' => 'Premium Brake Pad Set',
                'partNumber' => 'BP001',
                'brand' => 'LuxParts',
                'model' => 'Universal',
                'price' => 45.99,
                'description' => 'High-performance ceramic brake pads',
                'quantityInStock' => 50
            ],
            [
                'idPart' => '002',
                'partName' => 'Oil Filter',
                'partNumber' => 'OF002',
                'brand' => 'LuxParts',
                'model' => 'Universal',
                'price' => 18.50,
                'description' => 'Advanced filtration technology',
                'quantityInStock' => 75
            ],
            // Add more parts as needed
        ];

        foreach ($parts as $part) {
            Part::create($part);
        }
    }
}
