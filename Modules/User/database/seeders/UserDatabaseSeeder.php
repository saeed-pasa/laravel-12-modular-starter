<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\User;

class UserDatabaseSeeder extends Seeder
{
   /**
    * Run the database seeds.
    */
   public function run(): void
   {
      // Create a test user
      User::factory()->create([
         'name' => 'Test User',
         'email' => 'test@example.com',
      ]);

      User::factory(10)->create();
   }
}
