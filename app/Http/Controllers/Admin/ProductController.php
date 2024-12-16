<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;



class ProductController extends Controller
{
    public function index(){
        return View('admin.product.index',[
            'title'=>'Danh sách sản phẩm',
            'lists' =>Product::paginate(100),
        ]);
    }

    public function create(){
        return View('admin.product.create',[
            'title' =>"Thêm sản phẩm mới",
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|image|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
        ]);
        try {
            $imagePath = $request->file('image')->store('images', 'public');
            Product::create([
                'image' => $imagePath,
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'price' => $validatedData['price'],
                'stock' => $validatedData['stock'],
            ]);
            Session::flash('success', 'Thêm thành công sản phẩm');
            return redirect()->route('admin.product.index');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return redirect()->back()->withInput();
        }
    }
    public function edit($id){
        $menu = Product::findOrFail($id);
        return view('admin.product.edit',[
            'title' => "Sửa thông tin sản phẩm",
        ] ,compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menus = Product::findOrFail($id);
        $request->validate([
            'image' => 'nullable|image|max:2048', 
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);
        if ($request->hasFile('image')) {
            if ($menus->image) {
                Storage::disk('public')->delete($menus->image);
            }
            $imagePath = $request->file('image')->store('image', 'public');
            $menus->image = $imagePath;
        }
        $menus->name = $request->input('name');
        $menus->description = $request->input('description');
        $menus->price = $request->input('price');
        $menus->stock = $request->input('stock');
        $menus->save();
        Session::flash('success', 'Sửa thành công');
        return redirect()->route('admin.product.index');
    }

    public function delete($id)
    {
        try {
        
            $menu = Product::findOrFail($id);  
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $menu->delete();
            Session::flash('success', 'Xóa thành công sản phẩm');
        } catch (\Exception $err) {
            Session::flash('error', 'Đã có lỗi xảy ra: ' . $err->getMessage());
        }
        return redirect()->back();
    }

    public function search(){
        return view('admin.product.search',[
            'title' =>'Tìm  kiếm sản phẩm ',
        ]);
    }

    public function searchFullText(Request $request)
    {
        $query = $request->input('name');
    
        $results = Product::where('name', 'LIKE', "%{$query}%")->get();
        
        return response()->json($results);
        // return view('admin.product.search_results', compact('results'));
    }

}
