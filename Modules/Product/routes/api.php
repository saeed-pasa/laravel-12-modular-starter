<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\V1\ProductController;

Route::middleware('auth:api')
   ->prefix('v1/products')
   ->group(function () {

      // GET /api/v1/products
      Route::get('/', [ProductController::class, 'index'])
         ->middleware('can:view products');

      // POST /api/v1/products
      Route::post('/', [ProductController::class, 'store']);

      // GET /api/v1/products/{product}
      Route::get('/{product}', [ProductController::class, 'show'])
         ->middleware('can:view products');

      // PUT/PATCH /api/v1/products/{product}
      Route::put('/{product}', [ProductController::class, 'update']);
      Route::patch('/{product}', [ProductController::class, 'update']);

      // DELETE /api/v1/products/{product}
      Route::delete('/{product}', [ProductController::class, 'destroy'])
         ->middleware('can:delete products');
   });
