<?php

namespace Modules\Product\Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;
use Tests\TestCase;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Models\Product;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductApiTest extends TestCase
{
   use RefreshDatabase;

   protected User|Collection|Model $superAdmin;
   protected User|Collection|Model $contentManager;
   protected User|Collection|Model $simpleUser;

   protected function setUp(): void
   {
      parent::setUp();

      $this->seed(RolePermissionSeeder::class);

      $this->superAdmin = User::factory()->create()->assignRole('SuperAdmin');
      $this->contentManager = User::factory()->create()->assignRole('Content Manager');
      $this->simpleUser = User::factory()->create()->assignRole('User');
   }

   protected function getHeaders($user): array
   {
      $token = JWTAuth::fromUser($user);
      return ['Authorization' => 'Bearer ' . $token];
   }


   public function test_simple_user_can_view_products()
   {
      Product::factory()->create();

      $response = $this->getJson('/api/v1/products', $this->getHeaders($this->simpleUser));

      $response->assertStatus(200);
      $this->assertCount(1, $response->json('data'));
   }

   public function test_simple_user_cannot_create_product()
   {
      $payload = ['name' => 'New Product', 'price' => 1000];

      $response = $this->postJson('/api/v1/products', $payload, $this->getHeaders($this->simpleUser));

      $response->assertStatus(403);
   }

   public function test_simple_user_cannot_delete_product()
   {
      $product = Product::factory()->create();

      $response = $this->deleteJson('/api/v1/products/' . $product->id, [], $this->getHeaders($this->simpleUser));

      $response->assertStatus(403);
   }


   public function test_content_manager_can_create_product()
   {
      $payload = ['name' => 'New Product', 'price' => 1000];

      $response = $this->postJson('/api/v1/products', $payload, $this->getHeaders($this->contentManager));

      $response->assertStatus(201);
      $this->assertDatabaseHas('products', ['name' => 'New Product']);
   }

   public function test_content_manager_can_delete_product()
   {
      $product = Product::factory()->create();

      $response = $this->deleteJson('/api/v1/products/' . $product->id, [], $this->getHeaders($this->contentManager));

      $response->assertStatus(204);
      $this->assertDatabaseMissing('products', ['id' => $product->id]);
   }


   public function test_unauthenticated_user_cannot_view_products()
   {
      $response = $this->getJson('/api/v1/products');

      $response->assertStatus(401);
   }
}
