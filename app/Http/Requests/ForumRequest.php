<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForumRequest extends FormRequest
{
    /**
     * Allow access (adjust if needed for permissions)
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for forum category creation/update.
     */
    public function rules(): array
    {
        return [
            'category_name' => 'required|string|max:255',
            'description'   => 'required|string|max:1000',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'category_name.required' => 'You must enter a category title.',
            'description.required'   => 'Please enter the category description.',
        ];
    }
}
