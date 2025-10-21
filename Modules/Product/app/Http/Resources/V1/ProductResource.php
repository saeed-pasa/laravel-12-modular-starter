<?php

namespace Modules\Product\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Http\Resources\V1\CategoryResource;

/**
 * @OA\Schema(
 *     schema="ProductResource",
 *     title="Product Resource",
 *     description="Product resource representation",
 *     @OA\Property(
 *         property="data",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="laptop"),
 *         @OA\Property(property="description", type="string", example="A high-quality laptop", nullable=true),
 *         @OA\Property(property="price", type="integer", example=1500000),
 *         @OA\Property(
 *             property="categories",
 *             type="array",
 *             description="Array of category IDs associated with the product",
 *             example={1, 2, 3},
 *             @OA\Items(ref="#/components/schemas/CategoryResponse"),
 *         ),
 *         @OA\Property(property="created_at", type="string", format="date-time", example="2025-10-20 14:30:00"),
 *         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-10-20 14:30:00")
 *     )
 * )
 */
class ProductResource extends JsonResource
{
   public static $wrap = 'data';

   /**
    * Transform the resource into an array.
    *
    * @return array<string, mixed>
    */
   public function toArray(Request $request): array
   {
      return [
         'id' => $this->id,
         'name' => $this->name,
         'description' => $this->description,
         'price' => $this->price,
         // 'price_formatted' => number_format($this->price) . 'toman',
         'categories' => CategoryResource::collection($this->whenLoaded('categories')),
         'created_at' => $this->created_at->format('Y-m-d H:i:s'),
         'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
      ];
   }
}
