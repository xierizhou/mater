<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MaterialFile
 *
 * @property int $id
 * @property int $material_id
 * @property int $channel_id
 * @property string $title 文件名称
 * @property string $item_no 编号
 * @property string $source 下载页面的URL
 * @property int|null $status 0失效  1正常
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFile whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFile whereItemNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFile whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFile whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFile whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFile whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFile whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MaterialFile extends Model
{
    protected $fillable = [
        'material_id','channel_id','item_no','title','source','status','oss','is_oss'
    ];

    public function material(){
        return $this->belongsTo(Material::class);
    }

    public function attachments()
    {
        return $this->hasMany(MaterialFileAttachments::class);
    }
}
