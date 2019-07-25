<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialPrice extends Model
{
    protected $dateFormat = 'U';

    protected $fillable = [
        'material_id','name','price','cycle','status','unsale_reason'
    ];

    public function material(){
        return $this->belongsTo(Material::class);
    }

}
