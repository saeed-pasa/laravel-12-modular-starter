<?php

namespace Modules\Category\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCategoryRequest extends FormRequest
{
   public function authorize(): bool
   {
      return Auth::guard('api')->user()->can('create categories');
   }

   public function rules(): array
   {
      return [
         'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
      ];
   }
}
