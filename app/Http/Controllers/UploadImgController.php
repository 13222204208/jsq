<?php

namespace App\Http\Controllers;

use App\Traits\ImgUrl;
use App\Traits\UploadImage;
use Illuminate\Http\Request;

class UploadImgController extends Controller
{
    use UploadImage, ImgUrl;

    public function uploadImg(Request $request)
    {   
        $imgUrl= $this->getNewFile($request->upload);
        $data['url'] = $imgUrl;
        $data['uploaded']= true;
        return response()->json($data);
    }

    public function uploadContentImg(Request $request)
    {   
        $imgUrl= $this->getNewFile($request->upload);
        $data['url'] = $this->currentUrl().$imgUrl;
        $data['uploaded']= true;
        return response()->json($data);
    }
}
