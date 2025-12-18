<?php

function currency_symbol()
{
    $currency = session('currency', 'INR');

    switch ($currency) {
        case 'USD':
            return '$';
        case 'EUR':
            return '€';
        default:
            return '₹';
    }
}

function currency_convert($amount)
{
    $currency = session('currency', 'INR');


    $rates = [
        'INR' => 1,    // Base currency
        'USD' => 83,   // ₹83 = $1
        'EUR' => 90,   // ₹90 = €1
    ];

    if (!isset($rates[$currency])) {
        return $amount; 
    }

    return round($amount / $rates[$currency], 2);
}
