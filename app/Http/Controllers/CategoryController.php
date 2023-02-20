<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //

    function index(){
        $category = Categories::all();
        $response = [
            'status' => 200,
            'result' => true,
            'message' => 'Data found successfully',
            'data'=>$category,
        ];
        return response($response, 200);
    }


    function check(){
        // $data = Categories::with('product')->get();

        $data = Products::with('category')->get();

        $response = [
            'status' => 200,
            'result' => true,
            'total Record' => count($data),
            'message' => 'Data found successfully',
            'data' => $data
        ];

        return  Response($response, '200');



    }


}
