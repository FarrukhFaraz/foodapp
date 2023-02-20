<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Order;
use App\Models\Products;
use App\Models\RestaurantProfile;
use App\Models\User;
use Directory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Constraint\DirectoryExists;
use RealRashid\SweetAlert\Facades\Alert;

class AdminPanelController extends Controller
{



    function adminLoginPage()
    {
        return view('backend.auth.login');
        // return view('admin.admin_login_page');
    }


    function verify_admin(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'password.required' => 'Password is required',
            ]
        );

        // $user = User::where('email', $request->email)->first();
        // // print_r($data);
        // if (!$user || !Hash::check($request->password, $user->password)) {
        //     Alert::error('Invalid Email and Password');
        //     return back();
        // }
        // if ($user->admin_type == 'admin') {
        //     Auth::attempt();
        // } else {

        // }

        //    // return redirect(route('dashboard'));
        $credentials = $request->only('email', 'password');
        // return Hash::make(123);

        if (auth()->guard('web')->attempt($credentials)) {
            if (Auth::user()->admin_type == 'admin') {
                // admin dashboard path
                return redirect(route('dashboard'));
            } else {
                return redirect(route('homePage'));
            }
            // return auth()->guard('web')->user();
            // echo 'login';
            //Alert::success('Login Successfully');

        } else {
            alert('Error', 'Invalid Credential', 'error');
            return back();
        }
    }

    function dashboard()
    {
        $users = User::count();
        $category = Categories::count();
        $product = Products::count();
        $orders = Order::all();

        $pendingOrder = Order::Where('status', '=', 'pending')->get();
        $deliveredOrder = Order::Where('status', '=', 'delivered')->get();
        $restaurant = RestaurantProfile::find(1)->first();

        $userData = auth()->guard('web')->user();
        if ($restaurant != null) {
            $restaurantName =  $restaurant->name;
        } else {
            $restaurantName = '';
        }
        $totalPrice = 0;
        foreach ($orders as $item) {
            $totalPrice = $totalPrice + intval($item->totalPrice);
        }
        $price = 0;
        foreach ($deliveredOrder as $item) {
            $price = $price + intval($item->totalPrice);
        }
        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Dashboard',
            'breadcumb' => [['name' => 'dashboard']],
            'restaurantName' => $restaurantName,
            'price' => $totalPrice,
            'receivedAmount' => $price,
            'users' => $users,
            'category' => $category,
            'product' => $product,
            'orders' => $orders->count(),

            'pendingOrder' => $pendingOrder->count(),
            'deliveredOrder' => $deliveredOrder->count(),
            'userData' => $userData,
        ];

        return view('backend.pages.dashboard.index')->with($data);
    }



    /////////////////  users

    function totalUsersPage(Request $request)
    {
        $userData = auth()->guard('web')->user();

        $search = $request['search'] ?? "";



        if ($search != '') {

            $users = User::query()
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->paginate(10);

            // $users = $user->where('name', 'LIKE', "%{$search}%")
            // $user =  $users->query()->where('name', 'LIKE', "%{$search}%")
            //     ->orWhere('email', 'LIKE', "%{$search}%")
            //     ->paginate(10);
            $users->appends(array('search' => $search));
        } else {
            $users = User::paginate(10);

            $users->appends(array('search' => $search));
        }

        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Users',
            'breadcumb' => [['link' => '/', 'name' => 'dashboard'], ['name' => 'admin/users/all']],
            'search' => $search,
            'users' => $users,
            'userData' => [
                'id' => $userData['id'],
                'name' => $userData['name'],
                'email' => $userData['email'],
            ],
        ];
        return view('backend.pages.users.index')->with($data);

        // $data = compact('users', 'search');
        // return view('admin.users.total_user_page')->with($data);

    }


    function createUserPage()
    {
        $userData = auth()->guard('web')->user();
        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Create User',
            'breadcumb' => [['link' => '/', 'name' => 'dashboard'], ['name' => 'admin/users/new']],
            'userData' => [
                'id' => $userData['id'],
                'name' => $userData['name'],
                'email' => $userData['email'],
            ],
        ];
        return view('backend.pages.users.newUser')->with($data);
    }

    function userCreated(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'rePassword' => 'required|same:password'
            ]
        );

        try {
            $user = new User;
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->password = Hash::make($request['password']);
            $result = $user->save();
            if ($result) {
                Alert::success('Success', 'User has been successfully created');
                return back();
            } else {
                Alert::error('Failed', 'Something went wrong!');
                return back();
            }
        } catch (Exception $e) {
            Alert::error('Failed', 'This email already exist!Try with different one');
            return back();
        }
    }

    function updateUserByID(Request $request)
    {
        $userData = auth()->guard('web')->user();
        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Update User',
            'breadcumb' => [['link' => '/', 'name' => 'dashboard'], ['name' => 'admin/users/update']],
            'id' => $request['id'],
            'name' => $request['name'],
            'email' => $request['email'],
            'userData' => $userData,
        ];

        return view('backend.pages.users.updateUserById')->with($data);
    }

    function user_updated_by_id(Request $request)
    {
        $request->validate(
            [
                'id' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'rePassword' => 'required|same:password'
            ]
        );
        try {
            $user = User::find($request['id']);
            if ($user == null) {

                Alert::error('Failed', 'No User found with this id');
                return back();
            }
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->password = Hash::make($request['password']);
            try {
                $result = $user->save();

                if ($result) {
                    Alert::success('Success', 'User has been successfully updated');
                    // return back();
                    return redirect(route('users.index'));
                } else {
                    Alert::error('Failed', 'Something went wrong!');
                    return back();
                }
            } catch (Exception $e) {
                Alert::error('Failed', 'This email already exist for a user. Please try with different one...' . $e);
                return back();
            }
        } catch (Exception $e) {
            Alert::error('Failed', 'No User found with this id');
            return back();
        }
    }

    function deleteUser($id)
    {
        $user = User::find($id);
        if ($user == null) {
            return response('No data found with this Id', 250);
        }
        try {
            $result = $user->delete();
            if ($result) {
                return response('User id deleted successfully', 210);
            } else {
                return response('Data can not be deleted', 240);
            }
        } catch (Exception $e) {
            return response('Data can not be deleted', 260);
        }
    }


    ///////////////////// Restaurant Profile

    function restaurantProfile()
    {
        $userData = auth()->guard('web')->user();
        $restaurant = RestaurantProfile::find(1);
        if ($restaurant == null) {
            $name = '';
            $phone = '';
            $logo = '';
            $email = '';
            $address = '';
            $lat = '';
            $lng = '';
            $delivery_time = '';
            $start_time = '';
            $end_time = '';
            $about = '';
        } else {
            $name = $restaurant->name;
            $phone = $restaurant->phone;
            $logo = $restaurant->logo;
            $email = $restaurant->email;
            $address = $restaurant->address;
            $lat = $restaurant->lat;
            $lng = $restaurant->lng;
            $delivery_time = $restaurant->delivery_time;
            $start_time = $restaurant->start_time;
            $end_time = $restaurant->end_time;
            $about = $restaurant->about;
        }


        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Restaurant Profile',
            'breadcumb' => [['link' => '/', 'name' => 'dashboard'], ['name' => 'admin/restaurant/profile']],
            'userData' => $userData,
            'restaurant' => [
                'name' => $name,
                'phone' => $phone,
                'logo' => $logo,
                'email' => $email,
                'address' => $address,
                'lat' => $lat,
                'lng' => $lng,
                'delivery_time' => $delivery_time,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'about' => $about,

            ],
        ];

        return view('backend.pages.RestaurantProfile.profile')->with($data);
    }


    function uploadProfile(Request $request)
    {
        $logo = '';
        if ($request->has('image')) {
            $logo = $request->file('image')->getClientOriginalName();
        }


        // $destination = 'uploads/profile/';
        //  $path = $request->file('image')->storeAs('public/Profile', $logo);




        $url = request()->getSchemeAndHttpHost();

        // $profile =  $url . '/' . $path;

        // // ////////// later save it to database
        try {
            $restaurant = RestaurantProfile::find(1);

            if ($restaurant == null) {

                $restaurant = new RestaurantProfile;

                if ($request->has('image')) {
                    $restaurant->logo = $logo;
                }

                $restaurant->name = $request->name;
                $restaurant->phone = $request->phone;
                $restaurant->email = $request->email;
                $restaurant->address = $request->address;
                $restaurant->lat = $request->lat;
                $restaurant->lng = $request->lng;
                $restaurant->delivery_time = $request->delivery_time;
                $restaurant->start_time = $request->start_time;
                $restaurant->end_time = $request->end_time;
                $restaurant->about = $request->about;
                $result = $restaurant->save();
            } else {
                if ($request->has('image')) {
                    /////// $restaurant->logo = $logo;
                    $path = 'uploads/profile/' . $restaurant->logo;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }

                $restaurant->name = $request->name;
                $restaurant->phone = $request->phone;
                $restaurant->email = $request->email;
                $restaurant->address = $request->address;
                $restaurant->lat = $request->lat;
                $restaurant->lng = $request->lng;
                $restaurant->delivery_time = $request->delivery_time;
                $restaurant->start_time = $request->start_time;
                $restaurant->end_time = $request->end_time;
                $restaurant->about = $request->about;
                $result = $restaurant->save();
            }

            if ($request->has('image')) {
                $request->file('image')->move('uploads/profile/', $restaurant->logo);
            }

            if ($result) {
                Alert::success('Success', 'Profile has been successfully updated');
                return back();
            } else {
                Alert::error('Error', 'Something went wrong! Server is not responding');
                return back();
            }
        } catch (Exception $e) {
            Alert::error('Error', 'Something went wrong! Server is not responding' . $e);
            return back();
        }
    }

    ////////////////////// Category


    function totalCategoryPage(Request $request)
    {
        $userData = auth()->guard('web')->user();

        $search = $request['search'] ?? "";

        if ($search != '') {
            $category = Categories::query()
                ->where('name', 'LIKE', "%{$search}%")
                ->paginate(10);
            $category->appends(array('search' => $search));
        } else {
            $category = Categories::paginate(10);
        }

        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Category',
            'breadcumb' => [['link' => '/', 'name' => 'dashboard'], ['name' => 'admin/category/all']],
            'search' => $search,
            'projects' => $category,
            'userData' => $userData,
        ];
        return view('backend.pages.category.index')->with($data);

        // $data = compact('projects', 'search');
        // return view('backend.pages.projects.index')->with($data);
    }

    function categoryCreatePage()
    {
        $userData = auth()->guard('web')->user();
        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Create Category',
            'breadcumb' => [['link' => '/', 'name' => 'dashboard'], ['name' => 'admin/category/new']],
            'userData' => $userData,
            // 'users'=>$users,
        ];
        return view('backend.pages.category.newCategory')->with($data);
    }

    function category_created(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'image' => 'required|image'
        ]);

        $extension = $request->file('image')->getClientOriginalExtension();

        try {
            $category = new Categories;
            $category->name = $request->name;

            $time = time();
            $name = $time . '.' . $extension;

            $imageFile = 'uploads/categories/';

            $request->file('image')->move($imageFile , $name);
            // $url = asset($imageFile);
            $category->image = $name;

            $result = $category->save();
            if ($result) {
                Alert::success('Success', 'Category has been successfully created');
                return redirect(route('category.index'));
            } else {
                Alert::error('Error', 'Something went wrong! Server is not responding');
                return back();
            }
        } catch (Exception $e) {
            Alert::error('Error', 'Something went wrong! Server is not responding' . $e);
            return back();
        }

    }


    function deleteCategory($id)
    {
        try {
            $category = Categories::find($id);
            if ($category == null) {
                // echo 'no record';
                return response('No data found with this Id', 250);
            }
            try {
                $result = $category->delete();
                if ($result) {
                    // echo 'project is deleted';
                    return response('Category deleted successfully', 210);
                } else {
                    // echo 'project can no be deleted';
                    return response('Data can not be deleted', 240);
                }
            } catch (Exception $e) {
                // echo 'error while deleting';
                return response('Data can not be deleted', 260);
            }
        } catch (Exception $e) {
            // echo 'error while finding';
            return response('Error while finding', 230);
        }
    }



    function updateCategoryPage(Request $request)
    {
        $userData = auth()->guard('web')->user();
        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Update Category',
            'breadcumb' => [['link' => '/', 'name' => 'dashboard'], ['name' => 'admin/category/update']],
            'userData' => $userData,
            'category' => [
                'id' => $request->id,
                'name' => $request->name,
                'image' => $request->image,
            ]
            // 'users'=>$users,
        ];

        return view('backend.pages.category.updateCategory')->with($data);
    }

    function category_updated(Request $request)
    {

        $request->validate(
            [
                'id' => 'required',
                'name' => 'required'
            ],

        );

        try {
            $category = Categories::find($request->id);
            if ($category == null) {

                Alert::error('Failed', 'No category found with this id');
                return back();
            }

            $category->name = $request->name;

            if ($request->has('image')) {

                $extension = $request->file('image')->getClientOriginalExtension();
                $time = time();
                $name = $time . '.' . $extension;

                $imageFile = 'uploads/categories/';

                $checkpath ='uploads/categories/'. $category->image;
                if(File::exists($checkpath)){
                    File::delete($checkpath);
                }

                $request->file('image')->move($imageFile , $name);
                // $url = asset($imageFile);
                $category->image = $name;
            }
            $result = $category->save();
            if ($result) {
                Alert::success('Success', ' Category has been successfully updated');
                return redirect(route('category.index'));
            } else {
                Alert::error('Failed', 'Something went wrong!');
                return back();
            }
        } catch (Exception $e) {
            Alert::error('Failed', 'No category found with this id');
            return back();
        }


    }


    ///////////////////// Products

    function totalProductsPage(Request $request)
    {
        $userData = auth()->guard('web')->user();
        $search = $request['search'] ?? "";

        if ($search != '') {
            $products = Products::query()
                ->where('name', 'LIKE', "%{$search}%")
                ->paginate(10);
            $products->appends(array('search' => $search));
        } else {
            $products = Products::paginate(10);
        }
        $categories = Categories::all();

        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Products',
            'breadcumb' => [['link' => '/', 'name' => 'dashboard'], ['name' => 'admin/products/all']],
            'search' => $search,
            'products' => $products,
            'categories' => $categories,
            'userData' => $userData,
        ];
        return view('backend.pages.products.index')->with($data);

        // return view('admin.tasks.total_tasks_page');
    }


    function createProductsPage()
    {
        $userData = auth()->guard('web')->user();
        $category = Categories::all();
        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Create Product',
            'breadcumb' => [['link' => '/', 'name' => 'dashboard'], ['name' => 'admin/products/new']],
            'category' => $category,
            'userData' => $userData,

        ];
        return view('backend.pages.products.newProduct')->with($data);
    }


    function products_created(Request $request)
    {

        $request->validate(
            [
                'name' => 'required',
                'category_id' => 'required',
                'price' => 'required',
                'image' => 'required|image',

            ]
        );

        $extension = $request->file('image')->getClientOriginalExtension();

        $product = new Products;
        $product->name = $request->name;
        $product->image = time() . '.' . $extension;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->description = $request->description;
        try {
            $data = $product->save();
            if ($data) {
                $request->file('image')->move('uploads/products/', time() . '.' . $extension);

                Alert::success('Success', 'Product has been successfully created');
                return redirect(route('products.index'));
            } else {
                Alert::error('Failed', 'Something went wrong!');
                return back();
            }
        } catch (Exception $e) {
            Alert::error('Failed', 'Product name already exist. Try with different name' . $e);
            return back();
        }
    }

    function updateProductPage(Request $request)
    {
        $userData = auth()->guard('web')->user();
        $category = Categories::all();
        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Update Product',
            'breadcumb' => [['link' => '/', 'name' => 'dashboard'], ['name' => 'admin/product/update']],
            'category' => $category,
            'userData' => $userData,
            'products' => [
                'id' => $request->id,
                'name' => $request->name,
                'image' => $request->image,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'description' => $request->description,
            ],
        ];
        return view('backend.pages.products.updateProduct')->with($data);
    }



    function product_updated(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'category_id' => 'required',
                'price' => 'required',
            ]
        );

        try {
            $product = Products::find($request->id);
            if ($product == null) {

                Alert::error('Failed', 'No Product found with this id');
                return back();
            }

            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->price = $request->price;
            $product->description = $request->description;
            $path = $product->image;


            if ($request->has('image')) {
                $extension = $request->file('image')->getClientOriginalExtension();
                $product->image = time() . '.' . $extension;
            }

            try {
                $result = $product->save();
                if ($result) {
                    if ($request->has('image')) {
                        $checkPath = 'uploads/products/' . $path;
                        if(File::exists($checkPath)){
                            File::delete($checkPath);
                        }
                        $request->file('image')->move('uploads/products/', time() . '.' . $extension);
                    }

                    Alert::success('Success', 'Product has been successfully updated');
                    return redirect(route('products.index'));
                } else {
                    Alert::error('Failed', 'Something went wrong!');
                    return back();
                }
            } catch (Exception $e) {
                Alert::error('Failed', 'Product name already exist. Try with different name' . $e);
                return back();
            }
        } catch (Exception $e) {
            Alert::error('Failed', 'No product found with this id' . $e);
            return back();
        }
    }


    function deleteTask($id)
    {
        try {
            $product = Products::find($id);
            if ($product == null) {
                // echo 'no record';
                return response('No data found with this Id', 250);
            }
            try {
                $result = $product->delete();
                if ($result) {
                    // echo 'project is deleted';
                    return response('Project deleted successfully', 210);
                } else {
                    // echo 'project can no be deleted';
                    return response('Data can not be deleted', 240);
                }
            } catch (Exception $e) {
                // echo 'error while deleting';
                return response('Data can not be deleted', 230);
            }
        } catch (Exception $e) {
            // echo 'error while finding';
            return response('Error while finding', 250);
        }
    }

    // //////////////////////////////////// total Order

    function totalOrder()
    {

        $userData = auth()->guard('web')->user();
        $orders = Order::all();

        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Total Orders',
            'breadcumb' => [['link' => '/', 'name' => 'dashboard'], ['name' => 'admin/totalOrder']],
            'userData' => $userData,
            'orders' => $orders,
        ];

        return view('backend.pages.orders.Total.index')->with($data);
    }

    function pendingOrder()
    {

        $userData = auth()->guard('web')->user();
        $orders = Order::where('status', '=', 'pending')->get();

        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Pending Orders',
            'breadcumb' => [['link' => '/', 'name' => 'dashboard'], ['name' => 'admin/pendingOrder']],
            'userData' => $userData,
            'orders' => $orders,
        ];

        return view('backend.pages.orders.Pending.index')->with($data);
    }

    function order_accepted(Request $request)
    {
        if ($request->has('id')) {
            $order = Order::find($request->id);
            if ($order != null) {
                $order->status = 'accepted';
                $check =  $order->save();
                if ($check) {
                    return redirect(route('acceptedOrder'));
                }
            }
        }
    }

    function acceptedOrder()
    {

        $userData = auth()->guard('web')->user();
        $orders = Order::where('status', '=', 'accepted')->get();

        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Accepted Orders',
            'breadcumb' => [['link' => '/', 'name' => 'dashboard'], ['name' => 'admin/acceptedOrder']],
            'userData' => $userData,
            'orders' => $orders,
        ];

        return view('backend.pages.orders.Accepted.index')->with($data);
    }

    function deliveredOrder()
    {

        $userData = auth()->guard('web')->user();
        $orders = Order::where('status', '=', 'delivered')->get();

        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Delivered Orders',
            'breadcumb' => [['link' => '/', 'name' => 'dashboard'], ['name' => 'admin/deliveredOrder']],
            'userData' => $userData,
            'orders' => $orders,
        ];

        return view('backend.pages.orders.Delivered.index')->with($data);
    }




    //////////////////////////////// profile

    function changePasswordPage()
    {
        $userData = auth()->guard('web')->user();
        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Change Password',
            'breadcumb' => [['link' => '/', 'name' => 'dashboard'], ['name' => 'admin/profile/changePassword']],
            'userData' => [
                'id' => $userData['id'],
                'name' => $userData['name'],
                'email' => $userData['email'],
            ],
            // 'users'=>$users,
        ];
        return view('backend.pages.userProfile.changePassword')->with($data);
    }

    function passwordChanged(Request $request)
    {
        $request->validate(
            [
                'old_pass' => 'required',
                'new_pass' => 'required',
                'con_pass' => 'required|same:new_pass'
            ]
        );

        $userData = auth()->guard('web')->user();
        $password = $userData['password'];
        if (Hash::check($request->old_pass, $password)) {
            $id = $userData['id'];
            $user = User::where('id', $id)->first();
            $user->password = Hash::make($request->new_pass);
            try {
                $result = $user->save();
                if ($result) {
                    Alert::success('success', 'Password is changed successfully');
                    return redirect(route('dashboard'));
                } else {
                    Alert::error('Failed', 'Something went wrong!');
                    return back();
                }
            } catch (Exception $e) {
                Alert::error('Failed', 'Something went wrong!');
                return back();
            }
        } else {
            Alert::error('Failed', 'Current password is invalid');
            return back();
        }
    }

    function userLogOut()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}
