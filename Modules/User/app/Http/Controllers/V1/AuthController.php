<?php

namespace Modules\User\Http\Controllers\V1;

use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Modules\User\Data\LoginData;
use Modules\User\Data\RegisterData;
use Modules\User\Http\Requests\V1\LoginRequest;
use Modules\User\Http\Requests\V1\RegisterRequest;
use Modules\User\Services\AuthService;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for User Authentication"
 * )
 */
class AuthController extends Controller
{
   public function __construct(protected AuthService $authService)
   {
      $this->middleware('auth:api', ['except' => ['login', 'register']]);
   }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/register",
     *     summary="Register a new user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful registration",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error"
     *     )
     * )
     */
   public function register(RegisterRequest $request): JsonResponse
   {
      try {
         $registerData = RegisterData::from($request->validated());
         $tokenData = $this->authService->register($registerData);

         return response()->json($tokenData, 201);
      } catch (Exception $e) {
         return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 400);
      }
   }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     summary="Log in a user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error"
     *     )
     * )
     */
   public function login(LoginRequest $request): JsonResponse
   {
      try {
         $loginData = LoginData::from($request->validated());
         $tokenData = $this->authService->login($loginData);

         return response()->json($tokenData);
      } catch (Exception $e) {
         $statusCode = ($e->getCode() === 401) ? 401 : 400;
         return response()->json(['error' => $e->getMessage()], $statusCode);
      }
   }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     summary="Log out a user",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
   public function logout(): JsonResponse
   {
      $this->authService->logout();
      return response()->json(['message' => 'Successfully logged out']);
   }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/refresh",
     *     summary="Refresh a token",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token refreshed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
   public function refresh(): JsonResponse
   {
      try {
         $tokenData = $this->authService->refresh();
         return response()->json($tokenData);
      } catch (Exception $e) {
         return response()->json(['error' => 'Could not refresh token'], 401);
      }
   }

    /**
     * @OA\Get(
     *     path="/api/v1/auth/me",
     *     summary="Get authenticated user details",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="User details retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="email_verified_at", type="string", format="date-time", example="2025-10-20T14:30:00.000000Z"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-10-20T14:30:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-10-20T14:30:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
   public function me(): JsonResponse
   {
      return response()->json(auth('api')->user());
   }
}