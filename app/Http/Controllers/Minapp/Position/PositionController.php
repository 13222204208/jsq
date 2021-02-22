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

    public function positionList(Request $request)
    {
        try {
/*             $size = 10;
            if($request->size){
                $size = $request->size;
            }

            $page = 0;
            if($request->page){
                $page = ($request->page -1)*$size;
            } */
            if(intval($request->position_id) != 0){
                $data= Position::where('id',intval($request->position_id))->with(['userInfo'=>function($query){
                    $query->select('id', 'username','name','avatar'); // 需要同时查询关联外键的字段
                }])->first();      
                return $this->success($data);
            }

            if($request->long&&$request->lat){ 
                    //使用此函数计算得到结果后，带入sql查询。
                $point = $this->returnSquarePoint($request->long,$request->lat,30);//计算经纬度的周围某段距离的正方形的四个点
                
                $right_bottom_lat = $point['right_bottom']['lat'];   //右下纬度
                $left_top_lat = $point['left_top']['lat'];           //左上纬度
                $left_top_lng = $point['left_top']['lng'];           //左上经度
                $right_bottom_lng = $point['right_bottom']['lng'];   //右下经度
                $map = array();
                $map = [
                    ['lat' ,'>',$right_bottom_lat],
                    ['lat' ,'<',$left_top_lat],
                    ['long' ,'>',$left_top_lng],
                    ['long' ,'<',$right_bottom_lng],
                    ['status',1]
                ]; 
                //$data= Position::where($map)->skip($page)->take($size)->get();     
                $data= Position::where($map)->get(); 
                return $this->success($data);
            }else{
                return $this->failed('请填写经纬度');
            }


        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    private function returnSquarePoint($lng, $lat,$distance = 30)//30为三千米
    {
        $earthdata=6371;//地球半径，平均半径为6371km
        $dlng =  2 * asin(sin($distance / (2 * $earthdata)) / cos(deg2rad($lat)));
        $dlng = rad2deg($dlng);
        $dlat = $distance/$earthdata;
        $dlat = rad2deg($dlat);
        $arr=array(
            'left_top'=>array('lat'=>$lat + $dlat,'lng'=>$lng-$dlng),
            'right_top'=>array('lat'=>$lat + $dlat, 'lng'=>$lng + $dlng),
            'left_bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng - $dlng),
            'right_bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng + $dlng)
        );
        return $arr;
    }

    public function position(Request $request)
    {
        try {

            $data = $request->all();
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'position_id' => 'required|integer',
                    'type' => 'required',
                ],
                [
                    'required' => ':attribute不能为空',
                    'integer' => ':attribute必须为整数',
                ],
                [
                    'position_id' => '位置的id',
                    'type' => '类型',
                ]        
            );
    
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return $this->failed($messages);
            }

            if($request->type == 'del'){
                Position::where('id',intval($request->position_id))->update([
                    'status' => 2
                ]);
                return $this->success();
            }

            if($request->type == 'update'){
        
                $array= array_filter(array_diff_key($data, ['position_id'=>0,'type'=>0,'token'=>0]));
                if(intval($array) == 0){
                    return $this->failed('请填写更新内容');
                }
                Position::where('id',intval($request->position_id))->update($array);
                return $this->success();
            }

            return $this->failed('error');
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    public function filterPosition(Request $request)
    {
        try {
            if($request->type =="all"){
                $data= Position::where('status',1)->get();
                return $this->success($data);
            }

            if($request->type =="own"){
                $user= auth('api')->user();
                $data= Position::where('user_id',$user->id)->where('status',1)->get();
                return $this->success($data);
            }
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());   
        }
    }

}
