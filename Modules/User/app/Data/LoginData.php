<?php

namespace Modules\User\Data;

use Spatie\LaravelData\Data;

class LoginData extends Data
{
   public function __construct(
      public string $email,
      public string $password,
   )
   {
   }
}
