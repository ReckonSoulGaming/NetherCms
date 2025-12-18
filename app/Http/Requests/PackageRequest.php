<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{
    /**
     * Authorization for this request (adjust if admin-only).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for creating or updating a package.
     */
public function rules(): array
{
    return [
        
        'package_name'    => 'required|string|max:50',
        'category'        => 'required|exists:packages_category,category_id',
        'package_price'   => 'required|numeric|min:0.01',
        'package_command' => 'required|string|max:1000',

     
        'package_desc'           => 'nullable|string|max:200',
        'package_discount_price' => 'nullable|numeric',
        'cover'                  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'package_features'       => 'nullable|string',
        'badge_text'             => 'nullable|string|max:20',
        'badge_color'            => 'nullable|in:is-danger,is-success,is-warning,is-info,is-primary',
        'ribbon_text'            => 'nullable|string|max:15',
        'is_featured'            => 'sometimes|boolean',
        'stock_limit'            => 'nullable|integer|min:1',
    ];
}


    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'package_name.required'  => 'Package name is required.',
            'package_name.max'       => 'Name too long (maximum 50 characters).',

            'package_desc.max'       => 'Description is too long.',

            'category.required'      => 'Please select a category.',
            'category.exists'        => 'Selected category does not exist.',

            'package_price.required' => 'Package price is required.',
            'package_price.numeric'  => 'Price must be a valid number.',
            'package_price.min'      => 'Price must be at least 0.01.',

            'package_discount_price.lt' => 'Discount price must be lower than the original price.',

            'cover.image'            => 'Cover must be a valid image file.',
            'cover.mimes'            => 'Image must be JPG, JPEG, PNG, or WEBP.',
            'cover.max'              => 'Image too large (maximum 2MB).',

            'package_command.required' => 'Purchase command must be provided.',

            'package_features.required' => 'Please specify at least one package feature.',

            'badge_color.in'         => 'Invalid badge color selected.',

            'stock_limit.integer'    => 'Stock limit must be a valid number.',
        ];
    }

    /**
     * Sanitize and normalize input before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_featured'            => $this->has('is_featured') ? true : false,
            'stock_limit'            => $this->stock_limit ?: null,
            'package_discount_price' => $this->filled('package_discount_price') ? $this->package_discount_price : null,
            'badge_text'             => $this->filled('badge_text') ? $this->badge_text : null,
            'ribbon_text'            => $this->filled('ribbon_text') ? $this->ribbon_text : null,
        ]);
    }
}
