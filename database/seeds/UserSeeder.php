<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;

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
            'name' => 'admin',
            'nik' => '11111',
            'password' => bcrypt('P@ssw0rd'), // Make sure to hash the password
            'ktp' => '1111111111111111',
        ]);
        
        Role::create(['name' => 'Staff Desa']);
        Role::create(['name' => 'User']);

        $user = User::where('name', 'admin')->first();
        $user->assignRole('Staff Desa');
    }
}
