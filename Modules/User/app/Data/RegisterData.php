<?php

namespace Modules\User\Data;

use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     schema="RegisterData",
 *     title="Register Data",
 *     description="Data schema for user registration",
 *     required={"name", "email", "password"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *     @OA\Property(property="password", type="string", format="password", example="password123")
 * )
 */
class RegisterData extends Data
{
   public function __construct(
      public string $name,
      public string $email,
      public string $password,
   )
   {
   }
}