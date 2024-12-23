@extends('User.components.main')

@section('content')
<div class="container mt-5">
    <!-- Tabs -->
    <ul class="nav nav-tabs pt-5" id="orderTabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#all-orders">Tất cả</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#pending-payment">Chờ thanh toán</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#shipping">Vận chuyển</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#awaiting-delivery">Chờ giao hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#completed">Hoàn thành</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#cancelled">Đã hủy</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#return-refund">Trả hàng/Hoàn tiền</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3">
        <!-- All Orders -->
        <div class="tab-pane fade show active" id="all-orders">
            <div class="card mb-5 ">
                <div class="card-body">
                    <h5>Danh sách tất cả đơn hàng</h5>
                    @foreach($orderItems as $order)
                        <div class="container mt-4">
                            <!-- thoong tin san pham -->
                            @foreach($order->orderItems as $item)
                                <div class="row mb-3 border pb-3 ">
                                    <div class="col-md-2">
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="Product Image" class="img-fluid">
                                    </div>
                                    <div class="col-md-8">
                                        <h5>{{ $item->product->name }}</h5>
                                        <p>Chi tiết: {{ $item->product->description}}</p>
                                        <p>Kích cỡ: <span>trắng</span></p>
                                        <p>Số lượng: {{ $item->quantity }}</p>
                                        <p>Giá: {{ number_format($item->price, 0, ',', '.') }} VND</p>
                                        <p>Trạng thái: {{ $order->status }}</p>
                                    </div>
                                    @if($order->status == 'pending')
                                    <div class="col-md-6">
                                        <form action="/user/order/{{$order->id}}/cancel" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Hủy đơn hàng</button>
                                        </form>
                                    </div>
                                    
                                    @endif

                                    
                                    <div class="col-md-6">
                                        <button class="btn btn-danger">Mua Lại</button>
                                    </div>

                                    <div class="col-md-6">
                                        <p class="fs-5 fw-bold">Thành tiền: {{ number_format($order->total_amount, 0, ',', '.') }} VND</p>
                                    </div>
    
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Pending Payment Orders -->
        <div class="tab-pane fade" id="pending-payment">
            <div class="card">
                <div class="card-body">
                    <h5>Chờ thanh toán</h5>
                    <!-- Nội dung đơn hàng chờ thanh toán -->
                </div>
            </div>
        </div>

        <!-- Shipping Orders -->
        <div class="tab-pane fade" id="shipping">
            <div class="card">
                <div class="card-body">
                    <h5>Đơn hàng đang vận chuyển</h5>
                    <!-- Nội dung đơn hàng đang vận chuyển -->
                </div>
            </div>
        </div>

        <!-- Awaiting Delivery Orders -->
        <div class="tab-pane fade" id="awaiting-delivery">
            <div class="card">
                <div class="card-body">
                    <h5>Chờ giao hàng</h5>
                    <!-- Nội dung đơn hàng chờ giao hàng -->
                </div>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="tab-pane fade" id="completed">
            <div class="card">
                <div class="card-body">
                    <h5>Đơn hàng đã hoàn thành</h5>
                    <!-- Nội dung đơn hàng hoàn thành -->
                </div>
            </div>
        </div>

        <!-- Cancelled Orders -->
        <div class="tab-pane fade" id="cancelled">
            <div class="card">
                <div class="card-body">
                    <h5>Đơn hàng đã hủy</h5>
                    <!-- Nội dung đơn hàng đã hủy -->
                    @foreach($orderItems as $order)
                        @if($order->status == 'cancelled')
                            <div class="container mt-4">
                                <!-- thoong tin san pham -->
                                @foreach($order->orderItems as $item)
                                    <div class="row mb-3 border pb-3 ">
                                        <div class="col-md-2">
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="Product Image" class="img-fluid">
                                        </div>
                                        <div class="col-md-8">
                                            <h5>{{ $item->product->name }}</h5>
                                            <p>Chi tiết: {{ $item->product->description}}</p>
                                            <p>Kích cỡ: <span>trắng</span></p>
                                            <p>Số lượng: {{ $item->quantity }}</p>
                                            <p>Giá: {{ number_format($item->price, 0, ',', '.') }} VND</p>
                                            <p>Trạng thái: {{ $order->status }}</p>
                                        </div>
                                        @if($order->status == 'pending')
                                        <div class="col-md-6">
                                            <form action="/user/order/{{$order->id}}/cancel" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Hủy đơn hàng</button>
                                            </form>
                                        </div>
                                        
                                        @endif

                                        
                                        <div class="col-md-6">
                                            <button class="btn btn-danger">Mua Lại</button>
                                        </div>

                                        <div class="col-md-6">
                                            <p class="fs-5 fw-bold">Thành tiền: {{ number_format($order->total_amount, 0, ',', '.') }} VND</p>
                                        </div>
        
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Return/Refund Orders -->
        <div class="tab-pane fade" id="return-refund">
            <div class="card">
                <div class="card-body">
                    <h5>Đơn hàng trả hàng/hoàn tiền</h5>
                    <!-- Nội dung đơn hàng trả hàng/hoàn tiền -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
