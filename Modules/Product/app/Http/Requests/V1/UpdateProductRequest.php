<?php

namespace Modules\Product\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
      ];
   }
}
