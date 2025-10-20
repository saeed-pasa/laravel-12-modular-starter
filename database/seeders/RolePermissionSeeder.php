<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       app()[PermissionRegistrar::class]->forgetCachedPermissions();


       Permission::create(['name' => 'view products']);
       Permission::create(['name' => 'create products']);
       Permission::create(['name' => 'edit products']);
       Permission::create(['name' => 'delete products']);

       Permission::create(['name' => 'view users']);
       Permission::create(['name' => 'create users']);
       Permission::create(['name' => 'edit users']);
       Permission::create(['name' => 'delete users']);


       $userRole = Role::create(['name' => 'User']);
       $userRole->givePermissionTo([
          'view products',
       ]);

       $contentManagerRole = Role::create(['name' => 'Content Manager']);
       $contentManagerRole->givePermissionTo([
          'view products',
          'create products',
          'edit products',
          'delete products',
       ]);

       $superAdminRole = Role::create(['name' => 'SuperAdmin']);
       $superAdminRole->givePermissionTo(Permission::all());
    }
}
