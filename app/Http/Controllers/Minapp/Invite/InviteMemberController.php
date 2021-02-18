<?php

namespace App\Http\Controllers\Minapp\Invite;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InviteMemberController extends Controller
{
    public function memberList(Request $request)//邀请新成员列表
    {
        try {

            $size = 10;
            if($request->size){
                $size = $request->size;
            }
    
            $page = 0;
            if($request->page){
                $page = ($request->page -1)*$size;
            }
            $initiatorId= Team::pluck('initiator_id');

            if($request->userName){
                $username= $request->userName; 
                $data= User::whereNotIn('id',$initiatorId)->where('username','like','%'.$username.'%')->skip($page)->take($size)->get(['id','username','avatar']);      
                return $this->success($data);
            }
            $data= User::whereNotIn('id',$initiatorId)->skip($page)->take($size)->get(['id','username','avatar']);      
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
