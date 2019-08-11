<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $dateFormat = "U";

    protected $fillable = [
        'name','discount','sort'
    ];
}
