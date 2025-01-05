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

    public function aboutus()
    {
        return view('user.aboutus',[
            'title'=>"Giới thiệu",
        ]);
    }

    public function contactus()
    {
        return view('user.contactus',[
            'title'=>"Liên hệ",
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        if (!$search) {
            return redirect()->route('home');
        }
        $products = Product::where('name', 'like', "%{$search}%")
                 ->orWhere('description', 'like', "%{$search}%")
                 ->get();
        return view('user.search', [
            'title' => 'Tìm kiếm sản phẩm',
            'products' => $products,
            'search' => $search
        ]);
    }

}
