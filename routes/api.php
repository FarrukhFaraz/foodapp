<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GallaryImageController;
use App\Http\Controllers\OrderController;
use Faker\Guesser\Name;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::group(['middleware' => 'auth:sanctum'], function () {
    //All secure URL's

    ////////// restaurant profile

    Route::get('restaurant/profile', [RestaurantProfileController::class, 'index'])->name('restaurantProfile');

    Route::post('user/profile', [UserController::class, 'profile'])->name('userProfile');

    Route::post('user/reset', [UserController::class, 'reset'])->name('reset');

    Route::get('allCategory', [CategoryController::class, 'index'])->name('allCategory');

    Route::post('productByCategory', [ProductController::class , 'index'])->name('product');
    Route::post('productDetail' , [ProductController::class, 'productDetail'])->name('productDetail');



    ///////////cart

    Route::post('addToCart' ,[CartController::class , 'addToCart']);
    Route::post('getCart' ,[CartController::class , 'getCart']);




    Route::post('placeOrder' ,[OrderController::class , 'placeOrder']);

    Route::get('allOrder/{id?}' ,[OrderController::class , 'allOrder']);

    Route::post('deliverOrder' ,[OrderController::class , 'deliverOrder']);


    ////////////////////////// gallary Image
    Route::get('gallaryImage' , [GallaryImageController::class , 'gallaryImage']);

});
Route::post('user/login', [UserController::class, 'index'])->name('login');
Route::post('user/register', [UserController::class, 'register'])->name('register');
Route::post('user/findUser', [UserController::class, 'findUser'])->name('findUser');
Route::post('user/forgotPassword', [UserController::class, 'forgotPassword'])->name('forgotPassword');



Route::get('/leftJoin' , [CategoryController::class , 'check']);
