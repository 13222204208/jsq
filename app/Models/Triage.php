<?php

namespace App\Models;

use App\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Triage extends Model
{
    use HasFactory, Timestamp;

    protected $guarded = [];

    public function userInfo()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
