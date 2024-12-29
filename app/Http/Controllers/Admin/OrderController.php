<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{   
    //xem danh sach dơn hànghàng
    public function index()
    {
        $pendingOrders = Order::where('status', 'pending')->with('address')->get();
        $confirmedOrders = Order::where('status', 'confirmed')->with('address')->get();
        $preparingOrders = Order::where('status', 'preparing')->with('address')->get();
        $readyToShipOrders = Order::where('status', 'ready_to_ship')->with('address')->get();
        $deliveredOrders = Order::where('status', 'delivered')->with('address')->get();
        $cancelledOrders = Order::where('status', 'cancelled')->with('address')->get();

        return view('admin.order.index', [
            'title' => "Danh sách đơn hàng",
            'pendingOrders' => $pendingOrders,
            'confirmedOrders' => $confirmedOrders,
            'preparingOrders' => $preparingOrders,
            'readyToShipOrders' => $readyToShipOrders,
            'deliveredOrders' => $deliveredOrders,
            'cancelledOrders' => $cancelledOrders,
        ]);
    }

    //xem chi tiet don hanghang
    public function show($id)
    {
        $order = Order::with(['address', 'orderItems.product'])->findOrFail($id); // Lấy đơn hàng theo ID
        return view('admin.order.show',[
            'title'=>"Chi tiết đơn hàng",
            'order'=>$order
        ]);
    }

    //chuyen trang thai don hang 
    public function updateStatus($id)
    {
        $order = Order::findOrFail($id);

        // Xác định trạng thái tiếp theo
        $nextStatus = match ($order->status) {
            'pending' => 'confirmed',
            'confirmed' => 'preparing',
            'preparing' => 'ready_to_ship',
            'ready_to_ship' => 'delivered',
            default => null,
        };

        if ($nextStatus) {
            $order->status = $nextStatus;
            $order->save();

            return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
        }

        return redirect()->back()->with('error', 'Không thể chuyển trạng thái đơn hàng.');
    }
    

}
