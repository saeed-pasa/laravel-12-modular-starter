<?php

namespace Modules\User\Listeners;

use Illuminate\Auth\Events\Registered;
use Modules\User\Jobs\SendWelcomeEmailJob;

class SendWelcomeEmailListener
{
   /**
    * Create the event listener.
    */
   public function __construct()
   {
   }

   /**
    * Handle the event.
    */
   public function handle(Registered $event): void
   {
      SendWelcomeEmailJob::dispatch($event->user);
   }
}
