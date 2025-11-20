<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Product\Enums\Rating;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:mysql.products,id'],
            'author_name' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', Rule::in([1, 2, 3, 4, 5])],
            'comment' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Product is required',
            'product_id.exists' => 'Product does not exist',
            'author_name.required' => 'Author name is required',
            'rating.required' => 'Rating is required',
            'rating.in' => 'Rating must be between 1 and 5',
            'comment.required' => 'Comment is required',
        ];
    }
}
