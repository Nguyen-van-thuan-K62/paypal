<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        return View('admin.order.index',[
            'title'=>"Danh sách đơn hàng",
            //'users'=>Order::paginate(100)
        ]);
    }
}
