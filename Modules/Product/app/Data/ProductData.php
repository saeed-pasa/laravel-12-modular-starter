<?php

namespace Modules\Product\Data;

use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     schema="ProductRequest",
 *     title="Product Request Body",
 *     description="Schema for creating or editing a product",
 *     required={"name", "price"},
 *     @OA\Property(property="name", type="string", example="laptop"),
 *     @OA\Property(property="description", type="string", nullable=true, example="description"),
 *     @OA\Property(property="price", type="integer", example=500000)
 * )
 */
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