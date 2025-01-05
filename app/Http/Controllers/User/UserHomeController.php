<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Carousel;

class UserHomeController extends Controller
{
    // Hiển thị trang chủ
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
    
    // Hiển thị chi tiết sản phẩm
    public function details($id)
    {
        $products = Product::findOrFail($id);
        return view('user.details', [
            'title' => 'details',
            'products' => $products
        ]);
    }

    // Hiển thị trang giới thiệu
    public function aboutus()
    {
        return view('user.aboutus',[
            'title'=>"Giới thiệu",
        ]);
    }

    // Hiển thị trang liên hệ
    public function contactus()
    {
        return view('user.contactus',[
            'title'=>"Liên hệ",
        ]);
    }

    //chức năng tìm kiếm
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
