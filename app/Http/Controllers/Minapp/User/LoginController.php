<?php

namespace App\Http\Controllers\Minapp\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->only('username','password');
        $validator = Validator::make(//验证数据字段
            $data,
            [
                'username' => 'required|regex:/^1[345789][0-9]{9}$/',
                'password' => 'required|min:6|max:30',
            ],
            [
                'required' => ':attribute不能为空',
                'regex' => ':attribute格式不正确',
                'max' => ':attribute最长:max字符',
                'min' => ':attribute最小:min字符',
            ],
            [
                'username' => '用户名',
                'password' => '密码',
            ]        
        );

        if ($validator->fails()) {
            $messages = $validator->errors()->first();
            return $this->failed($messages);
        }

        $user= User::where('username',$data['username'])->where('status',1)->first();
        if(!$user){
            return $this->failed('用户不存在或被禁用');
        }else{
            if (!Hash::check($data['password'],$user->password)) {
                return  $this->failed('密码不正确');
            }
        }

        if (! $token = auth('api')->attempt($data)) {
            return  $this->failed();
        }

        $data= auth('api')->user();
        $data->token= $token;
        $data->tab_color="imgs/20210304/m6o5WFQYNs.jpg";
        $data->avatar="imgs/20210205/5mfAG0ktHJ.jpg";
        $data->name=$data->username;
        return $this->success($data);

    }
}
