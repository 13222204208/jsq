<?php

namespace App\Http\Controllers\Minapp\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'username' => 'required|unique:users|regex:/^1[345789][0-9]{9}$/',
                    'password' => 'required|min:6|max:30',
                    'rpassword' => 'required|min:6|max:30',
                ],
                [
                    'required' => ':attribute不能为空',
                    'regex' => ':attribute格式不正确',
                    'max' => ':attribute最长:max字符',
                    'min' => ':attribute最小:min字符',
                    'unique' => ':attribute已存在',
                ],
                [
                    'username' => '用户名',
                    'password' => '密码',
                    'rpassword' => '确认密码',
                ]        
            );
    
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return $this->failed($messages);
            }

            if($data['password'] !== $data['rpassword']){
                return $this->failed('输入的密码不一致');
            }

            $user = new User();
            $user->username= $data['username'];
            $user->password= Hash::make($data['password']);
            $user->phone= $data['username'];
            $user->save();
            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
