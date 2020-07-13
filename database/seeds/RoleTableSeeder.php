<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_manager = new Role();
        $role_manager->name = 'super_admin';
        $role_manager->description = 'Super Admin';
        $role_manager->save();

        $role_employee = new Role();
        $role_employee->name = 'user';
        $role_employee->description = 'User Normal';
        $role_employee->save();

        $role_manager = new Role();
        $role_manager->name = 'admin';
        $role_manager->description = 'Admin User';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = 'manager';
        $role_manager->description = 'Managerial User';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = 'finance';
        $role_manager->description = 'Financial User';
        $role_manager->save();
    }
}
