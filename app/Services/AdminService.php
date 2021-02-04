<?php

namespace App\Services;

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use App\Repositories\AdminRepository;
use Yish\Generators\Foundation\Service\Service;

class AdminService
{
    use ApiResponse;
    protected $repository;

    public function __construct(AdminRepository $repository)
    {
        $this->repository = $repository;
    }

    public function adminLogin($data)
    {
        $user= $this->repository->firstBy('username',$data['username']);

        if(!$user){
            return  $this->failed('用户不存在');
          }
  
          if (!Hash::check($data['password'],$user->password)) {
              return  $this->failed('密码不正确');
          }
          
          if (! $token = auth('admin')->attempt($data)) {
              return  $this->failed();
          }
          $xToken['token'] = $token;
          
       
          return $this->success($xToken);
    }
}
