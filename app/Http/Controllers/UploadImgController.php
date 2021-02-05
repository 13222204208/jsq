<?php

namespace App\Http\Controllers;

use App\Traits\UploadImage;
use Illuminate\Http\Request;

class UploadImgController extends Controller
{
    use UploadImage;

    public function uploadImg(Request $request)
    {   
        $imgUrl= $this->getNewFile($request->upload);
        $data['url'] = $imgUrl;
        $data['uploaded']= true;
        return response()->json($data);
    }
}
