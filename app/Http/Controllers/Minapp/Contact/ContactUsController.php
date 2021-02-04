<?php

namespace App\Http\Controllers\Minapp\Contact;

use Illuminate\Http\Request;
use App\Services\ContactUsService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    protected $contactUsService;

    public function __construct(ContactUsService $contactUsService)
    {
        $this->contactUsService = $contactUsService;
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'name' => 'required|max:30',//名字
                    'phone' => 'required|regex:/^1[345789][0-9]{9}$/',//联系方式 
                    'email' => 'required|email',
                    'team' => 'required|max:50',//团队
                    'news' => 'required|max:500',//消息
                ],
                [
                    'required' => ':attribute不能为空',
                    'regex' => ':attribute格式不正确',
                    'max' => ':attribute最长:max字符',
                    'email' => ':attribute格式不正确',
                ],
                [
                    'name' => '姓名',//名字
                    'phone' => '手机号',//联系方式 
                    'email' => '邮箱',
                    'team' => '团队',//团队
                    'news' => '消息',//消息
                ]        
            );
    
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return $this->failed($messages);
            }

            $this->contactUsService->create($data);
            return $this->success();
            
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
