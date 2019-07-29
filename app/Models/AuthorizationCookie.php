<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorizationCookie extends Model
{
    protected $dateFormat = 'U';

    protected $fillable = [
        'authorization_id','uin','key','value'
    ];
}
