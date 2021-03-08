<?php

namespace App\Http\Controllers\Admin\Team;

use App\Http\Controllers\Controller;
use App\Models\TeamPrivacy;
use Illuminate\Http\Request;

class TeamPrivacyController extends Controller
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
            
            $item= TeamPrivacy::skip($page)->take($limit)->orderBy('created_at','desc')->get();
            $total= TeamPrivacy::count();
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
            $data= $request->only('title','content','background');
            TeamPrivacy::create($data);
            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed();
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
        try {
            $data= TeamPrivacy::find($id);
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
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
            $teamPrivacy= TeamPrivacy::find($id);
            if(empty($teamPrivacy)){
                TeamPrivacy::create($request->all());
                return $this->success();
            }
            $teamPrivacy->title= $request->title;
            $teamPrivacy->background= $request->background;
            $teamPrivacy->content= $request->content;
            $teamPrivacy->save();
            return $this->success();
            
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
            TeamPrivacy::destroy($id);
            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
