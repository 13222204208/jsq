<?php

namespace App\Http\Controllers\Minapp\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\UploadImage;
use Illuminate\Support\Facades\Validator;

class UpdateUserController extends Controller
{
    use UploadImage;

    public function edit(Request $request)
    { 

        try {
            $data = $request->only('name','phone','email','team','tab_color','medical_allergy','linkman_one_name','linkman_one_phone','linkman_two_name','linkman_two_phone','avatar','token'); 
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'phone' => 'required|regex:/^1[345789][0-9]{9}$/',
                    'name' => 'required|min:2|max:30',
                    //'email' => 'email',
                   // 'team' => 'min:2|max:100',//团队
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
            unset($data['token']);
            $user = auth('api')->user();
            $data= array_filter($data);
            User::where('id',$user->id)->update($data);
            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    public function uploadImg(Request $request)
    {   
        $imgUrl= $this->getNewFile($request->file);
        
        return $this->success($imgUrl);
    }
}
