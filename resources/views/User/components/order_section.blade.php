<div class="card-body">
    <h5>Danh sách đơn hàng</h5>
    @foreach($orderItems as $order)
        <div class="container mt-4">
            <!-- thoong tin san pham -->
            <div class="row mb-4 border pb-3">
                @foreach($order->orderItems as $item)
                    <div class="row align-items-center mb-3">
                        <div class="col-md-2">
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="Product Image" class="img-fluid rounded">
                        </div>
                        <div class="col-md-8">
                            <h5 class="fw-bold">{{ $item->product->name }}</h5>
                            <p class="text-muted">Chi tiết: {{ $item->product->description }}</p>
                            <p>Kích cỡ: <span class="fw-medium">{{ $item->size }}</span></p>
                            <p>Số lượng: <span class="fw-medium">{{ $item->quantity }}</span></p>
                            <p>Giá: <span class="fw-medium text-danger">{{ number_format($item->price, 0, ',', '.') }} VND</span></p>
                            <p>Trạng thái: 
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
                                @endif
                            </p>
                            <p>Phương thức thanh toán:
                                @if($order->payment_method == 'pay_on_pickup')
                                    <span class="badge bg-success">Thanh toán khi nhận hàng</span>
                                @elseif($order->payment_method == 'paypal')
                                    <span class="badge bg-danger">Thanh toán qua cổng PayPal</span>
                                @else
                                    <span class="badge bg-warning">Thanh toán qua cổng VnPay</span>
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <p class="fs-5 fw-bold">Thành tiền: 
                            <span class="text-danger">{{ number_format($order->total_amount, 0, ',', '.') }} VND</span>
                        </p>
                        <a href="/user/order/details/{{$order->id}}" class="btn btn-info btn-sm">Xem chi tiết</a>
                        @if($order->status == 'delivered' || $order->status == 'cancelled')
                            <a href="/user/details/{{$item->product->id}}"><button class="btn btn-warning btn-sm">Mua Lại</button></a>
                        @endif
                        
                        @if($order->status == 'pending')
                           <button id="cancelOrderBtn_{{ $order->id }}" class="btn btn-danger btn-sm cancel-order-btn">Hủy đơn hàng</button>
                        @endif
                    </div>
                    <form id="cancelOrderForm_{{ $order->id }}" action="/user/order/{{$order->id}}/cancel" method="POST" style="display: none;">
                        @csrf
                    </form>                    
                </div>
            </div>
        </div>
    @endforeach
</div>
<script>
    document.querySelectorAll('.cancel-order-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const orderId = this.id.split('_')[1]; // Lấy ID từ nút
            document.getElementById(`cancelOrderForm_${orderId}`).submit();
        });
    });
</script>

