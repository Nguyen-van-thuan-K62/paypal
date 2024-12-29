<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
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

    // public function saveSelected(Request $request)
    // {
    //     // Decode dữ liệu JSON từ request
    //     $items = json_decode($request->input('items'), true);

    //     // Kiểm tra nếu không có sản phẩm được chọn
    //     if (!$items || count($items) === 0) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Không có sản phẩm nào được chọn'
    //         ]);
    //     }

    //     // Lưu lỗi hoặc thông báo
    //     $errors = [];

    //     // Kiểm tra từng sản phẩm
    //     foreach ($items as $item) {
    //         // Kiểm tra ID sản phẩm và số lượng
    //         if (!isset($item['id'], $item['quantity']) || $item['quantity'] <= 0) {
    //             $errors[] = "Dữ liệu sản phẩm không hợp lệ.";
    //             continue;
    //         }

    //         // Tìm sản phẩm
    //         $product = Product::find($item['id']);
    //         if (!$product) {
    //             $errors[] = "Sản phẩm với ID {$item['id']} không tồn tại.";
    //             continue;
    //         }

    //         // Kiểm tra tồn kho
    //         if ($product->stock < $item['quantity']) {
    //             $errors[] = "Sản phẩm {$product->name} không đủ hàng trong kho.";
    //             continue;
    //         }
    //     }

    //     // Nếu có lỗi, trả về thông báo
    //     if (count($errors) > 0) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Có lỗi với các sản phẩm được chọn',
    //             'errors' => $errors
    //         ]);
    //     }

    //     // Lưu các sản phẩm hợp lệ vào session
    //     session(['selected_cart_items' => $items]);

    //     // Sau khi lưu, chuyển hướng tới checkout
    //     return redirect()->view('user.checkout')->with('success', 'Sản phẩm được chọn đã lưu thành công');
    // }


}
