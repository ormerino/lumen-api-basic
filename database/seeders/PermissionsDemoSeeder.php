<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'users.all']);
        Permission::create(['name' => 'users.show']);
        Permission::create(['name' => 'users.update']);
        Permission::create(['name' => 'users.delete']);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('users.all');
        $adminRole->givePermissionTo('users.show');
        $adminRole->givePermissionTo('users.update');
        $adminRole->givePermissionTo('users.delete');
        

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo('users.show');

        // create demo users
        $admin = \App\Models\User::where('email','admin@correo.com')->first();
        $admin->assignRole($adminRole);

        $user = \App\Models\User::where('email','usuario@correo.com')->first();
        $user->assignRole($userRole);

    }
}