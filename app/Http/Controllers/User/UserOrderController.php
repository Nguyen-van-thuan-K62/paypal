<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserOrderController extends Controller
{
    public function index()
    {   
        $userId = Auth::id(); // Lấy ID của người dùng hiện tại
        
        $pendingOrders = Order::where('status', 'pending')->where('user_id', $userId)->with('address')->get();
        $confirmedOrders = Order::where('status', 'confirmed')->where('user_id', $userId)->with('address')->get();
        $preparingOrders = Order::where('status', 'preparing')->where('user_id', $userId)->with('address')->get();
        $readyToShipOrders = Order::where('status', 'ready_to_ship')->where('user_id', $userId)->with('address')->get();
        $deliveredOrders = Order::where('status', 'delivered')->where('user_id', $userId)->with('address')->get();
        $cancelledOrders = Order::where('status', 'cancelled')->where('user_id', $userId)->with('address')->get();
        
        // Lấy tất cả đơn hàng của người dùng hiện tại
        $orderItems = Order::where('user_id', $userId)->with('address')->get();
        
        return view('user.order', [
            'title' => "Danh sách đơn hàng",
            'pendingOrders' => $pendingOrders,
            'confirmedOrders' => $confirmedOrders,
            'preparingOrders' => $preparingOrders,
            'readyToShipOrders' => $readyToShipOrders,
            'deliveredOrders' => $deliveredOrders,
            'cancelledOrders' => $cancelledOrders,
            'orderItems' => $orderItems,
        ]);
    }

    // Hàm tạo đơn hàng
    public function placeOrder(Request $request)
    {
        try {
            // Validate dữ liệu đầu vào
            $request->validate([
                'address_id' => 'required|exists:addresses,id',
                'order_items' => 'required|json',
                'total_price' => 'required|numeric|min:0',
                'payment_method' => 'required|string',
            ]);

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => Auth::id(),
                'address_id' => $request->input('address_id'),
                'total_amount' => $request->input('total_price'),
                'status' => 'pending',
                'payment_method' => $request->input('payment_method'),
            ]);

            // Thêm từng sản phẩm vào chi tiết đơn hàng
            $orderItems = json_decode($request->input('order_items'), true);
            //dd($orderItems);
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'size' => $item['sizeValue'],
                ]);
            }

            //xóa sản phẩm trong giỏ hàng 
            //Cart::where('user_id', Auth::id())->delete();
            Cart::where('user_id', Auth::id())
            ->where('product_id', $item['product_id'])
            ->delete();

            // Chuyển hướng đến trang thông báo thành công
            return redirect()->route('order.success')->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            // Ghi log lỗi
            Log::error('Error in placeOrder:', ['error' => $e->getMessage()]);

            // Chuyển hướng đến trang lỗi với thông báo
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.']);
        }
    }

    // Trang thông báo đặt hàng thành công
    public function orderSuccess()
    {
        return view('user.order-success', [
            'title' => 'Đặt hàng thành công',
        ]);
    }

    // Hàm hủy đơn hàng
    public function cancel($orderId)
    {
        // Lấy thông tin đơn hàng
        $order = Order::find($orderId);

        // Kiểm tra nếu đơn hàng tồn tại
        if (!$order) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }

        // Kiểm tra nếu đơn hàng đã được hoàn thành thì không thể hủy
        if ($order->status === 'completed') {
            return redirect()->back()->with('error', 'Đơn hàng đã hoàn thành, không thể hủy.');
        }

        // Cập nhật trạng thái của đơn hàng thành 'cancelled'
        $order->status = 'cancelled';
        $order->cancellation_date = now(); // Lưu thời gian hủy nếu cần
        $order->save();

        // Trả về thông báo thành công
        return redirect()->route('order.index')->with('success', 'Đơn hàng đã được hủy.');
    }

    public function order_show($id)
    {
        $order = Order::with(['address', 'orderItems.product'])->findOrFail($id); // Lấy đơn hàng theo ID
        return view('user.order_details', [
            'title' => 'Chi tiết đơn hàng',
            'order' => $order,
        ]);
    }
}
