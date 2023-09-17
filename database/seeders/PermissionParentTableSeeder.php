<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User\ParentPermission;

class PermissionParentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parentNames = [
            'Quản lý quyền và vai trò',
            'Quản lý người dùng',
            'Quản lý kho',
            'Quản lý khách hàng',
            'Quản lý thương hiệu',
            'Quản lý nhà cung cấp',
            'Quản lý sản phẩm'
         ];
         foreach ($parentNames as $permission) {
            ParentPermission::create(['parent_name' => $permission]);
       }
    }
}
