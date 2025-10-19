<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\V1\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1/auth')->controller(AuthController::class)->group(function () {
   Route::post('/register', 'register');
   Route::post('/login', 'login');

   Route::middleware('auth:api')->group(function () {
      Route::post('/logout', 'logout');
      Route::post('/refresh', 'refresh');
      Route::get('/me', 'me');
   });
});
