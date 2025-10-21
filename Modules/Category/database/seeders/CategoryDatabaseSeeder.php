<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\Models\Category;

class CategoryDatabaseSeeder extends Seeder
{
   /**
    * Run the database seeds.
    */
   public function run(): void
   {
      Category::firstOrCreate(['name' => 'Health']);
      Category::firstOrCreate(['name' => 'Electronics']);
      Category::firstOrCreate(['name' => 'Clothes']);
      Category::firstOrCreate(['name' => 'Gift']);
   }
}
