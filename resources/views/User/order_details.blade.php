@extends('User.components.main')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Chi Tiết Đơn Hàng #{{$order->id}}</h2>
            <!-- Thông tin đơn hàng -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Thông Tin Đơn Hàng</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Mã Đơn Hàng:</strong> #{{$order->id}}</li>
                        <li class="list-group-item"><strong>Ngày Đặt Hàng:</strong> {{$order->created_at->format('d/m/Y') }}</li>
                        <li class="list-group-item"><strong>Trạng Thái Đơn Hàng:</strong>
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
                        </li>
                        @if($order->status == 'cancelled')
                            <li class="list-group-item"><strong>Ngày hủy đơn hàng:</strong> {{$order->cancellation_date}}</li>
                        @endif
                        <li class="list-group-item"><strong>Phương Thức Thanh Toán:</strong>
                            @if($order->payment_method == 'pay_on_pickup')
                                <span class="badge bg-success">Thanh toán khi nhận hàng</span>
                            @elseif($order->payment_method == 'paypal')
                                <span class="badge bg-danger">Thanh toán qua cổng PayPal</span>
                            @else
                                <span class="badge bg-warning">Thanh toán qua cổng VnPay</span>
                            @endif  
                        </li>
                        @if(in_array($order->payment_method, ['paypal', 'VnPay']))
                            <li class="list-group-item"><strong>Mã giao dịch :</strong> {{$order->transaction_id}}</li>
                        @endif

                    </ul>
                </div>
            </div>

            <!-- Thông tin khách hàng -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Thông Tin Khách Hàng</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Tên Khách Hàng:</strong>{{ $order->address->recipient_name }}</li>
                        <li class="list-group-item"><strong>Địa Chỉ Giao Hàng:</strong>{{ $order->address->address }}, {{ $order->address->city }}</li>
                        <li class="list-group-item"><strong>Số Điện Thoại:</strong>{{ $order->address->phone_number }}</li>
                    </ul>
                </div>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Danh Sách Sản Phẩm</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tên Sản Phẩm</th>
                                <th>Số Lượng</th>
                                <th>Kích cỡ</th>
                                <th>Giá</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                @php
                                $itemTotal = $item->price * $item->quantity;
                                @endphp
                                <tr>
                                    <td>{{ $item->product->description}}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->size }}</td>
                                    <td>{{ number_format($item->price, 0, ',', '.') }} VND</td>
                                    <td>{{ number_format($itemTotal, 0, ',', '.') }} VND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tổng kết đơn hàng -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Tổng Kết Đơn Hàng</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        {{-- <li class="list-group-item"><strong>Tổng Tiền Sản Phẩm:</strong>{{ number_format($$totalPrice, 0, ',', '.') }} VND</li> --}}
                        <li class="list-group-item"><strong>Chi Phí Vận Chuyển:</strong> 30,000 VND</li>
                        <li class="list-group-item"><strong>Tổng Thanh Toán:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VND</li>
                    </ul>
                </div>
            </div>

            <!-- Nút quay lại -->
            <div class="mt-4">
                <a href="javascript:history.back()" class="btn btn-secondary">Quay Lại</a>
            </div>
        </div>
    </div>
</div>

<!-- Liên kết với Bootstrap JS và Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
@endsection
