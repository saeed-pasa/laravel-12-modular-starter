<?php

namespace Modules\Product\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

/**
 * @OA\Schema(
 *     schema="ProductRequest",
 *     title="Product Request Body",
 *     description="Schema for creating or editing a product",
 *     required={"name", "price"},
 *     @OA\Property(property="name", type="string", example="laptop"),
 *     @OA\Property(property="description", type="string", nullable=true, example="A high-quality laptop with advanced features"),
 *     @OA\Property(property="price", type="integer", example=1500000),
 *     @OA\Property(
 *         property="category_ids",
 *         type="array",
 *         description="Array of category IDs to associate with the product",
 *         example={1, 2, 3},
 *         @OA\Items(
 *             type="integer"
 *         )
 *     )
 * )
 */
class ProductData extends Data
{
   public function __construct(
      public string              $name,
      public ?string             $description,
      public int                 $price,
      public array|null|Optional $category_ids,
   )
   {
   }
}