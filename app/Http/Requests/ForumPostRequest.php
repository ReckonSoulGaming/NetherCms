<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForumPostRequest extends FormRequest
{
    /**
     * Allow all authenticated users to create/edit posts.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for forum posts.
     */
    public function rules(): array
    {
        return [
            'category'     => 'required',
            'topic'        => 'required|string|max:255',
            'content'      => 'required|string',
            'is_published' => 'nullable',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'category.required' => 'Please select a category for your post.',
            'topic.required'    => 'Topic cannot be empty.',
            'content.required'  => 'Content cannot be empty.',
        ];
    }
}
