<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReplaceDownload extends Model
{
    protected $dateFormat = 'U';

    protected $fillable = [
        'replace_id','material_id','material_file_id','email_id','email','download_url','pic_no','title',
    ];

    public function replace(){
        return $this->belongsTo(Replace::class);
    }
}
