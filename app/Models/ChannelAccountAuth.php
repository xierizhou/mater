<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelAccountAuth extends Model
{
    protected $dateFormat = "U";

    protected $fillable = [
        'channel_account_id','material_id','total','current','is_daily_reset','reset_number'
    ];
}
