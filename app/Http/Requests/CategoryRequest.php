<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Authorization logic (allow or restrict form usage)
     */
    public function authorize(): bool
    {
        return true; // Replace with admin check if needed
    }

    /**
     * Validation rules for category creation or update
     */
    public function rules(): array
    {
        return [
            'category_name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('packages_category', 'category_name')
                    ->ignore($this->route('category')),
            ],

            'category_image'   => 'nullable|image|mimes:png,jpg,jpeg,webp,gif|max:5120',
            'description'      => 'nullable|string|max:1000',
            'badge_text'       => 'nullable|string|max:20',
            'badge_color'      => 'nullable|in:is-danger,is-success,is-warning,is-info,is-primary',
            'ribbon_text'      => 'nullable|string|max:15',
            'is_featured'      => 'nullable|in:1,on',
            'sort_order'       => 'nullable|integer|min:0',
            'background_color' => 'nullable|regex:/^#[A-Fa-f0-9]{6}$/',
            'custom_css'       => 'nullable|string|max:2000',
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'category_name.required' => 'Please enter a category name.',
            'category_name.unique'   => 'This category name already exists.',
            'category_image.image'   => 'Please upload a valid image file.',
            'category_image.max'     => 'The image is too large (maximum size is 5MB).',
        ];
    }
}
