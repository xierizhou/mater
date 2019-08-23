<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MaterialFileAttachments
 *
 * @property int $id
 * @property int $material_file_id
 * @property string|null $title
 * @property string|null $source 源下载
 * @property string|null $path 加速下载
 * @property string|null $local 本地下载
 * @property float|null $size 大小 单位b
 * @property string|null $format 文件格式
 * @property mixed|null $extra 其它信息 json格式
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFileAttachments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFileAttachments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFileAttachments query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFileAttachments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFileAttachments whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFileAttachments whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFileAttachments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFileAttachments whereLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFileAttachments whereMaterialFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFileAttachments wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFileAttachments whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFileAttachments whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFileAttachments whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MaterialFileAttachments whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MaterialFileAttachments extends Model
{
    protected $fillable = [
        'material_file_id','title','source','path','local','size','format','extra'
    ];

    public function materialFile()
    {
        return $this->belongsTo(MaterialFile::class);
    }
}
