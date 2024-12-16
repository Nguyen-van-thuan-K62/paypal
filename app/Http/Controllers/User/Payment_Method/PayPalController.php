<?php

namespace App\Http\Controllers\User\Payment_Method;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Product;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    /**
     * Get PayPal provider instance with credentials.
     */
    private function getPayPalProvider()
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        return $provider;
    }

    /**
     * Create a PayPal payment and redirect to the approval URL.
     */
    public function createPayment()
    {
        $latestCheckout = Checkout::where('user_id', Auth::id())->latest('id')->first();

        if (!$latestCheckout) {
            return redirect()->route('checkout.view')->with('error', 'No checkout record found.');
        }

        $items = json_decode($latestCheckout->selected_items, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->route('checkout.view')->with('error', 'Invalid order data.');
        }

        $finalTotal = collect($items)->sum(fn($item) => $item['price'] * $item['quantity']);

        try {
            $provider = $this->getPayPalProvider();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "purchase_units" => [[
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $finalTotal,
                    ],
                ]],
            ]);

            $approvalLink = collect($response['links'] ?? [])->firstWhere('rel', 'approve')['href'] ?? null;

            if ($approvalLink) {
                return redirect()->away($approvalLink);
            }
            return redirect()->route('paypal.payment.cancel')->with('error', 'Approval link not found.');
        } catch (\Exception $e) {
            Log::error('PayPal payment error:', ['message' => $e->getMessage()]);
            return redirect()->route('paypal.payment.cancel')->with('error', 'An error occurred while processing your payment.');
        }
    }

    /**
     * Handle payment success and capture payment order.
     */
    public function paymentSuccess(Request $request)
    {
        $token = $request->query('token');
        $id = $request->query('id');

        if (!$token) {
            return redirect()->route('paypal.payment.cancel')->with('error', 'Token not found.');
        }

        try {
            $provider = $this->getPayPalProvider();
            $response = $provider->capturePaymentOrder($token);

            if ($response['status'] ?? '' === 'COMPLETED') {
                if ($id && $product = Product::find($id)) {
                    // Perform any additional logic here, e.g., update order status
                }
                return redirect()->route('home')->with('success', 'Transaction complete.');
            }

            return redirect()->route('paypal.payment.cancel')->with('error', 'Payment not completed.');
        } catch (\Exception $e) {
            Log::error('PayPal capture error:', ['error' => $e->getMessage()]);
            return redirect()->route('paypal.payment.cancel')->with('error', 'Failed to capture payment.');
        }
    }

    /**
     * Handle payment cancellation.
     */
    public function paymentCancel()
    {
        return redirect()->route('checkout.view')->with('error', 'Transaction canceled.');
    }
}
