<?php

namespace App\Models;

use App\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory, Timestamp;

    public function userInfo()
    {
        return $this->hasOne('App\Models\User','id','initiator_id');
    }
}
