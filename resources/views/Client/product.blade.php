@extends('Client.components.main')

@section('content')
<div class="container mt-5">
    <!-- Tabs -->
    <ul class="nav nav-tabs pt-5 justify-content-between" id="orderTabs">
        <li class="nav-item">
            <a class="nav-link active text-dark" data-bs-toggle="tab" href="#all">Danh sách tất cả sản phẩm</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" data-bs-toggle="tab" href="#nike">Nike</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" data-bs-toggle="tab" href="#adidas">Adidas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" data-bs-toggle="tab" href="#mcqueen">Mcqueen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" data-bs-toggle="tab" href="#balenciaga">Balenciaga</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" data-bs-toggle="tab" href="#puma">Puma</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" data-bs-toggle="tab" href="#mlb">MLB</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3">
        <!-- All Orders -->
        <div class="tab-pane fade show active" id="all">
            @include('client.components.product_section', ['menus' => $menus])
        </div>

        <!-- Pending Payment Orders -->
        <div class="tab-pane fade" id="nike">
            @include('client.components.product_section', ['menus' => $menunike])
        </div>

        <!-- Shipping Orders -->
        <div class="tab-pane fade" id="adidas">
            @include('client.components.product_section', ['menus' => $menuadidas])
        </div>

        <!-- Awaiting Delivery Orders -->
        <div class="tab-pane fade" id="mcqueen">
            @include('client.components.product_section', ['menus' => $menuMcqueen])

        </div>

        <!-- Completed Orders -->
        <div class="tab-pane fade" id="balenciaga">
            @include('user.components.product_section', ['menus' => $menuBalenciaga])

        </div>

        <!-- Cancelled Orders -->
        <div class="tab-pane fade" id="puma">
            @include('client.components.product_section', ['menus' => $menuPuma])

        </div>

        <!-- Return/Refund Orders -->
        <div class="tab-pane fade" id="mlb">
            @include('client.components.product_section', ['menus' => $menuMLB])
        </div>
    </div>
</div>
<style>
    /* Hiệu ứng zoom khi hover vào hình ảnh */
    .zoom-card:hover {
        transform: scale(1.05);
    }

    .zoom-card img:hover {
        transform: scale(1.1);
    }

    /* Hiệu ứng cho nút */
    .btn {
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn:hover {
        background-color: #a1918c;
        color: #fff;
    }

    /* Bóng đổ nhẹ cho card */
    .card {
        min-height: 400px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Đảm bảo nội dung được dàn đều */
    }

    /* Màu nền khi hover vào card */
    .card:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
</style>

<script>
    // Khởi tạo popover cho các phần tử
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl, {
            trigger: 'hover', // Hiển thị khi hover
            html: true // Cho phép sử dụng HTML trong nội dung popover
        });
    });
</script>

@endsection
