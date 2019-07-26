<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Channel
 *
 * @property int $id
 * @property string $name 渠道名称，内部名称
 * @property string $alias_name 渠道别名，主要用这个显示给用户看
 * @property string $domain 域名
 * @property string|null $username 渠道用户名
 * @property string|null $password 密码
 * @property int|null $state 0禁用 1正常 2过期
 * @property string|null $cookie 登录的cookie,用于保持登录
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereAliasName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereCookie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereUsername($value)
 * @mixin \Eloquent
 */
class Channel extends Model
{
    protected $fillable = [
        'name','alias_name','domain','username','password','state'
    ];

    public function cookies()
    {
        return $this->hasMany(ChannelCookie::class);
    }
}
