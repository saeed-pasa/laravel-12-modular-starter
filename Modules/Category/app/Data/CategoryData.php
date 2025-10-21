<?php

namespace Modules\Category\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

/**
 * @OA\Schema(
 *    schema="CategoryRequest",
 *    title="Category Request Body",
 *    required={"name"},
 *    @OA\Property(property="name", type="string", example="clothes")
 * )
 */
class CategoryData extends Data
{
   public function __construct(
      public string|Optional $name,
   )
   {
   }
}
