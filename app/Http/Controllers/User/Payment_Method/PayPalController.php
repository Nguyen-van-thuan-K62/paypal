<?php

namespace App\Http\Controllers\User\Payment_Method;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    // Thực hiện thanh toán
    public function payment(Request $request)
    {
        $latestCheckout = Checkout::where('user_id', Auth::id())
                          ->orderBy('id', 'desc')
                          ->first();

        if (!$latestCheckout) {
            Log::error('Không tìm thấy mục menu cho ID:');
            return response()->json(['error' => 'Không tìm thấy mục menu'], 404);
        }

        $items = json_decode($latestCheckout->selected_items, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->route('checkout.view')->with('error', 'Dữ liệu đơn hàng không hợp lệ.');
        }

        $finalTotal = collect($items)->sum(fn($item) => $item['price'] * $item['quantity'] +30000);
        $finalTotal = $finalTotal/25000;
        
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $provider->setAccessToken($paypalToken);

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal.payment.success'), // URL khi thanh toán thành công
                    "cancel_url" => route('paypal.payment.cancel'),
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $finalTotal,
                        ],
                    ],
                ],
            ]);
            if (isset($response['id']) && !empty($response['id'])) {
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }
                return redirect()->route('paypal.payment.cancel')->with('error', 'Không tìm thấy liên kết phê duyệt.');
            } else {
                return redirect()->route('paypal.payment.cancel')->with('error', $response['message'] ?? 'Đã xảy ra sự cố.');
            }
        } catch (\Exception $e) {
            Log::error('PayPal payment error:', ['message' => $e->getMessage()]);
            return redirect()->route('paypal.payment.cancel')->with('error', 'Đã xảy ra lỗi trong khi xử lý thanh toán của bạn.');
        }
    }

    public function paymentCancel()
    {
        return view('cancle')->with('error', 'Bạn đã hủy giao dịch.');
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $token = $request->query('token');
        $id = $request->query('id'); // Truy xuất ID từ truy vấn yêu cầu
      //  dd($id);
        Log::info('PayPal token:', ['token' => $token]);

        if ($token) {
            try {
                $response = $provider->capturePaymentOrder($token);
                //dd($response);
                // Lấy mã giao dịch từ phản hồi
                //$transaction_id = $response['purchase_units'][0]['payments']['captures'][0]['id'];
                Log::info('PayPal capture response:', ['response' => $response]);

                if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                    $latestCheckout = Checkout::where('user_id', Auth::id())
                          ->orderBy('id', 'desc')
                          ->first();

                    $addressItems = Address::where('user_id', Auth::id())->get();
                    $addressItemsfirst = $addressItems->first();
                    if (!$latestCheckout) {
                        return redirect()->route('checkout.view')->with('error', 'Không tìm thấy hồ sơ thanh toán.');
                    }
                    $items = json_decode($latestCheckout->selected_items, true);
                    $finalTotal = collect($items)->sum(fn($item) => $item['price'] * $item['quantity'] +30000);
                    // Tạo đơn hàng mới
                    $order = new Order();
                    $order->user_id = Auth::id();
                    $order->address_id = $addressItemsfirst['id'];
                    $order->total_amount = $finalTotal;
                    $order->payment_method = 'paypal'; // Lưu phương thức thanh toán
                    $order->transaction_id = $response['id']; // Lưu mã giao dịch
                    $order->save();

                    //Lưu thông tin chi tiết sản phẩm vào bảng order_items
                    foreach ($items as $item) {
                        $orderItem = new OrderItem();
                        $orderItem->order_id = $order->id; // ID của đơn hàng vừa tạo
                        $orderItem->product_id =$item['product']['id']; // ID sản phẩm
                        $orderItem->quantity = $item['quantity']; // Số lượng sản phẩm
                        $orderItem->price = $item['price']; // Giá của sản phẩm
                        $orderItem->size = $item['size']; // Giá của sản phẩm
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
                    
                    return redirect()->route('order.success')->with('success', 'Giao dịch hoàn tất.');
                } else {
                    return redirect()->route('paypal.payment.cancel')->with('error', $response['message'] ?? 'Đã xảy ra sự cố.');
                }
            } catch (\Exception $e) {
                Log::error('PayPal capture error:', ['error' => $e->getMessage()]);
                return redirect()->route('paypal.payment.cancel')->with('error', $e->getMessage());
            }
        } else {
            return redirect()->route('paypal.payment.cancel')->with('error', 'Không tìm thấy mã thông báo.');
        }
    }
}
