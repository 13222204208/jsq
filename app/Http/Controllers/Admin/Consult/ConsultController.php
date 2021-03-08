<?php

namespace App\Http\Controllers\Admin\Consult;

use App\Traits\ImgUrl;
use App\Models\Consult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConsultController extends Controller
{
    use ImgUrl;
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
            $title = false;
            if($request->has('title')){
                $title = $all['title'];
            }
            $item= Consult::when($title,function($query) use ($title){
                return $query->where('title','like','%'.$title.'%');
            })->with('consultType:id,title')->skip($page)->take($limit)->get();
    
            $total= Consult::when($title,function($query) use ($title){
                return $query->where('title','like','%'.$title.'%');
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
            $data = new Consult();
            $data->title = $request->title;
            $data->cover = $request->cover;
            $data->consult_type_id = $request->consult_type_id;
            $data->content = $this->delImgUrl($request->content);
            $data->save();
            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
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
            $data= Consult::find($id);
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
            $consult= Consult::find($id);
            $consult->consult_type_id  = $request->consult_type_id;
            $consult->cover = $request->cover;
            $consult->title = $request->title;
            $consult->content =  $this->delImgUrl($request->content);
            $consult->save();
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
            Consult::destroy($id);
            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
