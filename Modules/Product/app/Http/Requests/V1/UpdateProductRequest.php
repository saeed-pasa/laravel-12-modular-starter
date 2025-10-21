<?php

namespace Modules\Product\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="UpdateProductRequest",
 *     title="Update Product Request",
 *     description="Request schema for updating an existing product",
 *     @OA\Property(property="name", type="string", example="laptop"),
 *     @OA\Property(property="description", type="string", nullable=true, example="An updated high-quality laptop"),
 *     @OA\Property(property="price", type="integer", example=1400000),
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
class UpdateProductRequest extends FormRequest
{
   public function authorize(): bool
   {
      return Auth::guard('api')->user()->can('edit products');
   }

   public function rules(): array
   {
      return [
         'name' => ['sometimes', 'required', 'string', 'max:255'],
         'description' => ['sometimes', 'nullable', 'string'],
         'price' => ['sometimes', 'required', 'integer', 'min:0'],
         'category_ids' => ['array'],
         'category_ids.*' => ['integer', 'exists:categories,id'],
      ];
   }
}