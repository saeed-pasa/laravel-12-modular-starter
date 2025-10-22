<?php

namespace Modules\User\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\User\Models\User;

class WelcomeEmail extends Mailable
{
   use Queueable, SerializesModels;

   /**
    * Create a new message instance.
    */
   public function __construct(public User $user)
   {
   }

   /**
    * Build the message.
    */
   public function build(): self
   {
      return $this->view('view.name');
   }

   /**
    * Get the message envelope.
    */
   public function envelope(): Envelope
   {
      return new Envelope(
         subject: 'Welcome to our website!',
      );
   }

   /**
    * Get the message content definition.
    */
   public function content(): Content
   {
      return new Content(
         markdown: 'user::emails.welcome',
         with: [
            'name' => $this->user->name,
         ],
      );
   }
}
