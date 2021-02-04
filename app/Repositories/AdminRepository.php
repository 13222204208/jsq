<?php

namespace App\Repositories;

use App\Models\Admin;
use Yish\Generators\Foundation\Repository\Repository;

class AdminRepository extends Repository
{
    protected $model;

    public function __construct(Admin $model)
    {
        $this->model= $model;
    }
}
