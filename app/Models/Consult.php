<?php

namespace App\Models;

use App\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consult extends Model
{
    use HasFactory, Timestamp;

    public function consultType()
    {
        return $this->hasOne('App\Models\ConsultType','id','consult_type_id');
    }

    public function getContentAttribute($value)
    {
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

        //$url = $http_type.$_SERVER['SERVER_NAME'].'/goods/';
        $url = 'http://jsq.com/';
        $pregRule = "/<[img|IMG].*?src=[\‘|\"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\‘|\"].*?[\/]?>/";
        $list = preg_replace($pregRule, '<img src="'.$url.'${1}" style="max-width:100%">', $value);
        return $list;
    }
}
