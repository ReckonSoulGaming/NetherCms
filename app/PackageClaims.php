<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageClaims extends Model
{
    protected $table = 'packages_claims';
    protected $primaryKey = 'claim_id';

    protected $fillable = [
        'package_id',
        'owner_id',
        'is_claimed',
    ];

    public function package()
    {
        return $this->belongsTo(Packages::class, 'package_id', 'package_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
}
