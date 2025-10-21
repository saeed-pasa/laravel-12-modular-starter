<?php

namespace Modules\User\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="LoginRequest",
 *     title="Login Request",
 *     description="Request schema for user login",
 *     required={"email", "password"},
 *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *     @OA\Property(property="password", type="string", format="password", example="password123")
 * )
 */
class LoginRequest extends FormRequest
{
   public function authorize(): bool
   {
      return true;
   }

   public function rules(): array
   {
      return [
         'email' => ['required', 'string', 'email'],
         'password' => ['required', 'string'],
      ];
   }
}