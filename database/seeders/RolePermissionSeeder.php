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


       Permission::firstOrCreate(['name' => 'view products']);
       Permission::firstOrCreate(['name' => 'create products']);
       Permission::firstOrCreate(['name' => 'edit products']);
       Permission::firstOrCreate(['name' => 'delete products']);

       Permission::firstOrCreate(['name' => 'view users']);
       Permission::firstOrCreate(['name' => 'create users']);
       Permission::firstOrCreate(['name' => 'edit users']);
       Permission::firstOrCreate(['name' => 'delete users']);


       $userRole = Role::firstOrCreate(['name' => 'User']);
       $userRole->syncPermissions([
          'view products',
       ]);

       $contentManagerRole = Role::firstOrCreate(['name' => 'Content Manager']);
       $contentManagerRole->syncPermissions([
          'view products',
          'create products',
          'edit products',
          'delete products',
       ]);

       $superAdminRole = Role::firstOrCreate(['name' => 'SuperAdmin']);
       $superAdminRole->syncPermissions(Permission::all());
    }
}
