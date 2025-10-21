<?php

namespace Modules\User\Data;

use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     schema="LoginData",
 *     title="Login Data",
 *     description="Data schema for user login",
 *     required={"email", "password"},
 *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *     @OA\Property(property="password", type="string", format="password", example="password123")
 * )
 */
class LoginData extends Data
{
   public function __construct(
      public string $email,
      public string $password,
   )
   {
   }
}