<?php

namespace App\Http\Controllers\User\Payment_Method;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\VnPayHelper;
use Illuminate\Support\Facades\Auth;
use App\Models\Checkout;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Product;


class VnPayController extends Controller
{
    public function payment(Request $request)
    {
        $orderInfo = "Thanh toán đơn hàng";
        $latestCheckout = Checkout::where('user_id', Auth::id())
                          ->orderBy('id', 'desc')
                          ->first();
        $items = json_decode($latestCheckout->selected_items, true);
        $amount = collect($items)->sum(fn($item) => $item['price'] * $item['quantity'] +30000);
        
         // Tạo mã giao dịch duy nhất
        $transactionId = '' . time() . '_' . Auth::id();
        
        // Tạo URL thanh toán VNPAY
        $vnpayUrl = VnPayHelper::buildPaymentUrl($orderInfo, $amount,$transactionId);

        // Chuyển hướng người dùng đến trang thanh toán VNPAY
        return redirect()->to($vnpayUrl);
    }

    public function callback(Request $request)
    {
        $vnp_ResponseCode = $request->vnp_ResponseCode;
        $vnp_TxnRef = $request->vnp_TxnRef;

        if ($vnp_ResponseCode == '00') {
            //xu ly logic và luu thong tin don hang
            $latestCheckout = Checkout::where('user_id', Auth::id())
                          ->orderBy('id', 'desc')
                          ->first();
            $addressItems = Address::where('user_id', Auth::id())->get();
            $addressItemsfirst = $addressItems->first();
            $items = json_decode($latestCheckout->selected_items, true);
            $finalTotal = collect($items)->sum(fn($item) => $item['price'] * $item['quantity'] +30000);
            $order = new Order();
                    $order->user_id = Auth::id();
                    $order->address_id = $addressItemsfirst['id'];
                    $order->total_amount = $finalTotal;
                    $order->payment_method = 'VnPay'; // Lưu phương thức thanh toán
                    $order->transaction_id = $request->vnp_TxnRef; // Lưu mã giao dịch
                    $order->save();
                    
            foreach ($items as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id; // ID của đơn hàng vừa tạo
                $orderItem->product_id =$item['product']['id']; // ID sản phẩm
                $orderItem->quantity = $item['quantity']; // Số lượng sản phẩm
                $orderItem->price = $item['price'];
                $orderItem->size = $item['size'];
                $orderItem->save();

                //xóa sản phẩm trong giỏ hàng 
                Cart::where('user_id', Auth::id())
                ->where('product_id', $item['product']['id'])
                ->delete();

                // Giảm số lượng sản phẩm (stock) trong kho
                $product = Product::find($item['product']['id']);
                if ($product) {
                    $product->stock -= $item['quantity'];
                    $product->sold_quantity += $item['quantity'];

                    // Kiểm tra nếu số lượng tồn kho âm thì báo lỗi
                    if ($product->stock < 0) {
                        throw new \Exception("Số lượng sản phẩm không đủ trong kho.");
                    }
                    // Lưu thay đổi số lượng tồn kho và số lượng đã bán
                    $product->save();
                    }
            }

            return redirect()->route('order.success');
        } else {
            return view('user.userhome');
        }
    }
}
