@extends('Client.components.main')
@section('content')
    <!-- Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide mt-5" data-bs-ride="carousel">
        @include('Client.components.carousel')
    </div>
    
    <section class="py-5">
        <div class="container">
            @foreach($groupedMenus as $menuName => $menus)
                <h2 class="mb-4 text-center" style="font-weight: bold; font-size: 2rem;">{{$menuName}}</h2>
                <div class="row">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            @foreach($menus as $menu)
                                <div class="col-sm-6 col-md-4 col-lg-3 p-3" 
                                    data-bs-toggle="popover"
                                    data-bs-trigger="hover"
                                    data-bs-html="true"
                                    data-bs-content='
                                        <h5>{{ $menu->name }}</h5>
                                        <p>{{ $menu->description }}</p>'>
                                    <div class="card zoom-card" style="width: 100%; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease;">
                                        <img class="card-img-top img-thumbnail" src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" style="transition: transform 0.3s ease;">
                                        <div class="card-body text-center">
                                            <h6 class="card-title" style="font-weight: bold;">{{ $menu->description }}</h6>
                                            <h5 class="card-price" style="color: #ff5722;">{{ $menu->price }} VND</h5>
                                            <p>{{ $menu->created_at->format('d/m/Y') }}</p>
                                            <a href="/show/{{$menu->id}}" class="btn btn-success">Xem</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <a href="/product" class="mb-4 text-center text-dark">Xem Thêm</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    
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