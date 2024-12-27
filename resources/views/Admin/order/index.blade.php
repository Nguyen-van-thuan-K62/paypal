@extends('admin.components.main')
@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Quản lý đơn hàng</h2>

    <!-- Tabs Menu -->
    <ul class="nav nav-tabs" id="orderTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">Chờ xử lý</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#confirmed" type="button" role="tab" aria-controls="confirmed" aria-selected="false">Đã xác nhận</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="preparing-tab" data-bs-toggle="tab" data-bs-target="#preparing" type="button" role="tab" aria-controls="preparing" aria-selected="false">Đang chuẩn bị</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="ready_to_ship-tab" data-bs-toggle="tab" data-bs-target="#ready_to_ship" type="button" role="tab" aria-controls="ready_to_ship" aria-selected="false">Sẵn sàng giao</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="delivered-tab" data-bs-toggle="tab" data-bs-target="#delivered" type="button" role="tab" aria-controls="delivered" aria-selected="false">Đã giao</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab" aria-controls="cancelled" aria-selected="false">Đã hủy</button>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content" id="orderTabsContent">
        <!-- Tab: Chờ xử lý -->
        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
            @include('admin.order.partial_order_table', ['orders' => $pendingOrders])
        </div>
        
        <!-- Tab: Đã xác nhận -->
        <div class="tab-pane fade" id="confirmed" role="tabpanel" aria-labelledby="confirmed-tab">
            @include('admin.order.partial_order_table', ['orders' => $confirmedOrders])
        </div>

        <!-- Tab: Đang chuẩn bị -->
        <div class="tab-pane fade" id="preparing" role="tabpanel" aria-labelledby="preparing-tab">
            @include('admin.order.partial_order_table', ['orders' => $preparingOrders])
        </div>

        <!-- Tab: Sẵn sàng giao -->
        <div class="tab-pane fade" id="ready_to_ship" role="tabpanel" aria-labelledby="ready_to_ship-tab">
            @include('admin.order.partial_order_table', ['orders' => $readyToShipOrders])
        </div>

        <!-- Tab: Đã giao -->
        <div class="tab-pane fade" id="delivered" role="tabpanel" aria-labelledby="delivered-tab">
            @include('admin.order.partial_order_table', ['orders' => $deliveredOrders])
        </div>

        <!-- Tab: Đã hủy -->
        <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
            @include('admin.order.partial_order_table', ['orders' => $cancelledOrders])
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
