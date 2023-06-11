<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\User\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $limit = 100;

        for ($i = 0; $i < $limit; $i++) {
            Supplier::insert([
                'name' => $faker->company,
                'address' => $faker->address,
                'tax_code' => $faker->ean13
            ]);
        }
    }
}
