<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Admin',
            'email' => 'likholetovalex@gmail.com',
            'password' => Hash::make('123456789'),
            'sex' => 'мужской'
        ]);

        $user1->assignRole('admin');
        $user1->assignRole('teacher');

        $user2 = User::create([
            'name' => 'Дмитрий Попов',
            'email' => 'imedia.penza@yandex.ru',
            'password' => Hash::make('123456789'),
            'sex' => 'мужской'
        ]);

        $user2->assignRole('admin');

        $user3 = User::create([
            'name' => 'Демин Михаил Сергеевич',
            'email' => 'teacher@yandex.ru',
            'password' => Hash::make('123456789'),
            'sex' => 'мужской'
        ]);

        $user3->assignRole('teacher');
        
    }
}
