<?php

namespace Modules\Product\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class ProductData extends Data
{
   public function __construct(
      public string|Optional      $name,
      public string|null|Optional $description,
      public int|Optional         $price,
   )
   {
   }
}
