<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category');
        
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('pgsql.categories', 'slug')->ignore($categoryId)
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required',
            'slug.unique' => 'This slug is already taken',
        ];
    }
}
