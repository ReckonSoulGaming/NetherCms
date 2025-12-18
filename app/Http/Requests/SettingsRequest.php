<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    /**
     * Allow admin or authorized users to update settings.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for system/settings update.
     */
    public function rules(): array
    {
        return [
    
            'hostname'       => 'required|string|max:255',
            'hostname_port'  => 'required|numeric',
            'rcon_port'      => 'required|numeric',
            'rcon_password'  => 'required|string|max:255',

           
            'website_name'   => 'required|string|max:255',
            'website_desc'   => 'required|string|max:500',

        
            'site_tagline'       => 'nullable|string|max:255',
            'contact_email'      => 'nullable|email|max:255',
            'homepage_highlight' => 'nullable|string|max:500',

            'navbar_color'     => 'nullable|string|max:50',
            'background_image' => 'nullable|string|max:255',
            'background_color' => 'nullable|string|max:50',
            'primary_color'    => 'nullable|string|max:50',
            'nav_text_color'   => 'nullable|string|max:50',

            'custom_css'       => 'nullable|string|max:5000',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'hostname.required'      => 'Hostname cannot be empty.',
            'hostname_port.required' => 'Hostname port cannot be empty.',
            'hostname_port.numeric'  => 'Hostname port must be a number.',

            'rcon_port.required'     => 'RCON port cannot be empty.',
            'rcon_port.numeric'      => 'RCON port must be a number.',

            'rcon_password.required' => 'RCON password cannot be empty.',

            'website_name.required'  => 'Website name is required.',
            'website_desc.required'  => 'Website description is required so users can understand your site.',
            
            'contact_email.email'    => 'The contact email must be a valid email address.',
        ];
    }
}
