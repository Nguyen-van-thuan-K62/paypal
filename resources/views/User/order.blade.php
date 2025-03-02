@extends('User.components.main')

@section('content')
<div class="container mt-5 my-5">
    <!-- Tabs -->
    <ul class="nav nav-tabs pt-5" id="orderTabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#all-orders">Tất cả</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#pending">Chờ xử lý <span class="badge bg-danger">{{$orderCountpending}}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#confirmed">Đã xác nhận <span class="badge bg-success">{{$orderCountconfirmed}}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#preparing">Đang chuẩn bị <span class="badge bg-primary">{{$orderCountpreparing}}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#readyToShip">Sẵn sàng giao <span class="badge bg-info">{{$orderCountready_to_ship}}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#delivered">Đã giao <span class="badge bg-success">{{$orderCountdelivered}}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#cancelled">Đã hủy <span class="badge bg-danger">{{$orderCountcancelled}}</span></a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3">
        <!-- All Orders -->
        <div class="tab-pane fade show active" id="all-orders">
            <div class="card mb-5 ">
                @include('user.components.order_section', ['orderItems' => $orderItems])
            </div>
        </div>

        <!-- Pending Payment Orders -->
        <div class="tab-pane fade" id="pending">
            <div class="card">
                @include('user.components.order_section', ['orderItems' => $pendingOrders])
            </div>
        </div>

        <!-- Shipping Orders -->
        <div class="tab-pane fade" id="confirmed">
            <div class="card">
                <div class="card-body">
                    @include('user.components.order_section', ['orderItems' => $confirmedOrders])
                </div>
            </div>
        </div>

        <!-- Awaiting Delivery Orders -->
        <div class="tab-pane fade" id="preparing">
            <div class="card">
                <div class="card-body">
                    @include('user.components.order_section', ['orderItems' => $preparingOrders])
                </div>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="tab-pane fade" id="readyToShip">
            <div class="card">
                <div class="card-body">
                    @include('user.components.order_section', ['orderItems' => $readyToShipOrders])
                </div>
            </div>
        </div>

        <!-- Cancelled Orders -->
        <div class="tab-pane fade" id="delivered">
            <div class="card">
                <div class="card-body">
                    @include('user.components.order_section', ['orderItems' => $deliveredOrders])
                </div>
            </div>
        </div>

        <!-- Return/Refund Orders -->
        <div class="tab-pane fade" id="cancelled">
            <div class="card">
                <div class="card-body">
                    @include('user.components.order_section', ['orderItems' => $cancelledOrders])
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
