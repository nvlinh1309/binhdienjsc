<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $permissions = [
            [
                'name'  =>  'role-view',
                'display_name' => 'Truy cập',
                'parent_id' => 1
            ],
            [
                'name'  =>  'role-create',
                'display_name' => 'Thêm mới',
                'parent_id' => 1
            ],
            [
                'name'  =>  'role-edit',
                'display_name' => 'Chỉnh sửa',
                'parent_id' => 1
            ],
            [
                'name'  =>  'role-delete',
                'display_name' => 'Xóa',
                'parent_id' => 1
            ],
            [
                'name'  =>  'user-view',
                'display_name' => 'Truy cập',
                'parent_id' => 2
            ],
            [
                'name'  =>  'user-create',
                'display_name' => 'Thêm mới',
                'parent_id' => 2
            ],
            [
                'name'  =>  'user-edit',
                'display_name' => 'Chỉnh sửa',
                'parent_id' => 2
            ],
            [
                'name'  =>  'user-delete',
                'display_name' => 'Xóa',
                'parent_id' => 2
            ],
            [
                'name'  =>  'warehouse-view',
                'display_name' => 'Truy cập',
                'parent_id' => 3
            ],
            [
                'name'  =>  'warehouse-create',
                'display_name' => 'Thêm mới',
                'parent_id' => 3
            ],
            [
                'name'  =>  'warehouse-edit',
                'display_name' => 'Chỉnh sửa',
                'parent_id' => 3
            ],
            [
                'name'  =>  'warehouse-delete',
                'display_name' => 'Xóa',
                'parent_id' => 3
            ],
            [
                'name'  =>  'customer-view',
                'display_name' => 'Truy cập',
                'parent_id' => 4
            ],
            [
                'name'  =>  'customer-create',
                'display_name' => 'Thêm mới',
                'parent_id' => 4
            ],
            [
                'name'  =>  'customer-edit',
                'display_name' => 'Chỉnh sửa',
                'parent_id' => 4
            ],
            [
                'name'  =>  'customer-delete',
                'display_name' => 'Xóa',
                'parent_id' => 4
            ],
            [
                'name'  =>  'brand-view',
                'display_name' => 'Truy cập',
                'parent_id' => 5
            ],
            [
                'name'  =>  'brand-create',
                'display_name' => 'Thêm mới',
                'parent_id' => 5
            ],
            [
                'name'  =>  'brand-edit',
                'display_name' => 'Chỉnh sửa',
                'parent_id' => 5
            ],
            [
                'name'  =>  'brand-delete',
                'display_name' => 'Xóa',
                'parent_id' => 5
            ],
            [
                'name'  =>  'supplier-view',
                'display_name' => 'Truy cập',
                'parent_id' => 6
            ],
            [
                'name'  =>  'supplier-create',
                'display_name' => 'Thêm mới',
                'parent_id' => 6
            ],
            [
                'name'  =>  'supplier-edit',
                'display_name' => 'Chỉnh sửa',
                'parent_id' => 7
            ],
            [
                'name'  =>  'supplier-delete',
                'display_name' => 'Xóa',
                'parent_id' => 7
            ],
            [
                'name'  =>  'product-view',
                'display_name' => 'Truy cập',
                'parent_id' => 7
            ],
            [
                'name'  =>  'product-create',
                'display_name' => 'Thêm mới',
                'parent_id' => 7
            ],
            [
                'name'  =>  'product-edit',
                'display_name' => 'Chỉnh sửa',
                'parent_id' => 7
            ],
            [
                'name'  =>  'product-delete',
                'display_name' => 'Xóa',
                'parent_id' => 7
            ],
        ];

        foreach ($permissions as $value) {
            $role = Role::where('name', '=', 'admin')->first();
            Permission::create($value);
            $role->givePermissionTo($value['name']);
        }
    }
}
