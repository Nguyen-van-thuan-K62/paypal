<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Carousel;

class DashboardController extends Controller
{
    // public function index(){
    //     return View('admin.dashboard',[
    //         'title'=>"Quản Trị Admin",
    //         'users'=>User::paginate(5)
    //     ]);
    // }  
    
    public function index()
    {
        $products = Product::latest()->take(5)->get();
        $users = User::latest()->take(5)->get();
        $orders = Order::with('user')->latest()->take(5)->get();
        $comments = Comment::latest()->take(5)->get();
        $carousels = Carousel::latest()->take(5)->get();

        return view('admin.dashboard', [
            'title' => 'Quản trị Admin',
            'products' => $products,
            'users' => $users,
            'orders' => $orders,
            'comments' => $comments,
            'carousels' => $carousels,
        ]);
    }

}
