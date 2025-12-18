<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:100',
            'avatar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'player_type' => 'required|in:java,bedrock',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'A display name is required.',
            'avatar.image'        => 'The uploaded file must be an image.',
            'avatar.mimes'        => 'Avatar must be JPG, JPEG, PNG, or WEBP format.',
            'avatar.max'          => 'Avatar size cannot exceed 2MB.',

           
            'player_type.required' => 'Please select your player type.',
            'player_type.in'       => 'Player type must be either Java or Bedrock.',
        ];
    }
}
