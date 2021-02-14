<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Hardis',
            'surname' => 'Kindzuri',
            'date_of_birth' => '2021-02-01',
            'email' => 'user@gmail.com',
            'password' => bcrypt('123456')
        ]);
        $adminUser = User::create([
            'name' => 'Admin',
            'surname' => 'Admin',
            'date_of_birth' => '1996-10-06',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123')
        ]);
        $adminRole = Role::create(['name' => 'Admin']);
        $role = Role::create(['name' => 'User']);
        $adminUser->assignRole([$adminRole->id, $role->id]);
        $user->assignRole([$role->id]);
    }
}
