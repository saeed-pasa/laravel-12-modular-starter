<?php

namespace Modules\User\app\Data;

use Spatie\LaravelData\Data;

class RegisterData extends Data
{
   public function __construct(
      public string $name,
      public string $email,
      public string $password,
   ) {
   }
}
