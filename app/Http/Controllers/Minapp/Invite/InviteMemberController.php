<?php

namespace App\Http\Controllers\Minapp\Invite;

use App\Models\Team;
use App\Models\User;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use App\Models\JoinTeamNotice;
use App\Http\Controllers\Controller;
use App\Models\TeamNotice;

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

    public function inviteMember(Request $request)
    {
        try {
            $memberId= $request->member_id;
            if (empty($memberId)) {
                return $this->failed('成员ID不能为空');
            }
            $user= auth('api')->user(); 
            if ($user->is_initiator == 1) {
                return $this->failed('你不是团队创始人');
            }
            $team= Team::where('initiator_id',$user->id)->where('status',1)->first();
            if (!$team) {
                return $this->failed('你不是团队创始人');
            }
            $mid = array_unique(explode(',',$memberId));//邀请的成员id
            $userID = $user->id;//邀请人的id;
            $msgContent= '邀请你加入'.$team->title;
            $teamId= $team->id;

            foreach ($mid as $value) {
                JoinTeamNotice::create([
                    'inviter_user_id' => intval($value),
                    'team_id'=> $teamId,
                    'msg_content' => $msgContent,
                    'user_id' => $userID
                ]);
            }

            return $this->success();

        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    public function consent(Request $request)
    {
        try {

            $id = intval($request->id);
            $state = intval($request->state);


            $join= JoinTeamNotice::find($id);
            $join->status = $state;
            $join->save();

            $inviter_user_id = intval($join->inviter_user_id);

            if($state === 1){
                if ($inviter_user_id != 0) {
                    $userID= intval($inviter_user_id);
                    $joinUser= User::find($userID);
                    $msg= $joinUser->username.'成功加入团队';
                }else{
                    $userID= $join->user_id;
                    $joinTeam= Team::find($join->team_id);
                    $msg= '你已经成功加入'.$joinTeam->title;
                }

                $teamMember= new TeamMember;
                $teamMember->team_id= $join->team_id;
                $teamMember->user_id= $userID;
                $teamMember->save();

                $teamNotice= new TeamNotice();
                $teamNotice->team_id= $join->team_id;
                $teamNotice->user_id= $userID;
                $teamNotice->content= $msg;
                $teamNotice->save();
            }
            return $this->success();


        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
