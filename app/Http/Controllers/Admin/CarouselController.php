<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class CarouselController extends Controller
{
    public function index(){
        return View('admin.carousel.index',[
            'title'=>'Danh sách ảnh động',
            'lists' =>Carousel::paginate(100),
        ]);
    }

    public function create(){
        return View('admin.carousel.create',[
            'title' =>"Thêm ảnh động mới",
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|image|max:2048',
        ]);
        try {
            $imagePath = $request->file('image')->store('images', 'public');
            Carousel::create([
                'image' => $imagePath,
            ]);
            Session::flash('success', 'Thêm thành công sản phẩm');
            return redirect()->route('admin.carousel.index');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($id){
        $menu = Carousel::findOrFail($id);
        return view('admin.carousel.edit',[
            'title' => "Sửa ảnh động",
        ] ,compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menus = Carousel::findOrFail($id);
        $request->validate([
            'image' => 'nullable|image|max:2048', 
        ]);
        if ($request->hasFile('image')) {
            if ($menus->image) {
                Storage::disk('public')->delete($menus->image);
            }
            $imagePath = $request->file('image')->store('image', 'public');
            $menus->image = $imagePath;
        }
        $menus->save();
        Session::flash('success', 'Sửa thành công');
        return redirect()->route('admin.carousel.index');
    }

    public function delete($id)
    {
        try {
        
            $menu = Carousel::findOrFail($id);  
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
}
