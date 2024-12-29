@extends('admin.components.main')
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Chi tiết đơn hàng</h2>

        <!-- Thông tin đơn hàng -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h4>Thông tin đơn hàng : #{{ $order->id }}</h4>
            </div>
            <div class="card-body">
                <p><strong>Mã đơn hàng:</strong> #{{ $order->id }}</p>
                <p><strong>Khách hàng:</strong> {{ $order->address->recipient_name }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->address->address }}, {{ $order->address->city }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->address->phone_number }}</p>
                <p><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VND</p>
                <p><strong>Phương thức thanh toán:</strong>
                    @if($order->payment_method == 'pay_on_pickup')
                        <span class="badge bg-success">Thanh toán khi nhận hàng</span>
                    @elseif($order->payment_method == 'paypal')
                        <span class="badge bg-danger">Thanh toán qua cổng PayPal</span>
                    @else
                        <span class="badge bg-warning">Thanh toán qua cổng VnPay</span>
                    @endif
                </p>
                @if(in_array($order->payment_method, ['paypal', 'VnPay']))
                    <p><strong>Mã giao dịch:</strong> {{ $order->transaction_id }}</p>
                @endif
                <p><strong>Trạng thái:</strong> 
                    @if($order->status == 'pending')
                        <span class="badge bg-secondary">Chờ xử lý</span>
                    @elseif($order->status == 'confirmed')
                        <span class="badge bg-primary">Đã xác nhận</span>
                    @elseif($order->status == 'preparing')
                        <span class="badge bg-info">Đang chuẩn bị</span>
                    @elseif($order->status == 'ready_to_ship')
                        <span class="badge bg-warning">Sẵn sàng giao</span>
                    @elseif($order->status == 'delivered')
                        <span class="badge bg-success">Đã giao hàng</span>
                    @elseif($order->status == 'cancelled')
                        <span class="badge bg-danger">Đã hủy</span>
                    @elseif($order->status == 'returned')
                        <span class="badge bg-dark">Đã trả hàng</span>
                    @endif
                </p>
                <p><strong>Ngày tạo:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                @if($order->status == 'cancelled')
                    <p><strong>Ngày hủy:</strong> {{ $order->cancellation_date}}</p>
                @endif
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h4>Thông tin sản phẩm</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#ID đơn hàng</th>
                            <th>#ID sản phẩmphẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Kích cỡ</th>
                            <th>Giá</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->order_id }}</td>
                                <td>{{ $item->product->id }}</td>
                                <td>{{ $item->product->description}}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->size }}</td>
                                <td>{{ number_format($item->product->price, 0, ',', '.') }} VND</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Nút quay lại -->
        <div class="text-center mt-4">
            <a href="{{ route('admin.order.index')}}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
@endsection
