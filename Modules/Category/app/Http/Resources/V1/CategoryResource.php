<?php

namespace Modules\Category\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @OA\Schema(
 *    schema="CategoryResponse",
 *    title="Category Response",
 *    @OA\Property(property="id", type="integer", example=1),
 *    @OA\Property(property="name", type="string", example="Electronic")
 * )
 *
 * @OA\Schema(
 *    schema="CategoryResourceWrapped",
 *    @OA\Property(property="data", ref="#/components/schemas/CategoryResponse")
 * )
 */
class CategoryResource extends JsonResource
{

   public static $wrap = 'data';

   public function toArray(Request $request): array
   {
      return [
         'id' => $this->id,
         'name' => $this->name,
      ];
   }
}
