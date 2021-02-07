<?php

namespace App\Http\Controllers\Minapp\Consult;

use App\Http\Controllers\Controller;
use App\Models\Consult;
use App\Models\ConsultType;
use Illuminate\Http\Request;

class ConsultController extends Controller
{
    public function consult(Request $request)
    {
        try {
            if($request->consult_id){
                $data= Consult::find(intval($request->consult_id));
                return $this->success($data);
            }
                $size = 10;
                if($request->size){
                    $size = $request->size;
                }
        
                $page = 0;
                if($request->page){
                    $page = ($request->page -1)*$size;
                }
                $consult_type_id= 1;
                if($request->consult_type_id){
                    $consult_type_id = $request->consult_type_id;
                }

                $list= Consult::skip($page)->take($size)->where('consult_type_id',$consult_type_id)->get();
                $type = ConsultType::all();

                $all['type'] = $type;
                $all['list'] = $list;
             
                return $this->success($all);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
