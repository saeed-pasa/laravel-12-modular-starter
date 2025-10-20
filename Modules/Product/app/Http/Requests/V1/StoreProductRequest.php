<?php

namespace Modules\Product\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
      ];
   }
}
