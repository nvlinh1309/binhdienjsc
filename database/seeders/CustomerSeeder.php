<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User\Customer;
use Faker\Factory;

class CustomerSeeder extends Seeder
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
            $contact = [
                'phone' => $faker->phoneNumber,
                'email' => $faker->email
            ];
            // dd($contact);
            Customer::insert([
                'name' => $faker->name,
                'code' => $faker->ean8,
                'tax_code' => $faker->ean13,
                'address' => $faker->address,
                'tax' => $faker->ean8,
                'contact' => json_encode($contact),
            ]);
        }
    }
}
