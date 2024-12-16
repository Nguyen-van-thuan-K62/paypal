<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserOrderController extends Controller
{
    public function index()
    {   
        $orderItems = Order::where('user_id', Auth::id())
        ->with('orderItems.product') // Nạp thông tin sản phẩm
        ->get();
        
        return view('user.order',[
            'title'=>'Đơn Hàng Của Tôi',
            'orderItems'=>$orderItems
        ]);
    }
    public function placeOrder(Request $request)
    {
        try {
            // Validate dữ liệu đầu vào
            $request->validate([
                'address_id' => 'required|exists:addresses,id',
                'order_items' => 'required|json',
                'total_price' => 'required|numeric|min:0',
                'payment_method' => 'required|string',
            ]);

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => Auth::id(),
                'address_id' => $request->input('address_id'),
                'total_amount' => $request->input('total_price'),
                'status' => 'pending',
                'payment_method' => $request->input('payment_method'),
            ]);

            // Thêm từng sản phẩm vào chi tiết đơn hàng
            $orderItems = json_decode($request->input('order_items'), true);
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            //xóa sản phẩm trong giỏ hàng 
            //Cart::where('user_id', Auth::id())->delete();
            Cart::where('user_id', Auth::id())
            ->where('product_id', $item['product_id'])
            ->delete();

            // Chuyển hướng đến trang thông báo thành công
            return redirect()->route('order.success')->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            // Ghi log lỗi
            Log::error('Error in placeOrder:', ['error' => $e->getMessage()]);

            // Chuyển hướng đến trang lỗi với thông báo
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.']);
        }
    }

    // Trang thông báo đặt hàng thành công
    public function orderSuccess()
    {
        return view('user.order-success', [
            'title' => 'Đặt hàng thành công',
        ]);
    }
}
