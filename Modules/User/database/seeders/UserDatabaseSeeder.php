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
      User::firstOrCreate(
         ['email' => 'test@example.com'],
         [
            'name' => 'Test User',
            'password' => bcrypt('password'),
         ]
      );
      // Create a test user
      $admin = User::firstOrCreate(
         ['email' => 'admin@example.com'],
         [
            'name' => 'Admin User',
            'password' => bcrypt('password'),
         ]
      );
      $admin->assignRole('SuperAdmin');

      // Create a test user
      $content = User::firstOrCreate(
         ['email' => 'content@example.com'],
         [
            'name' => 'Content Manager User',
            'password' => bcrypt('password'),
         ]
      );
      $content->assignRole('Content Manager');

      // Only create additional users if we don't have enough
      if (User::count() < 11) {
         User::factory(10)->create();
      }
   }
}
