<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'role_id',
        'profile_image_path',      
        'ip',
        'lastlogin',
        'isLogged',      
        'player_type', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'lastlogin'         => 'datetime',
        'isLogged'          => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function topics()
    {
        return $this->hasMany(ForumTopic::class, 'topic_author_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(ForumComment::class, 'comment_author_id', 'id');
    }

    public function claims()
    {
        return $this->hasMany(PackageClaims::class, 'owner_id', 'id');
    }

    public function history()
    {
        return $this->hasMany(PackageHistory::class, 'buyer_id', 'id');
    }
}
