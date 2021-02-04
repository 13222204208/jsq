<?php

namespace App\Services;

use App\Repositories\ContactUsRepository;
use Yish\Generators\Foundation\Service\Service;

class ContactUsService extends Service
{
    protected $repository;

    public function __construct(ContactUsRepository $repository)
    {
        $this->repository = $repository;
    }

    
    public function getList($limit,$page)
    {
        $item = $this->repository->list($limit,$page);
        $total = $this->repository->total();

        $data['item'] = $item;
        $data['total'] = $total;

        return $data;
    }

    public function del($id)
    {
        return $this->repository->destroy($id);
    }
}
