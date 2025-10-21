<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\V1\CategoryController;

Route::prefix('v1/categories')
   ->middleware('auth:api')
   ->group(function () {

      // GET /api/v1/categories (User, Manager, Admin)
      Route::get('/', [CategoryController::class, 'index'])
         ->middleware('can:view categories');

      // POST /api/v1/categories (Manager, Admin)
      Route::post('/', [CategoryController::class, 'store']);

      // GET /api/v1/categories/{category} (User, Manager, Admin)
      Route::get('/{category}', [CategoryController::class, 'show'])
         ->middleware('can:view categories');

      // PUT/PATCH /api/v1/categories/{category} (Manager, Admin)
      Route::put('/{category}', [CategoryController::class, 'update'])
         ->middleware('can:edit categories');
      Route::patch('/{category}', [CategoryController::class, 'update'])
         ->middleware('can:edit categories');

      // DELETE /api/v1/categories/{category} (Manager, Admin)
      Route::delete('/{category}', [CategoryController::class, 'destroy'])
         ->middleware('can:delete categories');
   });
