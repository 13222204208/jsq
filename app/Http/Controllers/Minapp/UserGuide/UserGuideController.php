<?php

namespace App\Http\Controllers\Minapp\UserGuide;

use App\Models\UserGuide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserGuideController extends Controller
{
    public function userGuide()
    {
        try {
            $data= UserGuide::find(1);
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
