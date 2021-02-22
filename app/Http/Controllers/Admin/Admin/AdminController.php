<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $all= $request->all(); 
            $limit = $all['limit'];
            $page = ($all['page'] -1)*$limit;
            $username = false;
            if($request->has('username')){
                $username = $all['username'];
            }
            $item= Admin::when($username,function($query) use ($username){
                return $query->where('username','like','%'.$username.'%');
            })->skip($page)->take($limit)->get();
    
            $total= Admin::when($username,function($query) use ($username){
                return $query->where('username','like','%'.$username.'%');
            })->count();
    
            $data['item'] = $item;
            $data['total'] = $total;
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try { 
            $admin= new Admin;
            $admin->username= $request->username;
            $admin->password=  Hash::make($request->password);
            $admin->name = $request->name;
            if(intval($request->phone) != 0){
                $admin->phone = $request->phone;
            }
            $admin->save();
            return $this->success();
            
        } catch (\Throwable $th) {
            return $this->success();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $admin= auth('admin')->user();
            $state= Hash::check( $request->oldPassword,$admin->password);
            if($state){
            
               $info= Admin::find($admin->id);
               $info->password = Hash::make($request->password);
               $info->save();
               return $this->success();
            }else{
                return $this->failed('原始密码错误');
            }
            
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $admin= auth('admin')->user();
            if($admin->id !==1){
                return $this->failed('必须是超级管理员才能删除');
            }
            Admin::destroy($id);
            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
