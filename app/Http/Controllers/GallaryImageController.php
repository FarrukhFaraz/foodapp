<?php

namespace App\Http\Controllers;

use App\Models\gallaryImage;
use Illuminate\Http\Request;

class GallaryImageController extends Controller
{
    //

    function gallaryImage(){
        $images = gallaryImage::all();

        $response = [
            'status' => 200,
            'result' => true,
            'message' => 'Images found successfully',
            'data' => $images,
        ];
        return response($response, 200);
    }
}
