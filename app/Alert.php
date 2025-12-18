<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $table = 'alerts';
    protected $primaryKey = 'alert_id';

    protected $fillable = [
        'alert_title',
        'alert_content',
        'alert_views',
        'alert_tag',
        'alert_show_on_store',
    ];
}
