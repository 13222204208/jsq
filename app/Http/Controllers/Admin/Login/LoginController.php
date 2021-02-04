<?php

namespace App\Http\Controllers\Admin\Login;

use Illuminate\Http\Request;
use App\Services\AdminService;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    protected $adminService;
    
    public function __construct(AdminService $adminService)
    {
        $this->adminService= $adminService;
    }

    public function login(Request $request)
    {
        $data = $request->all();
        return $this->adminService->adminLogin($data);
    }

    public function info()
    {
        $user= auth('admin')->user();
        return $this->success($user);
    }

    public function logout()
    {
        return $this->success();
    }
}
