<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'description' => 'nullable|max:65536',
            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'old_price' => ['nullable', 'regex:/^\d+(\.\d{1,2})?$/'],
            'count' => 'nullable|numeric',
            'is_infinitely' => 'nullable',
            'category_id' => 'required|' . Rule::exists('categories', 'id'),
        ];
    }
}
