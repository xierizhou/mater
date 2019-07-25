<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserDownloadLog
 *
 * @property int $id
 * @property int $user_id
 * @property int $material_id
 * @property string $source_url 用户提交的下载URL
 * @property string $download_url 解析得到的下载URL
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserDownloadLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserDownloadLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserDownloadLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserDownloadLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserDownloadLog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserDownloadLog whereDownloadUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserDownloadLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserDownloadLog whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserDownloadLog whereSourceUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserDownloadLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserDownloadLog whereUserId($value)
 * @mixin \Eloquent
 */
class UserDownloadLog extends Model
{
    protected $fillable = [
        'user_id','material_id','material_file_id','source_url'
    ];
}
