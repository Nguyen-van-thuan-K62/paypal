<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function bank_transfer()
    {
        return view('user.payment_method.bank_transfer',[
            'title' => 'Chuyển khoản ngân hàng',
        ]);
    }    
    public function credit_card()
    {
        return view('user.payment_method.credit_card',[
            'title' => 'Thanh toán bằng thẻ tín dụng',
        ]);
    }

    // ***Thực hiện thanh toán bằng paypal***

    //Thông báo chuyển sang paypal 
    public function paypal()
    {
        return view('user.payment_method.paypal',[
            'title' => 'Thanh toán bằng paypal',
        ]);
    }
    

    
}
