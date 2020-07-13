<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_su = Role::where('name', 'super_admin')->first();
        $role_admin = Role::where('name', 'admin')->first();
        $role_user = Role::where('name', 'user')->first();
        $role_manager = Role::where('name', 'manager')->first();
        $role_finance = Role::where('name', 'finance')->first();

        $employee = new User();
        $employee->name = 'Super Admin Name';
        $employee->email = 'su@example.com';
        $employee->password = bcrypt('password');
        $employee->save();
        $employee->roles()->attach($role_su);

        $employee = new User();
        $employee->name = 'Admin Name';
        $employee->email = 'admin@example.com';
        $employee->password = bcrypt('password');
        $employee->save();
        $employee->roles()->attach($role_admin);

        $employee = new User();
        $employee->name = 'User Name';
        $employee->email = 'user@example.com';
        $employee->password = bcrypt('password');
        $employee->save();
        $employee->roles()->attach($role_user);

        $employee = new User();
        $employee->name = 'Manager Name';
        $employee->email = 'manage@example.com';
        $employee->password = bcrypt('password');
        $employee->save();
        $employee->roles()->attach($role_manager);

        $employee = new User();
        $employee->name = 'Manager Name';
        $employee->email = 'manage@example.com';
        $employee->password = bcrypt('password');
        $employee->save();
        $employee->roles()->attach($role_finance);

    }
}
