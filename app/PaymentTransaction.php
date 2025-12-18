<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $table = 'payment_transactions';
    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'payment_payer_id',
        'payment_provider',
        'payment_method',
        'payment_payer',
        'payment_amount',
        'payment_status'
    ];
}
