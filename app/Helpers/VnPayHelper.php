<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class VnPayHelper
{
    // Merchant Information
    

    public static function buildPaymentUrl($orderInfo, $amount,$transactionId)
    {
        $VNP_TMN_CODE = 'D532QTG8';
        $VNP_SECRET_KEY = 'I9CB6MH76YJDLFOR7YK17AZ7J6LZY80F';
        $VNP_API_URL = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';  // Sandbox URL for testing
        $VNP_RETURN_URL = route('vnpay.callback');
        //$txnRef = time();  // Transaction reference, typically order ID
        $createDate = date('YmdHis');
        $ipAddr = request()->ip();
        $locale = 'vn';  // Local language: 'vn' for Vietnamese, 'en' for English

        // Build query parameters
        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $VNP_TMN_CODE,
            "vnp_Amount" => $amount * 100,  // Convert amount to VND (cents)
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $createDate,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $ipAddr,
            "vnp_Locale" => $locale,
            "vnp_OrderInfo" => $orderInfo,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $VNP_RETURN_URL,
            "vnp_TxnRef" => $transactionId,
        ];

        // Sort the data alphabetically
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata ="";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $VNP_API_URL . "?" . $query;
        if (isset($VNP_SECRET_KEY)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $VNP_SECRET_KEY);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return $vnp_Url;
    }
}
