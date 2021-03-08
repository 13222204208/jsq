<?php

namespace App\Http\Controllers\Minapp\Notepad;

use App\Models\Notepad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class NotepadController extends Controller
{
    public function storeNotepad(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'content' => 'required|min:2|max:1000',
                ],
                [
                    'required' => ':attribute不能为空',
                    'max' => ':attribute最长:max字符',
                    'min' => ':attribute最小:min字符',
                ],
                [
                    'content' => '内容',
                ]        
            );
    
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return $this->failed($messages);
            }

            if(intval($request->id) != 0){
                Notepad::where('id',intval($request->id))->update([
                    'content'=> $request->content
                ]);
                return $this->success();
            }

            $user= auth('api')->user(); 
            $notepad= new Notepad;
            if ($request->title) {
                $notepad->title = $request->title;
            }
            $notepad->content= $data['content'];
            $notepad->user_id= $user->id;
            $notepad->save();
            return $this->success();

        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    public function notepadList(Request $request)
    {
        try {

            if (intval($request->id)) {
                $data= Notepad::find(intval($request->id));
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
            $user= auth('api')->user(); 

            $data= Notepad::where('user_id',$user->id)->skip($page)->take($size)->get();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
