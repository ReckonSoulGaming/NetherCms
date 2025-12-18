<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageHistory extends Model
{
    protected $table = 'package_history';
    protected $primaryKey = 'history_id';

    protected $fillable = ['package_id', 'buyer_id'];

  
    public function package()
    {
        return $this->belongsTo(Packages::class, 'package_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
