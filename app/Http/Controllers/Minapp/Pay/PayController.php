<?php

namespace App\Http\Controllers\Minapp\Pay;

use App\Models\Team;
use App\Models\User;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Yansongda\LaravelPay\Facades\Pay;

class PayController extends Controller
{
    public function payMember(Request $request)
    {
        try {
            $user= auth('api')->user();
            $order = [
                'out_trade_no' => time(),
                'total_amount' => 12,
                'subject' => 'test subject - 测试',
            ];
            
            //return Pay::alipay()->app($order);
           
            
            $stop_time = Carbon::parse('+1 year')->toDateTimeString();
            if(intval($request->duration) === 2){
                $stop_time= Carbon::parse('+99 year')->toDateTimeString();
            }

            $team= new Team();
            $team->title = $user->username.'的团队';
            $team->initiator_id = $user->id;
            $team->duration = intval($request->duration);
            $team->stop_time = $stop_time;
            $team->save();

            $user= User::find($user->id);
            $user->is_initiator= 2;
            $user->save();

            $teamMember= new TeamMember();
            $teamMember->user_id= $user->id;
            $teamMember->team_id= $team->id;
            $teamMember->is_initiator= 2;
            $teamMember->save();
            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
