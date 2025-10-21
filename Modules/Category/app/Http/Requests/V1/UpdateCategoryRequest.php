<?php

namespace Modules\Category\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
   public function authorize(): bool
   {
      return Auth::guard('api')->user()->can('edit categories');
   }

   public function rules(): array
   {
      $categoryId = $this->route('category')->id;

      return [
         'name' => [
            'sometimes',
            'required',
            'string',
            'max:255',
            Rule::unique('categories', 'name')->ignore($categoryId),
         ],
      ];
   }
}
