<?php

namespace Modules\Product\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="StoreProductRequest",
 *     title="Store Product Request",
 *     description="Request schema for storing a new product",
 *     required={"name", "price"},
 *     @OA\Property(property="name", type="string", example="laptop"),
 *     @OA\Property(property="description", type="string", nullable=true, example="A high-quality laptop"),
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
class StoreProductRequest extends FormRequest
{
   public function authorize(): bool
   {
      return Auth::guard('api')->user()->can('create products');
   }

   public function rules(): array
   {
      return [
         'name' => ['required', 'string', 'max:255'],
         'description' => ['nullable', 'string'],
         'price' => ['required', 'integer', 'min:0'],
         'category_ids' => ['array'],
         'category_ids.*' => ['integer', 'exists:categories,id'],
      ];
   }
}