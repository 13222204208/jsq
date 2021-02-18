<?php

namespace App\Http\Controllers\Minapp\Notice;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\JoinTeamNotice;
use App\Http\Controllers\Controller;

class NoticeController extends Controller
{
    public function msgNotice(Request $request)
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
            $user= auth('api')->user(); 
            $teamInfo= Team::where('initiator_id',$user->id)->where('team_state',1)->first();
            if($teamInfo){
                $data= JoinTeamNotice::where('team_id',$teamInfo->id)->with(['applyUserInfo'=>function($query){
                    $query->select('id', 'username', 'avatar'); // 需要同时查询关联外键的字段
                }])->skip($page)->take($size)->get(['user_id','msg_content']);
                
                return $this->success($data);
            }
            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
