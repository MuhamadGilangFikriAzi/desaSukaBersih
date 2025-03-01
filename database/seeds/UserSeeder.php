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
        DB::table('model_has_roles')->delete();
        DB::table('role_has_permissions')->delete();
        DB::table('roles')->delete();
        DB::table('users')->delete();

        User::create([
            'name' => 'admin',
            'nik' => '11111',
            'password' => bcrypt('P@ssw0rd'), // Make sure to hash the password
            'ktp' => '1111111111111111',
        ]);
        
        Role::create(['name' => 'Staff Desa']);
        Role::create(['name' => 'User']);
        Role::create(['name' => 'Guest']);

        $user = User::where('name', 'admin')->first();
        $user->assignRole('Staff Desa');
    }
}
