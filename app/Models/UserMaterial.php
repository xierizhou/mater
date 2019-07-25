<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMaterial extends Model
{
    protected $dates = ['start_time'];

    protected $fillable = [
        'user_id','material_id','total','current','start_time','end_time','is_daily_reset','status'
    ];

    protected $dateFormat = 'U';

    /**
     * 获取对应用户
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 获取对应素材网站
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
