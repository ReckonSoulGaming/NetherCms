<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlertRequest extends FormRequest
{
    /**
     * Allow all admins to access (adjust with permissions if needed)
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for creating or updating a alert.
     */
    public function rules(): array
    {
        return [
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'tag'        => 'required|string|max:50',
            'seeinstore' => 'nullable|in:on,1',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'title.required'   => 'Please provide a title for the alert.',
            'content.required' => 'Content cannot be empty.',
            'tag.required'     => 'Please enter a tag for this alert.',
        ];
    }
}
