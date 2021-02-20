<?php

namespace App\Models;

use App\Traits\Timestamp;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tab extends Model
{
    use HasFactory, Timestamp, NodeTrait;
    protected $guarded = [];
}
