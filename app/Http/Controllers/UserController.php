<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //

    function index(Request $request)
    {
        $result = $request->has(['email', 'password']);
        if ($result == 1) {
            try {
                $user = User::where('email', $request->email)->first();
                // print_r($data);
                if (!$user || !Hash::check($request->password, $user->password)) {

                    $response = [
                        'status' => 0,
                        'result' => false,
                        'message' => 'These credentials do not match our records.'
                    ];
                    return response($response, 404);
                }

                $token = $user->createToken('my-app-token')->plainTextToken;
                $response = [
                    'status' => 200,
                    'result' => true,
                    'message' => 'success',
                    'user' => $user,
                    'token' => $token
                ];
                return response($response, 200);
            } catch (Exception $e) {

                $response = [
                    'status' => 0,
                    'result' => false,
                    'message' => $e
                ];
                return response($response, 404);
            }
        } else {

            $response = [
                'status' => 0,
                'result' => false,
                'message' => 'Fields are required',
                'data' => [
                    'The field email is required',
                    'The field password is required',
                ]

            ];
            return response($response, 404);
        }
    }
    function register(Request $request)
    {
        $result = $request->has(['name', 'email', 'password']);
        if ($result == 1) {
            try {
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                // $user->admin_type = 'admin';
                $user->password = Hash::make($request->password);
                $result = $user->save();

                if ($result) {

                    $token = $user->createToken('my-app-token')->plainTextToken;

                    $response = [
                        'status' => 200,
                        'result' => true,
                        'message' => 'User has been successfully created',
                        'user' => $user,
                        'token' => $token
                    ];
                    return response($response, 200);
                } else {

                    $response = [
                        'status' => 0,
                        'result' => false,
                        'message' => 'Data can not be saved',
                        'data' => [],
                    ];

                    return response($response, 404);
                }
            } catch (Exception $e) {

                $response = [
                    'status' => 0,
                    'result' => false,
                    'message' => 'user already exist with this email',
                    'data' => $e,


                ];

                return response($response, 404);
            }
        } else {

            $response = [
                'status' => 0,
                'result' => false,
                'message' => 'Fields are required',
                'data' => [
                    'The field name is required',
                    'The field email is required',
                    'The field password is required',
                ]
            ];

            return response($response, 404);
        }
    }

    function findUser(Request $request)
    {
        $result = $request->has(['email']);
        if ($result == 1) {
            try {
                $user = User::where('email', $request->email)->first();
                // print_r($data);
                if (!$user) {

                    $response = [
                        'status' => 0,
                        'result' => false,
                        'message' => 'No user found with this email'
                    ];
                    return response($response, 404);
                }

                //$token = $user->createToken('my-app-token')->plainTextToken;
                $response = [
                    'status' => 200,
                    'result' => true,
                    'message' => 'success',
                    'user' => $user
                    // 'token' => $token
                ];
                return response($response, 200);
            } catch (Exception $e) {

                $response = [
                    'status' => 0,
                    'result' => false,
                    'message' => $e
                ];
                return response($response, 404);
            }
        } else {

            $response = [
                'status' => 0,
                'result' => false,
                'message' => 'Fields are required',
                'data' => [
                    'The field email is required',
                    // 'The field password is required',
                ]

            ];
            return response($response, 404);
        }
    }

    function forgotPassword(Request $request)
    {
        $result = $request->has(['email', 'password']);
        if ($result == 1) {
            try {
                $user = User::where('email', $request->email)->first();

                if (!$user) {

                    $response = [
                        'status' => 0,
                        'result' => false,
                        'message' => 'No user found with this email'
                    ];
                    return response($response, 404);
                }
                $user->password = Hash::make($request->password);
                $check = $user->save();

                if ($check) {
                    $response = [
                        'status' => 200,
                        'result' => true,
                        'message' => 'password has been changed successfully',
                        'user' => $user
                        // 'token' => $token
                    ];
                    return response($response, 200);
                } else {
                    $response = [
                        'status' => 200,
                        'result' => true,
                        'message' => 'Error occured!. Password can not be changed',
                    ];
                    return response($response, 404);
                }
            } catch (Exception $e) {

                $response = [
                    'status' => 0,
                    'result' => false,
                    'message' => $e
                ];
                return response($response, 404);
            }
        } else {

            $response = [
                'status' => 0,
                'result' => false,
                'message' => 'Fields are required',
                'data' => [
                    'The field email is required',
                    'The field password is required',
                ]

            ];
            return response($response, 404);
        }
    }

    function profile(Request $request)
    {

        if (!$request->has('id')) {
            $response = [
                'status' => 0,
                'result' => false,
                'message' => 'id is required',
            ];
            return response($response, 404);
        }

        $user = User::find($request->id);
        if ($user == null) {
            $response = [
                'status' => 0,
                'result' => false,
                'message' => 'No data found',
            ];
            return response($response, 404);
        } else {
            $response = [
                'status' => 200,
                'result' => true,
                'message' => 'Data found successfully',
                'user' => $user
            ];
            return response($response, 200);
        }
    }

    function reset(Request $request){
        if($request->has(['id' , 'password' , 'newPass'])){
            $user = User::find($request->id);
        if($user==null){
            $response = [
                'status' => 0,
                'result' => false,
                'message' => 'No user found',
            ];
            return response($response, 404);
        }else{
                if (Hash::check($request->password, $user->password)) {
                    $user->password = Hash::make($request->newPass);
                    try {
                        $result = $user->save();
                        if ($result) {
                            $response = [
                                'status' => 200,
                                'result' => true,
                                'message' => 'Password changed successfully',
                            ];
                            return response($response, 200);
                        } else {
                            $response = [
                                'status' => 0,
                                'result' => false,
                                'message' => 'password can not changed',
                            ];
                            return response($response, 404);
                        }
                    } catch (Exception $e) {
                        $response = [
                            'status' => 0,
                            'result' => false,
                            'message' => 'Password can not be changed',
                        ];
                        return response($response, 404);
                    }
                }else{
                    $response = [
                        'status' => 0,
                        'result' => false,
                        'message' => 'wrong password',
                    ];
                    return response($response, 404);
                }

        }
        }else{
            $response = [
                'status' => 0,
                'result' => false,
                'message' => 'Fields are required',
                'data'=>[
                    'The field id is required',
                    'The field password is required',
                    'The field newPass is required',
                ]
            ];
            return response($response, 404);
        }
    }
}
