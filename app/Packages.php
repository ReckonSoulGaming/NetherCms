<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Packages extends Model
{
    use SoftDeletes;

    protected $table = 'packages';
    protected $primaryKey = 'package_id';
    public $timestamps = true; 

   
    protected $fillable = [
        'package_name',
        'package_desc',
        'package_image_path',
        'package_price',
        'package_discount_price',
        'category_id',
        'package_command',       
        'package_features',      
        'badge_text',         
        'badge_color',       
        'ribbon_text',       
        'is_featured',       
        'stock_limit',       
        'package_sold',
    ];

    
    protected $casts = [
        'package_price'         => 'decimal:2',
        'package_discount_price'=> 'decimal:2',
        'stock_limit'        => 'integer',
        'is_featured'        => 'boolean',
        'package_sold'          => 'integer',
    ];

   
    public function category()
    {
        return $this->belongsTo(PackageCategory::class, 'category_id');
    }

    public function claim()
    {
        return $this->hasMany(PackageClaims::class, 'package_id');
    }

    public function history()
    {
        return $this->hasMany(PackageHistory::class, 'package_id'); 
    }

    public function getFeaturesListAttribute()
    {
        return $this->package_features
            ? array_filter(explode("\n", str_replace("\r\n", "\n", $this->package_features)))
            : [];
    }
}