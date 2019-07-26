<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $dateFormat = 'U';

    protected $fillable = [
        'sender','addressee','title','is_success','fail_message','content','send_time'
    ];
}
