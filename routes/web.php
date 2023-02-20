<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPanelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware', 'guest'], function () {

    Route::get(
        '/',
        function () {
            return redirect(route('login'));
        }
    );
    Route::get('/admin/login', [AdminPanelController::class, 'adminLoginPage'])->name('login');
    Route::post('/admin/login/verify', [AdminPanelController::class, 'verify_admin'])->name('verifyLogin');
});


////////////////// authenticated routes
Route::group(['middleware' => 'auth'], function () {

    ///////// admin routes
    Route::middleware(['auth', 'isAdmin'])->group(function () {
        //////////////////////

        Route::get('admin/dashboard', [AdminPanelController::class, 'dashboard'])->name('dashboard');


        /////////////////////// users
        Route::get('admin/users/all', [AdminPanelController::class, 'totalUsersPage'])->name('users.index');

        Route::get('admin/user/new', [AdminPanelController::class, 'createUserPage'])->name('createUser');
        Route::post('admin/createUser', [AdminPanelController::class, 'userCreated'])->name('userCreated');

        Route::get('admin/user/update', [AdminPanelController::class, 'updateUserByID'])->name('updateUserById');
        Route::post('admin/updateUserById', [AdminPanelController::class, 'user_updated_by_id'])->name('userUpdatedById');

        Route::get('admin/deleteUser/{id}', [AdminPanelController::class, 'deleteUser'])->name('userDeleted');

        ////////////////////// Restaurant Profile

        Route::get('admin/restaurant/profile', [AdminPanelController::class, 'restaurantProfile'])->name('profile');
        Route::post('admin/restaurant/profile', [AdminPanelController::class, 'uploadProfile'])->name('uploadProfile');

        //////////////////////Category

        Route::get('admin/category/all', [AdminPanelController::class, 'totalCategoryPage'])->name('category.index');

        Route::get('admin/category/new', [AdminPanelController::class, 'categoryCreatePage'])->name('createCategory');
        Route::post('admin/createCategory', [AdminPanelController::class, 'category_created'])->name('categoryCreated');

        Route::get('admin/category/update', [AdminPanelController::class, 'updateCategoryPage'])->name('updateCategory');
        Route::post('admin/updateCategory', [AdminPanelController::class, 'category_updated'])->name('categoryUpdated');


        Route::get('admin/categorydelete/{id}', [AdminPanelController::class, 'deleteCategory'])->name('categoryDeleted');



        ///////////////////// Products

        Route::get('admin/products/all', [AdminPanelController::class, 'totalProductsPage'])->name('products.index');

        Route::get('admin/products/new', [AdminPanelController::class, 'createProductsPage'])->name('createProducts');
        Route::post('admin/products', [AdminPanelController::class, 'products_created'])->name('productsCreated');

        Route::get('admin/product/update', [AdminPanelController::class, 'updateProductPage'])->name('updateProduct');
        Route::post('admin/productUpdated', [AdminPanelController::class, 'product_updated'])->name('productUpdated');

        Route::get('admin/deleteproduct/{id}', [AdminPanelController::class, 'deleteTask'])->name('taskDeleted');

        ////////////////////

        /////////////////// total order
        Route::get('admin/totalOrder', [AdminPanelController::class, 'totalOrder'])->name('totalOrder');

        Route::get('admin/pendingOrder', [AdminPanelController::class, 'pendingOrder'])->name('pendingOrder');

        Route::get('admin/order_accepted', [AdminPanelController::class, 'order_accepted'])->name('order_accepted');

        Route::get('admin/acceptedOrder', [AdminPanelController::class, 'acceptedOrder'])->name('acceptedOrder');

        Route::get('admin/deliveredOrder', [AdminPanelController::class, 'deliveredOrder'])->name('deliveredOrder');

        //////////////////////////////////// change password

        Route::get('admin/profile/changePassword', [AdminPanelController::class, 'changePasswordPage'])->name('changePassword');
        Route::post('admin/profile/password_changed', [AdminPanelController::class, 'passwordChanged'])->name('passwordChanged');

        Route::get('admin/profile/logout', [AdminPanelController::class, 'userLogOut'])->name('logOut');

        /////////////////////
    });
});
