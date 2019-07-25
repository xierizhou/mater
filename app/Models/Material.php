<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Material
 *
 * @property int $id
 * @property string $name 名称
 * @property string $domain 官网域名
 * @property string|null $site 网站标识
 * @property string|null $logo logo
 * @property int $state 0禁用 1正常
 * @property string|null $state_cause 停用原因
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Channel[] $channel
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Material onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereStateCause($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Material withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Material withoutTrashed()
 * @mixin \Eloquent
 */
class Material extends Model
{
    use SoftDeletes;

    //设置表名
    public $table = 'materials';

    //设置日期时间格式
    //public $dateFormat = 'U';

    protected $fillable = [
        'name','domain','logo','state','state_cause','site','instructions'
    ];

    protected $dates = ['delete_at'];

    public function channel(){
        return $this->belongsToMany(Channel::class,'material_channels')->where('state',1);
    }

}
