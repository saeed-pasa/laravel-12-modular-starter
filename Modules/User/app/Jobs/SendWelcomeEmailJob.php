<?php

namespace Modules\User\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Modules\User\Emails\WelcomeEmail;
use Modules\User\Models\User;

class SendWelcomeEmailJob implements ShouldQueue
{
   use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   /**
    * Create a new job instance.
    */
   public function __construct(public User $user)
   {
   }

   /**
    * Execute the job.
    */
   public function handle(): void
   {
      Mail::to($this->user->email)->send(new WelcomeEmail($this->user));
   }
}
