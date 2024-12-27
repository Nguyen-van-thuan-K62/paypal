<?php

namespace App\Http\Controllers\User\Payment_Method;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Cart;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    public function payment(Request $request)
    {
        $latestCheckout = Checkout::where('user_id', Auth::id())
                          ->orderBy('id', 'desc')
                          ->first();

        if (!$latestCheckout) {
            Log::error('Menu item not found for ID:');
            return response()->json(['error' => 'Menu item not found'], 404);
        }

        $items = json_decode($latestCheckout->selected_items, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->route('checkout.view')->with('error', 'Invalid order data.');
        }

        $finalTotal = collect($items)->sum(fn($item) => $item['price'] * $item['quantity'] +30000);
        //dd($finalTotal);
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $provider->setAccessToken($paypalToken);

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal.payment.success'), // Pass the ID to the success route
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
                return redirect()->route('paypal.payment.cancel')->with('error', 'Approval link not found.');
            } else {
                return redirect()->route('paypal.payment.cancel')->with('error', $response['message'] ?? 'Something went wrong.');
            }
        } catch (\Exception $e) {
            Log::error('PayPal payment error:', ['message' => $e->getMessage()]);
            return redirect()->route('paypal.payment.cancel')->with('error', 'An error occurred while processing your payment.');
        }
    }

    public function paymentCancel()
    {
        return view('cancle')->with('error', 'You have canceled the transaction.');
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $token = $request->query('token');
        $id = $request->query('id'); // Retrieve the ID from the request query
        Log::info('PayPal token:', ['token' => $token]);

        if ($token) {
            try {
                $response = $provider->capturePaymentOrder($token);
                Log::info('PayPal capture response:', ['response' => $response]);

                if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                    $latestCheckout = Checkout::where('user_id', Auth::id())
                          ->orderBy('id', 'desc')
                          ->first();

                    $addressItems = Address::where('user_id', Auth::id())->get();
                    $addressItemsfirst = $addressItems->first();
                    if (!$latestCheckout) {
                        return redirect()->route('checkout.view')->with('error', 'No checkout record found.');
                    }
                    $items = json_decode($latestCheckout->selected_items, true);
                    $finalTotal = collect($items)->sum(fn($item) => $item['price'] * $item['quantity'] +30000);
                    //$product_id = collect($items)->sum(fn($item) => $item['name']);
                    //dd($items);

                    //dd($addressItemsfirst);
                    // Lưu thông tin đơn hàng
                    //dd($items['product_id']);
                    $order = new Order();
                    $order->user_id = Auth::id();
                    $order->address_id = $addressItemsfirst['id'];
                    $order->total_amount = $finalTotal;
                    // $order->status = 'completed';
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
                    }
                    
                    //xóa sản phẩm trong giỏ hàng 
                    Cart::where('user_id', Auth::id())
                    ->where('product_id', $item['product']['id'])
                    ->delete();
                    
                     // Mark the checkout as completed
                    // $latestCheckout->status = 'completed';
                    // $latestCheckout->save();

                    return redirect()->route('order.success')->with('success', 'Transaction complete.');
                } else {
                    return redirect()->route('paypal.payment.cancel')->with('error', $response['message'] ?? 'Something went wrong.');
                }
            } catch (\Exception $e) {
                Log::error('PayPal capture error:', ['error' => $e->getMessage()]);
                return redirect()->route('paypal.payment.cancel')->with('error', $e->getMessage());
            }
        } else {
            return redirect()->route('paypal.payment.cancel')->with('error', 'Token not found.');
        }
    }
}
