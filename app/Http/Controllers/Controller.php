<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * @OA\Info(
 *    title="API Product Managment (Modular API)",
 *    version="1.0.0",
 *    description="API documentation for best practice modular project"
 * )
 * @OA\Server(
 *    url=L5_SWAGGER_CONST_HOST,
 *    description="Main server API"
 * )
 * @OA\SecurityScheme(
 *    securityScheme="bearerAuth",
 *    type="http",
 *    scheme="bearer",
 *    bearerFormat="JWT",
 *    description="Import your JWT token in the format 'Bearer'"
 * )
 * @OA\Tag(
 *    name="Authentication",
 *    description="Endpoint for user authentication"
 * )
 * @OA\Tag(
 *    name="Products",
 *    description="Endpoint for products"
 * )
 * @OA\PathItem(
 *    path="/"
 * )
 */
abstract class Controller extends BaseController
{
   use AuthorizesRequests, ValidatesRequests;
}