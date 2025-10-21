<?php

namespace Modules\Category\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
   /**
    * Transform the resource into an array.
    *
    * @OA\Schema(
    *    schema="CategoryResponse",
    *    title="Category Response",
    *    @OA\Property(property="id", type="integer", example=1),
    *    @OA\Property(property="name", type="string", example="Electronic")
    * )
    */
   public function toArray(Request $request): array
   {
      return [
         'id' => $this->id,
         'name' => $this->name,
      ];
   }
}
