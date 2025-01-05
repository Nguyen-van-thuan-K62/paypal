<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carousel;
use App\Models\Product;

class HomeController extends Controller
{
    // Hiển thị trang chủ
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

    // Hiển thị trang sản phẩm
    public function product()
    {
        $menus = Product::all();
        $menunike = Product::where('name', 'Giày Nike')->get();
        $menuadidas = Product::where('name', 'Giày Adidas')->get();
        $menuMcqueen = Product::where('name', 'Giày Mcqueen')->get();
        $menuBalenciaga = Product::where('name', 'Giày Balenciaga')->get();
        $menuPuma = Product::where('name', 'Giày Puma')->get();
        $menuMLB = Product::where('name', 'Giày MLB')->get();

        return view('client.product',[
            'title'=>"Sản phẩm",
        ],compact('menus','menunike','menuadidas','menuMcqueen','menuBalenciaga','menuPuma','menuMLB'));        
    }

    // Hiển thị trang chi tiết sản phẩm
    public function show($id)
    {
        $products = Product::findOrFail($id);
        return view('client.details', [
            'title' => 'details',
            'products' => $products
        ]);
    }

    // Hiển thị trang tìm kiếm
    public function search(Request $request)
    {
        $search = $request->input('search');
        if (!$search) {
            return redirect()->route('client.home');
        }
        $products = Product::where('name', 'like', "%{$search}%")
                 ->orWhere('description', 'like', "%{$search}%")
                 ->get();
        return view('client.search', [
            'title' => 'search',
            'products' => $products,
            'search' => $search
        ]);
    }

    // Hiển thị trang giới thiệu
    public function aboutus()
    {
        return view('client.aboutus',[
            'title'=>"Giới thiệu",
        ]);
    }
    // Hiển thị trang liên hệ
    public function contactus()
    {
        return view('client.contactus',[
            'title'=>"Liên hệ",
        ]);
    }

}
