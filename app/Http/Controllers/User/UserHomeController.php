<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Carousel;

class UserHomeController extends Controller
{
    public function index(){

        $menunike = Product::where('name', 'LIKE', '%' . 'nike' . '%')->get();
        $menuadidas = Product::where('name', 'LIKE', '%' . 'adidas' . '%')->get();
        $menulacoste = Product::where('name', 'LIKE', '%' . 'lacoste' . '%')->get();
        $carousel =Carousel::all();
        return view('user.userhome',[
            'title'=>"User",
        ],compact('menunike','menuadidas','carousel','menulacoste'));
    }
    
    public function details($id)
    {
        $products = Product::findOrFail($id);
        return view('user.details', [
            'title' => 'details',
            'products' => $products
        ]);
    }

}
