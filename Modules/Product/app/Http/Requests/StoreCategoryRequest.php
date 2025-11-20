<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:pgsql.categories,slug'],
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
