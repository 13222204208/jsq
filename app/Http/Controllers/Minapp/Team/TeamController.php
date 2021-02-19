<?php

namespace App\Http\Controllers\Minapp\Team;

use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use App\Models\JoinTeamNotice;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function team(Request $request)
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
            if($request->teamName){
                $data= Team::where('title','like','%'.$request->teamName.'%')->skip($page)->take($size)->get();      
                return $this->success($data);
            }
            $data= Team::skip($page)->take($size)->get();      
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    public function joinTeam(Request $request)
    {
        try {
            $user= auth('api')->user(); 
            if (intval($request->team_id)=== 0) {
                return $this->failed('团队id不存在');
            }

            $state= Team::where('initiator_id',intval($user->id))->first();
            if ($state) {
                return $this->failed('团队创始人不能申请加入其它团队');
            }else{
                $state= TeamMember::where('team_id',intval($request->team_id))->where('user_id',$user->id)->first();
                if ($state) {
                    return $this->failed('你已经加入过此团队');
                }

                $info= JoinTeamNotice::where('team_id',intval($request->team_id))->where('user_id',$user->id)->first();
                if ($info) {
                    return $this->failed('你已申请此团队');
                }
                $teamName = Team::find(intval($request->team_id));
                $joinTeam = new JoinTeamNotice();
                $joinTeam->team_id = intval($request->team_id);
                $joinTeam->user_id = $user->id;
                $joinTeam->msg_content= "申请加入".$teamName->title;
                $joinTeam->save();
                return $this->success();
            }
            
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    public function myTeam(Request $request)
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


            if (intval($request->team_id)) {
                $member= TeamMember::where('team_id',$request->team_id)->where('status',1)->with(['userInfo'=>function($query){
                    $query->select('id', 'username', 'avatar'); // 需要同时查询关联外键的字段
                }])->skip($page)->take($size)->orderBy('is_initiator','desc')->get(['id','user_id','is_initiator']);
                return $this->success($member);
            }

            $user= auth('api')->user(); 

            $teamID= TeamMember::where('user_id',$user->id)->where('status',1)->pluck('team_id');
            $data= Team::whereIn('id',$teamID)->where('status',1)->skip($page)->take($size)->get(['id','title']);
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    public function teamKick(Request $request)
    {
        try {
            $user= auth('api')->user(); 
            if ($user->is_initiator == 1) {
                return $this->failed('你不是团队创始人，无法踢除队员');
            }

            $memberId= intval($request->user_id);
            if (!$memberId) {
                return $this->failed('缺少成员id');
            }
            $team= Team::where('initiator_id',$user->id)->first();
            TeamMember::where('team_id',$team->id)->where('user_id',$memberId)->delete();
            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
