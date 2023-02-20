<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\RestaurantProfile;
use Illuminate\Http\Request;

class RestaurantProfileController extends Controller
{
    //

    function index()
    {
        $restaurant = RestaurantProfile::find(1);
        if ($restaurant == null) {
            $response = [
                'status' => 0,
                'result' => false,
                'message' => 'No data found'
            ];
            return response($response, 404);
        } else {
            $response = [
                'status' => 200,
                'result' => true,
                'message' => 'Data found successfully',
                'data' => $restaurant,
            ];
            return response($response, 200);
        }
    }
}
