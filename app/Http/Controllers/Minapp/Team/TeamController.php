<?php

namespace App\Http\Controllers\Minapp\Team;

use App\Models\Team;
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
}
