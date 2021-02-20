<?php

namespace App\Http\Controllers\Minapp\Triage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Triage;
use Illuminate\Support\Facades\Validator;

class TriageController extends Controller
{
    public function storeTriage(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'minor_wound' => 'required|integer|max:4',
                    'moderate_wound' => 'required|integer|max:4',
                    'serious_injuries' => 'required|integer|max:4',
                    'death' => 'required|integer|max:4',
                ],
                [
                    'required' => ':attribute不能为空',
                    'max' => ':attribute最长:max字符',
                    'min' => ':attribute最小:min字符',
                    'integer' => ':attribute必须为整数',
                ],
                [
                    'minor_wound' => '轻伤',
                    'moderate_wound' => '中度伤',
                    'serious_injuries' => '重伤',
                    'death' => '死亡',
                ]        
            );
    
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return $this->failed($messages);
            }
            $data= array_filter($data);
            unset($data['token']);
            $user= auth('api')->user();
            $data['user_id']= $user->id;
            Triage::create($data);
            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
