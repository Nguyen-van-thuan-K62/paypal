<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Carousel;
class UserProductController extends Controller
{
    //
    public function index()
    {
        $menunike = Product::where('name', 'LIKE', '%' . 'nike' . '%')->get();
        $menujordan = Product::where('name', 'LIKE', '%' . 'jordan' . '%')->get();
        return view('user.product',[
            'title'=>"Product",
        ],compact('menunike','menujordan'));        
    }
}
