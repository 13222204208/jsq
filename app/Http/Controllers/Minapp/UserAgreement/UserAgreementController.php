<?php

namespace App\Http\Controllers\Minapp\UserAgreement;

use Illuminate\Http\Request;
use App\Models\UserAgreement;
use App\Http\Controllers\Controller;

class UserAgreementController extends Controller
{
    public function agreement(Request $request)
    {
        try {
            if(!$request->type){
               return  $this->failed('类型不能为空');
            }

            $data= UserAgreement::where('type',$request->type)->first();     
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
