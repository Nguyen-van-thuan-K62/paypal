<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    //thông báo chuyển sang vnpay
    public function vnpay()
    {
        return view('user.payment_method.vnpay',[
            'title' => 'Thanh toán bằng vnpay',
        ]);
    }    

    public function credit_card()
    {
        return view('user.payment_method.credit_card',[
            'title' => 'Thanh toán bằng thẻ tín dụng',
        ]);
    }

    //Thông báo chuyển sang paypal 
    public function paypal()
    {
        return view('user.payment_method.paypal',[
            'title' => 'Thanh toán bằng paypal',
        ]);
    }

}
