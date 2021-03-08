<?php

namespace App\Models;

use App\Traits\ImgUrl;
use App\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGuide extends Model
{
    use HasFactory, Timestamp, ImgUrl;

    public function getContentAttribute($value)
    {
        return $this->replaceImgUrl($value);
    }
}
