<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommandQueue extends Model
{
    protected $table = 'command_queue';

    protected $fillable = [
        'package_id',
        'user_id',
        'server_id',
        'player_name',
        'command',
        'status',
        'executed_at',
    ];
}
