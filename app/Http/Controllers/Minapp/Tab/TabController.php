<?php

namespace App\Http\Controllers\Minapp\Tab;

use App\Http\Controllers\Controller;
use App\Models\Tab;
use App\Models\TabColor;
use Illuminate\Http\Request;

class TabController extends Controller
{
    public function tabType(Request $request)
    {
        try {
            if(intval($request->tab_id) !=0){
                $data= Tab::where('parent_id',intval($request->tab_id))->get(['id','title','icon']);
                return $this->success($data);
            }

            $data= Tab::where('parent_id',null)->get(['id','title']);
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    public function tabColor()
    {
        try {
            $data= TabColor::all();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
