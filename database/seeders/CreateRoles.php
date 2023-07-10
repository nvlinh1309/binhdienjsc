<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name'  =>  'admin',
                'display_name' => 'Quản trị hệ thống'
            ],
            [
                'name'  =>  'manager',
                'display_name' => 'Quản lý'
            ],
            [
                'name'  =>  'warehouse_keeper',
                'display_name' => 'Thủ kho'
            ],
            [
                'name'  =>  'sale',
                'display_name' => 'Sale'
            ],
        ];
        foreach ($roles as $value) {
            $role = Role::create($value);
        }

    }
}
