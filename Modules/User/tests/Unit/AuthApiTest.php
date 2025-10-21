<?php

namespace Modules\User\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\Models\User;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
   use RefreshDatabase;

   public function test_user_can_register()
   {
      $payload = [
         'name' => 'Test User',
         'email' => 'test@example.com',
         'password' => 'password123',
         'password_confirmation' => 'password123',
      ];

      $response = $this->postJson('/api/v1/auth/register', $payload);

      $response->assertStatus(201)
         ->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
            'user' => ['id', 'name', 'email']
         ]);

      $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
   }

   public function test_user_cannot_register_with_invalid_data()
   {
      $payload = [
         'name' => 'Test User',
         'email' => 'not-an-email',
         'password' => '123',
      ];

      $response = $this->postJson('/api/v1/auth/register', $payload);

      $response->assertStatus(422)
         ->assertJsonValidationErrors(['email', 'password']);
   }

   public function test_user_can_login()
   {
      $user = User::factory()->create([
         'email' => 'login@example.com',
         'password' => bcrypt('password123'),
      ]);

      $payload = [
         'email' => 'login@example.com',
         'password' => 'password123',
      ];

      $response = $this->postJson('/api/v1/auth/login', $payload);

      $response->assertStatus(200)
         ->assertJsonStructure(['access_token']);
   }

   public function test_user_cannot_login_with_wrong_password()
   {
      User::factory()->create([
         'email' => 'login@example.com',
      ]);

      $payload = [
         'email' => 'login@example.com',
         'password' => 'wrong-password',
      ];

      $response = $this->postJson('/api/v1/auth/login', $payload);

      $response->assertStatus(401)
         ->assertJson(['error' => 'Unauthorized']);
   }

   public function test_authenticated_user_can_get_their_profile()
   {
      $user = User::factory()->create();

      $response = $this->actingAs($user, 'api')->getJson('/api/v1/auth/me');

      $response->assertStatus(200)
         ->assertJson([
            'email' => $user->email,
            'name' => $user->name,
         ]);
   }
}
