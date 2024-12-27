<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Address;
use App\Models\Checkout;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function viewCheckout(Request $request)
    {
        // Lấy địa chỉ đầu tiên và tất cả địa chỉ trong một lần truy vấn
        $addressItems = Address::where('user_id', Auth::id())->get();
        $addressItemsfirst = $addressItems->first();

        // Lấy dữ liệu selected_items từ request và giải mã JSON
        $selectedItems = $request->input('selected_items') ? json_decode($request->input('selected_items'), true) : [];

        // Kiểm tra nếu selectedItems rỗng, dừng và chuyển hướng về giỏ hàng
        if (empty($selectedItems)) {
            return redirect()->route('cart.view')->with('error', 'Không có sản phẩm nào được chọn.');
        }

        // Lấy danh sách các ID sản phẩm từ selectedItems để truy vấn một lần
        $cartIds = array_column($selectedItems, 'id');
        $productIds = Cart::whereIn('id', $cartIds)->pluck('product_id')->toArray();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        // Tạo danh sách orderItems dựa trên selectedItems và các sản phẩm đã truy vấn
        $orderItems = [];
        foreach ($selectedItems as $item) {
            $cartProductId = Cart::where('id', $item['id'])->value('product_id');
            if ($cartProductId && isset($products[$cartProductId])) {
                $product = $products[$cartProductId];
                $orderItems[] = (object) [
                    'product' => $product,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'size' =>$item['size'], // Assuming size comes from user selection
                ];
            }
        }

        // Lưu thông tin tạm thời vào bảng checkouts
        $checkout = Checkout::create([
            'user_id' => Auth::id(),
            'selected_items' => json_encode($orderItems), // Lưu dưới dạng JSON
            'default_address_id' => $addressItemsfirst ? $addressItemsfirst->id : null, // Lưu địa chỉ mặc định (nếu có)
        ]);

        // Trả về view với các dữ liệu cần thiết
        return view('user.checkout', [
            'title' => "order",
            'orderItems' => $orderItems,
            'addressItems' => $addressItems,
            'addressItemsfirst' => $addressItemsfirst,
        ]);
    }

    public function viewSavedCheckout()
    {
        $checkout = Checkout::where('user_id', Auth::id())->latest()->first();

        if (!$checkout) {
            return redirect()->route('cart.view')->with('error', 'Không có thông tin đơn hàng tạm thời.');
        }
        
        $orderItems = json_decode($checkout->selected_items); 
        //$orderItems = json_decode($checkout->selected_items, true);
        $addressItems = Address::where('user_id', Auth::id())->get();
        $addressItemsfirst = Address::find($checkout->default_address_id);

        return view('user.checkout', [
            'title' => "Saved Order",
            'orderItems' => $orderItems,
            'addressItems' => $addressItems,
            'addressItemsfirst' => $addressItemsfirst,
        ]);
    }

}
