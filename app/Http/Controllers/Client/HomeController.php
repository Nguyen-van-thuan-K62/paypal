<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carousel;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(){
        $menus = Product::all();
        $groupedMenus = $menus->groupBy('name');
        foreach ($groupedMenus as $key => $group) {
            $groupedMenus[$key] = $group->take(4); // Chỉ lấy 4 sản phẩm đầu tiên trong mỗi nhóm
        }
        $carousel =Carousel::all();
        return view('client.home',[
            'title'=>"Trang chủ",
        ],compact('groupedMenus','carousel'));
    }
}
