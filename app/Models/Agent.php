<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $dateFormat = "U";

    protected $fillable = [
        'grade_id','username','password','nickname','email','mobile','remarks','status','domain','sub_domain','logo'
    ];

    public function grade(){
        return $this->belongsTo(Grade::class);
    }
}
