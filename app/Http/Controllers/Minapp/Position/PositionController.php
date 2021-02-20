<?php

namespace App\Http\Controllers\Minapp\Position;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    public function storePosition(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'type_name' => 'required|min:1|max:50',
                    'icon' => 'required|min:1|max:200',
                    'long' => 'required|min:1|max:200',
                    'lat' => 'required|min:1|max:200',
                ],
                [
                    'required' => ':attribute不能为空',
                    'max' => ':attribute最长:max字符',
                    'min' => ':attribute最小:min字符',
                
                ],
                [
                    'type_name' => '类型名称',
                    'icon' => '图标',
                    'long' => '经度',
                    'lat' => '纬图',
                ]        
            );
            $position= $this->getCity($data['long'],$data['lat']);
            
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return $this->failed($messages);
            }
            $user= auth('api')->user();
            $data= array_filter($data);
            $data['user_id']= $user->id;
            $data['address'] =  $position['result']['formatted_address'];
            unset($data['token']);
            Position::create($data);
            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    public function getCity($longitude, $latitude){
	    //调取百度接口,其中ak为百度帐号key,注意location纬度在前，经度在后
	    $api = "http://api.map.baidu.com/geocoder/v2/?ak=D4bB5Twdwanr8DLClNjo1KBnQdcnUCOz&location=".$latitude.",".$longitude."&output=json&pois=1";
	    $content = file_get_contents($api); 
	    $arr = json_decode($content,true);
	    return $arr;	
	}

}
