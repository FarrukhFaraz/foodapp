<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    //

    function addToCart(Request $request)
    {
        if ($request->has(['product_id', 'user_id', 'quantity'])) {
            $product = Products::find($request->product_id);
            if ($product != null) {

                $cart = Cart::where('user_id', '=', $request->user_id)
                    ->where('product_id', '=', $request->product_id)
                    ->get()->first();
                if ($cart == null) {
                    $cart = new Cart;
                    $cart->user_id = $request->user_id;
                    $cart->product_id = $request->product_id;
                    $cart->quantity = $request->quantity;
                    $cart->price = strval(intval($request->quantity) * intval($product->price));
                } else {
                    $cart->user_id = $request->user_id;
                    $cart->product_id = $request->product_id;
                    $cart->quantity = $request->quantity;
                    $cart->price = strval(intval($request->quantity) * intval($product->price));
                }
                $check = $cart->save();

                if ($check) {
                    $cartItem = Cart::where('user_id',  '=', $request->user_id)->get();
                    $response = [
                        'status' => 200,
                        'result' => true,
                        'message' => 'Product added',
                        'data' => $cartItem,
                    ];
                    return response($response, 200);
                }
            } else {
                $response = [
                    'status' => 0,
                    'result' => false,
                    'message' => 'No user found with this id',
                    'data' => [],
                ];
                return response($response, 404);
            }
        } else {
            $response = [
                'status' => 0,
                'result' => false,
                'message' => 'Fields are required',
                'data' => [
                    'The field product_id is required',
                    'The field user_id is required',
                    'The field quantity is required'
                ],
            ];
            return response($response, 404);
        }
    }

    function getCart(Request $request)
    {
        if ($request->has('user_id')) {
            $cart = Cart::where('user_id', '=', $request->user_id)->get();
            $price = 0;
            foreach ($cart as $item) {
                $price = $price + intval($item->price);
            }


            $cartItems = DB::table('carts')
                ->join('products', 'carts.product_id', '=', 'products.id')
                ->select('products.*' , 'carts.*')
                ->get();


            $response = [
                'status' => 200,
                'result' => true,
                'message' => 'Data found successfully',
                'subTotal' => $price,
                'data' => $cartItems,

            ];
            return response($response, 200);
        } else {
            $response = [
                'status' => 0,
                'result' => false,
                'message' => 'Fields are required',
                'data' => [
                    'The field user_id is required',
                ],
            ];
            return response($response, 404);
        }
    }
}
