<?php

namespace App\Http\Controllers\Minapp\Notice;

use App\Models\Team;
use App\Models\TeamNotice;
use App\Models\UserNotice;
use Illuminate\Http\Request;
use App\Models\JoinTeamNotice;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

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
                }])->orderBy('created_at','desc')->skip($page)->take($size)->get(['id','user_id','inviter_user_id','msg_content']);
                

                $data2= TeamNotice::where('team_id',$teamInfo->id)->orderBy('created_at','desc')->get(['id','content','created_at']);
                $all['list1']= $data;
                $all['list2']= $data2;

                JoinTeamNotice::where('team_id',$teamInfo->id)->where('status',0)->where('inviter_user_id',0)->update([
                    'state'=>1//已读消息
                ]);
                TeamNotice::where('team_id',$teamInfo->id)->update([
                    'state'=>1
                ]);
                return $this->success($all);
            }
            $data= JoinTeamNotice::where('inviter_user_id',$user->id)->where('status',0)->with(['applyUserInfo'=>function($query){
                $query->select('id', 'username', 'avatar'); // 需要同时查询关联外键的字段
            }])->orderBy('created_at','desc')->get(['id','user_id','inviter_user_id','msg_content']);

            $data2= UserNotice::where('user_id',$user->id)->skip($page)->take($size)->orderBy('created_at','desc')->get(['id','content','created_at']);
            $all['list1']= $data;
            $all['list2']= $data2;

            JoinTeamNotice::where('inviter_user_id',$user->id)->where('status',0)->update([
                'state'=>1//已读消息
            ]);
            UserNotice::where('user_id',$user->id)->update([
                'state'=>1//已读消息
            ]);
            return $this->success($all);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    public function noticeCount(Request $request)
    {
        try {
            $user= auth('api')->user(); 
            $teamInfo= Team::where('initiator_id',$user->id)->where('team_state',1)->first();
            if($teamInfo){//如果是团队创始人则显示申请加入团队的消息
                $count1 = JoinTeamNotice::where('team_id',$teamInfo->id)->where('status',0)->where('inviter_user_id',0)->where('state',0)->count();
                $count2= TeamNotice::where('team_id',$teamInfo->id)->where('state',0)->count();
                $count= $count1+$count2;
                return $this->success($count);
            }

            $count1= JoinTeamNotice::where('inviter_user_id',$user->id)->where('status',0)->where('state',0)->count();
            $count2= UserNotice::where('user_id',$user->id)->where('state',0)->count();
            $count= $count1+$count2;
            return $this->success($count);
            
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
