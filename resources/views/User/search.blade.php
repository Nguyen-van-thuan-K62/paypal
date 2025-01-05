@extends('user.components.main')

@section('content')
<div class="container mt-5 pt-5 ">
    <h3>Kết quả tìm kiếm cho: "{{$search}}"</h3>

    @if($products->isEmpty())
        <p>Không tìm thấy sản phẩm nào phù hợp.</p>
    @else
        @include('user.components.product_section', ['menus' => $products])
    @endif
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
