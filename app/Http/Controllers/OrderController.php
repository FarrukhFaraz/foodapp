<?php

namespace App\Http\Controllers;

use App\Models\backUpOrder;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    function placeOrder(Request $request)
    {
        if ($request->has(['user_id', 'totalPrice', 'customer_name', 'phone_number', 'address', 'extraInfo'])) {
            $order = new Order;
            $order->user_id = $request->user_id;

            $order->totalPrice = $request->totalPrice;
            $order->customer_name = $request->customer_name;
            $order->status = 'pending';
            $order->phone_number = $request->phone_number;
            $order->address = $request->address;
            $order->extraInfo = $request->extraInfo;

            $check = $order->save();
            if ($check) {

                $cart = Cart::where('user_id', '=', $request->user_id)->get();
                $list = [];
                foreach ($cart as $item) {
                    array_push($list, $item->id);

                    $backUp = new backUpOrder;
                    $backUp->order_id = $order->id;
                    $backUp->user_id = $item->user_id;
                    $backUp->product_id = $item->product_id;
                    $backUp->quantity = $item->quantity;
                    $backUp->price = $item->price;
                    $backUp->save();
                }

                Cart::destroy($list);
                $response = [
                    'status' => 200,
                    'result' => true,
                    'message' => 'Order place successfully',
                    'data' => $order,
                ];
                return response($response, 200);
            }
        } else {
            $response = [
                'status' => 0,
                'result' => false,
                'message' => 'Fields are required',
                'data' => [
                    'The field user_id is required',
                    'The field totalPrice is required',
                    'The field customer_name is required',
                    'The field phone_number is required',
                    'The field address is required',
                    'The field extraInfo is required',
                ],
            ];
            return response($response, 404);
        }
    }

    function allOrder($data)
    {
        // if ($request->has('user_id')) {

            $order = Order::where('user_id', '=', $data)->get();

            $response = [
                'status' => 200,
                'result' => true,
                'message' => 'Data found successfully',
                'data' => $order,
            ];

            return response($response, 200);


    }

    function deliverOrder(Request $request)
    {
        if ($request->has('id')) {
            $order = Order::find($request->id);
            if($order !=null){
                $order->status = 'delivered';
                $check = $order->save();
                if($check){
                    $response = [
                        'status' => 200,
                        'result' => true,
                        'message' => 'Order Delivered Successfully',
                        'data' => $order,
                    ];
                    return response($response, 200);
                }
            }
        } else {
            $response = [
                'status' => 0,
                'result' => false,
                'message' => 'Fields are required',
                'data' => [
                    'The field id is required',
                ],
            ];
            return response($response, 404);
        }
    }

    // function orderDetail(Request $request){
    //     if($request->has('order_id')){
    //         $order = backUpOrder::where('order_id' , '=' , $request->order_id)->get();
    //         $data = [];
    //         foreach ($order as $item) {

    //         }
    //         $response = [
    //             'status' => 200,
    //             'result' => true,
    //             'message' => 'Order found',
    //             'data' => $order,

    //         ];
    //         return response($response, 200);

    //     }else{
    //         $response = [
    //             'status' => 0,
    //             'result' => false,
    //             'message' => 'Fields are required',
    //             'data' => [
    //                 'The field order_id is required',
    //             ],
    //         ];
    //         return response($response, 404);
    //     }
    // }
}
