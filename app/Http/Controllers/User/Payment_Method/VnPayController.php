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
        //dd($amount);
         // Tạo mã giao dịch duy nhất
        $transactionId = 'ORDER_' . time() . '_' . Auth::id();
        //dd($transactionId);
        // Generate VNPAY payment URL
        $vnpayUrl = VnPayHelper::buildPaymentUrl($orderInfo, $amount,$transactionId);

        // Redirect the user to VNPAY payment page
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
                    //$order->status = 'completed';
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
            }

            //xóa sản phẩm trong giỏ hàng 
            Cart::where('user_id', Auth::id())
            ->where('product_id', $item['product']['id'])
            ->delete();

            return redirect()->route('order.success');
        } else {
            // Failed transaction
            return view('payment.failed');
        }
    }
}
