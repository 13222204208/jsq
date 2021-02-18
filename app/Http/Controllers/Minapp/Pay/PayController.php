<?php

namespace App\Http\Controllers\Minapp\Pay;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class PayController extends Controller
{
    public function payMember(Request $request)
    {
        try {
            $user= auth('api')->user();
            
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
            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
