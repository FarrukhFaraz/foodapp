<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    function index(Request $request)
    {
        $product = Products::where('category_id', '=', $request->id)->get();
        if ($product == null) {
            $response = [
                'status' => 0,
                'result' => false,
                'message' => 'No data found',
                'data' => $product,
            ];
            return response($response, 200);
        } else {
            $response = [
                'status' => 200,
                'result' => true,
                'message' => 'Data found successfully',
                'data' => $product,
            ];
            return response($response, 200);
        }
    }

    function productDetail(Request $request)
    {
        $product = Products::find($request->id);
        if ($product == null) {
            $response = [
                'status' => 0,
                'result' => false,
                'message' => 'No data found',
                'data' => $product,
            ];
            return response($response, 404);
        } else {
            $response = [
                'status' => 200,
                'result' => true,
                'message' => 'Data found successfully',
                'data' => $product,
            ];
            return response($response, 200);
        }
    }
}
