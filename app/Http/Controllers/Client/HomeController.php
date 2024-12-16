<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carousel;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(){
        $menunike = Product::where('name', 'LIKE', '%' . 'nike' . '%')->get();
        $menujordan = Product::where('name', 'LIKE', '%' . 'jordan' . '%')->get();
        $carousel =Carousel::all();
        return view('client.home',[
            'title'=>"Trang Chu",
        ],compact('menunike','menujordan','carousel'));
    }
}
