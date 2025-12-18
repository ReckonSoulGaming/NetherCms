<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_method';
    protected $primaryKey = 'method_id';

    protected $fillable = [
        'method_provider',
        'option_price',
        'option_points_amount',
        'option_points_multiplier',
    ];
}
