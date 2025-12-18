<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'users_roles';
    protected $primaryKey = 'role_id';

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }
}
