<?php

namespace App\Repositories;

use App\Models\ContactUs;
use Yish\Generators\Foundation\Repository\Repository;

class ContactUsRepository extends Repository
{
    protected $model;

    public function __construct(ContactUs $model)
    {
        $this->model= $model;
    }

    public function list($limit,$page)//查询列表
    {
        return $this->model->skip($page)->take($limit)->orderBy('created_at','desc')->get();
    }

    public function total()//计算条数
    {
        return $this->model->count();
    }
}
