<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $table = 'logs';
    protected $primaryKey = 'log_id';

    protected $fillable = [
        'user_id',
        'type',
        'action_detail',
        'ip',           
        'username',     
    ];

    protected $casts = [
        'user_id' => 'integer',
        'log_id'  => 'integer',
    ];
}
