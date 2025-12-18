<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{
    protected $table = 'general_settings';
    protected $primaryKey = 'setting_id';

    protected $fillable = [
      
        'hostname',
        'hostname_port',
        'rcon_port',
        'rcon_password',
        'websender_port',
        'websender_password',

       
        'website_name',
        'website_desc',
        'website_footer',

       
        'site_tagline',
        'contact_email',
        'homepage_highlight',

      
        'navbar_color',
        'background_image',
        'background_color',
        'primary_color',
        'nav_text_color',

        // Custom style
        'custom_css',
    ];

    /**
     * Hide sensitive server passwords from API / JSON.
     */
    protected $hidden = [
        'rcon_password',
        'websender_password',
    ];

    /**
     * Cast fields to correct types.
     */
    protected $casts = [
        'hostname_port'    => 'integer',
        'rcon_port'        => 'integer',
        'websender_port'   => 'integer',
    ];
}
