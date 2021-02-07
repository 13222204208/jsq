<?php

namespace App\Http\Controllers\Minapp\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UpdateUserController extends Controller
{
    public function update(Request $request)
    { 

        try {
            $data = $request->all(); 
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'phone' => 'required|unique:users|regex:/^1[345789][0-9]{9}$/',
                    'name' => 'required|min:2|max:30',
                    'email' => 'email',
                    'team' => 'min:2|max:100',//团队
                    'token' =>'required'
                ],
                [
                    'required' => ':attribute不能为空',
                    'regex' => ':attribute格式不正确',
                    'max' => ':attribute最长:max字符',
                    'min' => ':attribute最小:min字符',
                    'unique' => ':attribute已存在',
                    'email' => ':attribute格式不正确',
                ],
                [
                    'name' => '姓名',
                    'phone' => '手机号',
                    'email' => '邮箱',
                    'team' => '团队'
                ]        
            );
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return $this->failed($messages);
            }
    
            $user = auth('api')->user();
            unset($data['token']);
            array_filter($data);
            User::where('id',$user->id)->update($data);
            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
