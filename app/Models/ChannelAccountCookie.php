<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelAccountCookie extends Model
{
    protected $dateFormat = 'U';

    protected $fillable = [
        'channel_account_id','type','cookie'
    ];
}
