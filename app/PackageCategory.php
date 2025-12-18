<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageCategory extends Model
{
    protected $table = 'packages_category';
    protected $primaryKey = 'category_id';
    public $timestamps = true;

    protected $fillable = [
        'category_name',
        'description',
        'category_image',
        'badge_text',
        'badge_color',
        'ribbon_text',
        'is_featured',
        'sort_order',
        'is_visible',
        'background_color',
        'custom_css',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_visible'  => 'boolean',
        'sort_order'  => 'integer',
    ];

    public function packages()
    {
        return $this->hasMany(Packages::class, 'category_id');
    }
}
