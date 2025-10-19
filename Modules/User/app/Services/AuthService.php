<?php

namespace Modules\User\app\Services;

use Illuminate\Support\Facades\Auth;
use Modules\User\app\Data\LoginData;
use Modules\User\app\Data\RegisterData;
use Modules\User\app\Repositories\Contracts\UserRepositoryInterface;

class AuthService
{
   public function __construct(
      protected UserRepositoryInterface $userRepository
   )
   {
   }

   /**
    * @throws \Exception
    */
   public function register(RegisterData $data): array
   {
      $user = $this->userRepository->create($data);
      $token = Auth::guard('api')->login($user);
      return $this->respondWithToken($token);
   }

   /**
    * @throws \Exception
    */
   public function login(LoginData $data): array
   {
      if (!$token = Auth::guard('api')->attempt($data->toArray())) {
         throw new \Exception('Unauthorized', 401);
      }

      return $this->respondWithToken($token);
   }

   public function logout(): void
   {
      Auth::guard('api')->logout();
   }

   public function refresh(): array
   {
      return $this->respondWithToken(Auth::guard('api')->refresh());
   }

   protected function respondWithToken(string $token): array
   {
      $ttl = Auth::guard('api')->factory()->getTTL();

      return [
         'access_token' => $token,
         'token_type' => 'bearer',
         'expires_in' => $ttl * 60,
         'user' => Auth::guard('api')->user()
      ];
   }
}
