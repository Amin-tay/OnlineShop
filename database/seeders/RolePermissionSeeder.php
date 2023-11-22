<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::create(['name' => 'superAdmin']);
        $normalAdminRole = Role::create(['name' => 'normalAdmin']);
        $normalUserRole = Role::create(['name' => 'normalUser']);

        $addCategoryPermission = Permission::create(['name' => 'add category']);
        $editCategoryPermission = Permission::create(['name' => 'edit category']);
        $deleteCategoryPermission = Permission::create(['name' => 'delete category']);

        $addProductPermission = Permission::create(['name' => 'add product']);
        $editProductPermission = Permission::create(['name' => 'edit product']);
        $deleteProductPermission = Permission::create(['name' => 'delete product']);

        $addDiscountCode = Permission::create(['name' => 'add discount code']);

        $changeOrderStatusPermission = Permission::create(['name' => 'change order status']);

        //super admin permissions
        $superAdminRole->givePermissionTo($addCategoryPermission);
        $superAdminRole->givePermissionTo($editCategoryPermission);
        $superAdminRole->givePermissionTo($deleteCategoryPermission);

        $superAdminRole->givePermissionTo($addProductPermission);
        $superAdminRole->givePermissionTo($editProductPermission);
        $superAdminRole->givePermissionTo($deleteProductPermission);

        $superAdminRole->givePermissionTo($addDiscountCode);

        $superAdminRole->givePermissionTo($changeOrderStatusPermission);

        //normal admin permissions
        $normalAdminRole->givePermissionTo($editCategoryPermission);
        $normalAdminRole->givePermissionTo($editProductPermission);

        $normalAdminRole->givePermissionTo($addDiscountCode);

//        $normalAdminRole->givePermissionTo($changeOrderStatusPermission);
    }
}
