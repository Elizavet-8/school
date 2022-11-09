<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        Role::create(['name' => 'teacher']);
        Role::create(['name' => 'admin']);

        /*$permissionCreateUsers = Permission::create(['name' => 'create users']);
        $permissionDeleteUsers = Permission::create(['name' => 'delete users']);
        $permissionEditUsers = Permission::create(['name' => 'edit users']);
        $permissionGetUsers = Permission::create(['name' => 'get users']);

        $admin->givePermissionTo($permissionCreateUsers);
        $admin->givePermissionTo($permissionDeleteUsers);
        $admin->givePermissionTo($permissionEditUsers);
        $admin->givePermissionTo($permissionGetUsers);*/
    }
}
