<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Product\Database\Seeders\ProductDatabaseSeeder;
use Modules\User\Database\Seeders\UserDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
   /**
    * Seed the application's database.
    */
   public function run(): void
   {
      $this->call([
         RolePermissionSeeder::class,
         UserDatabaseSeeder::class,
         ProductDatabaseSeeder::class
      ]);
   }
}

