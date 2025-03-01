<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        UserModel::create([
            'name' => 'admin',
            'nik' => '11111',
            'password' => bcrypt('P@ssw0rd'), // Make sure to hash the password
            'ktp' => '1111111111111111',
        ]);

        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);
        Role::create(['name' => 'Staff Desa']);

        $user = UserModel::where('name', 'admin')->first();
        $user->assignRole('Admin');
    }
}
