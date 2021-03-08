<?php

namespace App\Models;

use App\Traits\ImgUrl;
use App\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consult extends Model
{
    use HasFactory, Timestamp, ImgUrl;

    public function consultType()
    {
        return $this->hasOne('App\Models\ConsultType','id','consult_type_id');
    }

    public function getContentAttribute($value)
    {
        return $this->replaceImgUrl($value);
    }
}
