<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelAccount extends Model
{
    protected $dateFormat = 'U';

    protected $fillable = [
        'channel_id','username','password','extra','status'
    ];

    public function auth()
    {
        return $this->hasMany(ChannelAccountAuth::class);
    }
}
