<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServerSettings extends Model
{
    protected $table = 'server_settings';
    protected $primaryKey = 'server_id';

    protected $fillable = [
        'server_name',
        'hostname',
        'hostname_port',
        'hostname_query_port',
        'rcon_port',
        'rcon_password',
        'websender_port',
        'websender_password',
    ];

   
    protected $hidden = [
        'rcon_password',
        'websender_password',
    ];

    /**
     * Cast ports to integers (optional but cleaner).
     */
    protected $casts = [
        'hostname_port'        => 'integer',
        'hostname_query_port'  => 'integer',
        'rcon_port'            => 'integer',
        'websender_port'       => 'integer',
    ];
}
