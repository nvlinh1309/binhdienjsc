<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User\Product;
use Faker\Factory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Factory::create();
        $limit = 100;
        for ($i=0; $i < $limit; $i++) {
             Product::insert([
                'name' => $fake->word,
                'barcode' => $fake->ean8,
                'brand_name' => $fake->company,
                'specification' => "10 (kg)"
             ]);
        }
    }
}
