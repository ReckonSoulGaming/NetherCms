<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditorRequest extends FormRequest
{
    /**
     * Allow admin/user editor access (adjust if needed)
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:255',
            'points'   => 'required|numeric|min:0',
            'password' => 'nullable|string|min:6',
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'name.required'   => 'You must enter a name.',

            'email.required'  => 'An email address is required.',
            'email.email'     => 'Please provide a valid email address.',

            'points.required' => 'You must enter the points amount.',
            'points.numeric'  => 'Points value must be a number.',
            'points.min'      => 'Points cannot be negative.',

            'password.min'    => 'Password must be at least 6 characters.',
        ];
    }
}
