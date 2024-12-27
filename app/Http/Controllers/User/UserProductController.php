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
        $menus = Product::all();
        $menunike = Product::where('name', 'Giày Nike')->get();
        $menuadidas = Product::where('name', 'Giày Adidas')->get();
        $menuMcqueen = Product::where('name', 'Giày Mcqueen')->get();
        $menuBalenciaga = Product::where('name', 'Giày Balenciaga')->get();
        $menuPuma = Product::where('name', 'Giày Puma')->get();
        $menuMLB = Product::where('name', 'Giày MLB')->get();

        return view('user.product',[
            'title'=>"Product",
        ],compact('menus','menunike','menuadidas','menuMcqueen','menuBalenciaga','menuPuma','menuMLB'));        
    }
}
