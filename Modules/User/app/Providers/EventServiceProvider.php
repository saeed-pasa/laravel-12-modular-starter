<?php

namespace Modules\User\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\User\Listeners\SendWelcomeEmailListener;

class EventServiceProvider extends ServiceProvider
{
   /**
    * The event handler mappings for the application.
    *
    * @var array<string, array<int, string>>
    */
   protected $listen = [
      Registered::class => [SendWelcomeEmailListener::class],
   ];

   /**
    * Indicates if events should be discovered.
    *
    * @var bool
    */
   protected static $shouldDiscoverEvents = true;

   /**
    * Configure the proper event listeners for email verification.
    */
   protected function configureEmailVerification(): void
   {
   }
}
