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

        // $menunike = Product::where('name', 'LIKE', '%' . 'nike' . '%')->get();
        // $menuadidas = Product::where('name', 'LIKE', '%' . 'adidas' . '%')->get();
        // $menulacoste = Product::where('name', 'LIKE', '%' . 'lacoste' . '%')->get();
        $menus = Product::all();
        $groupedMenus = $menus->groupBy('name');
        foreach ($groupedMenus as $key => $group) {
            $groupedMenus[$key] = $group->take(4); // Chỉ lấy 4 sản phẩm đầu tiên trong mỗi nhóm
        }
        $carousel =Carousel::all();
        return view('user.userhome',[
            'title'=>"User",
        ],compact('groupedMenus','carousel'));
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
