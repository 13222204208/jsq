<?php

namespace App\Http\Controllers\Minapp\Notice;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\JoinTeamNotice;
use App\Http\Controllers\Controller;
use App\Models\TeamNotice;

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
            if($teamInfo){//如果是团队创始人则显示申请加入团队的消息
                $data= JoinTeamNotice::where('team_id',$teamInfo->id)->where('status',0)->where('inviter_user_id',0)->with(['applyUserInfo'=>function($query){
                    $query->select('id', 'username', 'avatar'); // 需要同时查询关联外键的字段
                }])->skip($page)->take($size)->get(['id','user_id','inviter_user_id','msg_content']);
                
                return $this->success($data);
            }
            $data= JoinTeamNotice::where('inviter_user_id',$user->id)->where('status',0)->with(['applyUserInfo'=>function($query){
                $query->select('id', 'username', 'avatar'); // 需要同时查询关联外键的字段
            }])->skip($page)->take($size)->get(['id','user_id','inviter_user_id','msg_content']);

            //$success= TeamNotice::where('user_id',$user->id)->get();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
