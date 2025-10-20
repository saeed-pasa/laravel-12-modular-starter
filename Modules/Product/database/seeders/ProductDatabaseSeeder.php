<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Product\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductDatabaseSeeder extends Seeder
{
   /**
    * Run the database seeds.
    */
   public function run(): void
   {
      // Get users with Super Admin (role_id = 2) or Content Manager (role_id = 3) roles
      $userIds = DB::table('model_has_roles')
         ->whereIn('role_id', [2, 3])
         ->pluck('model_id')
         ->unique()
         ->toArray();

      if (empty($userIds)) {
         $this->command->warn('No users found with Super Admin or Content Manager roles.');
         return;
      }

      // Create 20 products
      Product::factory(20)->create();
      
      $this->command->info('Created 20 products successfully.');
   }
}
