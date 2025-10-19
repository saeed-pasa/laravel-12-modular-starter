<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\User\Repositories\Contracts\UserRepositoryInterface;
use Modules\User\Repositories\Eloquent\EloquentUserRepository;

class AppServiceProvider extends ServiceProvider
{
   /**
    * Register any application services.
    */
   public function register(): void
   {
      $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
   }

   /**
    * Bootstrap any application services.
    */
   public function boot(): void
   {
      //
   }
}
