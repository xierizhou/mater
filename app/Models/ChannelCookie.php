<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelCookie extends Model
{
    protected $dateFormat = 'U';

    protected $fillable = [
        'channel_id','type','cookie',
    ];
}
