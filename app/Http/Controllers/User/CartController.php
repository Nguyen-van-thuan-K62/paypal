<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index(){
        return View('user.cart',[
            'title'=>"cart",
        ]);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        // Kiểm tra nếu sản phẩm đã có trong giỏ hàng của người dùng
        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->where('size', $request->input('size')) // Thêm điều kiện size
            ->first();

        if ($cart) {
            // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
            $cart->quantity += $request->input('quantity', 1);
            $cart->save();
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->input('quantity', 1),
                'size' => $request->input('size'), // Lưu size
                'price' => $product->price, // Lưu giá sản phẩm
            ]);
        }
        
        return redirect()->back()->with('success', 'Bạn đã thêm sản phẩm vào giỏ hàng !');
    }

    // Xem giỏ hàng
    public function viewCart()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        return view('user.cart',[
            'title'=>"cart",
        ],compact('cartItems'));
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->first();

        if ($cart) {
            $cart->delete();
        }

        return redirect()->back()->with('success', 'Đã xóa sẩn phầm khỏi giỏ hàng của bạn!');
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCart(Request $request, $id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->first();

        if ($cart) {
            $cart->quantity = $request->input('quantity', 1);
            $cart->save();
        }

        return redirect()->back()->with('success', 'Giỏ hàng vừa được cập nhập!');
    }
    
    // mua hàng
    public function buyNow(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Kiểm tra nếu sản phẩm đã có trong giỏ hàng của người dùng
        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->where('size', $request->input('size')) // Thêm điều kiện size
            ->first();

        if ($cart) {
            // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
            $cart->quantity += $request->input('quantity', 1);
            $cart->save();
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->input('quantity', 1),
                'size' => $request->input('size'), // Lưu size
                'price' => $product->price, // Lưu giá sản phẩm
            ]);
        }
        
        // Chuyển hướng đến trang giỏ hàng
        return redirect()->route('cart.view')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

}
