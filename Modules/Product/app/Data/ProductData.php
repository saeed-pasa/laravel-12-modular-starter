<?php

namespace Modules\Product\Data;

use Spatie\LaravelData\Data;

class ProductData extends Data
{
   public function __construct(
      public string  $name,
      public ?string $description,
      public int     $price,
   )
   {
   }
}
