<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chapter;
use App\Models\Test;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Role::create(['name' => 'individual']);
        //Role::create(['name' => 'parent']);
        // Role::create(['name' => 'student']);

        // $users = User::all();

        // foreach ($users as $key => $user) {
        //     if (!$user->hasRole('admin') && !$user->hasRole('teacher')) {
        //         $user->assignRole('student');
        //     }
        // }
        //parent@gmail.com

        // $role = Role::where('name', 'admin')->first();
        // $permission = Permission::create(['name' => 'create course']);
        // $role->givePermissionTo($permission);
        // $permission = Permission::create(['name' => 'edit course']);
        // $role->givePermissionTo($permission);
        // $permission = Permission::create(['name' => 'destroy course']);
        // $role->givePermissionTo($permission);

        // $role = Role::where('name', 'admin')->first();
        // $permission = Permission::create(['name' => 'создание курсов']);
        // $role->givePermissionTo($permission);
        // $permission = Permission::create(['name' => 'редактирование курсов']);
        // $role->givePermissionTo($permission);
        // $permission = Permission::create(['name' => 'удаление курсов']);
        // $role->givePermissionTo($permission);
        
    }
}
