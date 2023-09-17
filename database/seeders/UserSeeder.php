<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
                'name' => 'Quản trị hệ thống',
                'email' => 'binhdienjscsys@gmail.com',
                'password' => bcrypt('admin123')
        ])->assignRole('admin');
    }
}
