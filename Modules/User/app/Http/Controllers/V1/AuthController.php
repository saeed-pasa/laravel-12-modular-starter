<?php

namespace Modules\User\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\User\Data\LoginData;
use Modules\User\Data\RegisterData;
use Modules\User\Http\Requests\V1\LoginRequest;
use Modules\User\Http\Requests\V1\RegisterRequest;
use Modules\User\Services\AuthService;

class AuthController extends Controller
{
   public function __construct(protected AuthService $authService)
   {
      $this->middleware('auth:api', ['except' => ['login', 'register']]);
   }

   public function register(RegisterRequest $request): JsonResponse
   {
      try {
         $registerData = RegisterData::from($request->validated());
         $tokenData = $this->authService->register($registerData);

         return response()->json($tokenData, 201);
      } catch (\Exception $e) {
         return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 400);
      }
   }

   public function login(LoginRequest $request): JsonResponse
   {
      try {
         $loginData = LoginData::from($request->validated());
         $tokenData = $this->authService->login($loginData);

         return response()->json($tokenData);
      } catch (\Exception $e) {
         $statusCode = ($e->getCode() === 401) ? 401 : 400;
         return response()->json(['error' => $e->getMessage()], $statusCode);
      }
   }

   public function logout(): JsonResponse
   {
      $this->authService->logout();
      return response()->json(['message' => 'Successfully logged out']);
   }

   public function refresh(): JsonResponse
   {
      try {
         $tokenData = $this->authService->refresh();
         return response()->json($tokenData);
      } catch (\Exception $e) {
         return response()->json(['error' => 'Could not refresh token'], 401);
      }
   }

   public function me(): JsonResponse
   {
      return response()->json(auth('api')->user());
   }
}
