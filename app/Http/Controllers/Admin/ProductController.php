<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductChange;
use Illuminate\Support\Facades\Auth;

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
        $product = Product::findOrFail($id);

        // Validate dữ liệu
        $request->validate([
            'image' => 'nullable|image|max:2048',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // Lưu thay đổi hình ảnh (nếu có)
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('image', 'public');
            $product->image = $imagePath;
        }

        // Lưu thay đổi và ghi lại lịch sử
        $fieldsToCheck = ['name', 'description', 'price', 'stock'];
        foreach ($fieldsToCheck as $field) {
            if ($product->$field != $request->$field) {
                ProductChange::create([
                    'product_id' => $product->id,
                    'field_changed' => $field,
                    'old_value' => $product->$field,
                    'new_value' => $request->$field,
                    'changed_by' => Auth::id(),
                    'changed_at' => now(),
                ]);
            }
        }

        // Cập nhật thông tin sản phẩm
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->save();

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
    }

    public function showProductDetails($id)
    {
        $product = Product::findOrFail($id); // Lấy sản phẩm theo ID
        $productChanges = ProductChange::where('product_id', $id)
            ->with('user') // Lấy thông tin người dùng (nếu cần)
            ->latest()
            ->get(); // Lấy lịch sử thay đổi của sản phẩm

        return view('admin.product.product_change',[
            'title' => 'Xem chi tiết sản phẩm',
            'product' => $product,
            'productChanges' => $productChanges,
        ]);
    }

}
