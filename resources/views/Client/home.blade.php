@extends('Client.components.main')
@section('content')
    <!-- Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide mt-5" data-bs-ride="carousel">
        @include('Client.components.carousel')
    </div>

    <!-- Section danh sách menu -->
    <section class="py-5">
        <div class="container">
            @foreach($groupedMenus as $menuName => $menus)
                <!-- Tên menu -->
                <h2 class="mb-5 text-center" style="font-weight: bold; font-size: 2.5rem; color: #333;">
                    {{ $menuName }}
                </h2>

                <!-- Bố cục sản phẩm -->
                <div class="row justify-content-center g-4">
                    @foreach($menus as $menu)
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card zoom-card h-100 shadow-sm" 
                                data-bs-toggle="popover"
                                data-bs-trigger="hover"
                                data-bs-html="true"
                                data-bs-content='
                                    <h5>{{ $menu->name }}</h5>
                                    <p>{{ $menu->description }}</p>'>
                                <!-- Ảnh sản phẩm -->
                                <img class="card-img-top img-thumbnail" src="{{ asset('storage/' . $menu->image) }}" 
                                     alt="{{ $menu->name }}" 
                                     style="height: 200px; object-fit: cover;">
                                
                                <!-- Nội dung sản phẩm -->
                                <div class="card-body text-center">
                                    <h5 class="card-title" style="font-weight: bold; font-size: 1.2rem;">
                                        {{ $menu->name }}
                                    </h5>
                                    <p class="card-text text-muted" style="font-size: 0.9rem;">
                                        {{ Str::limit($menu->description, 50) }}
                                    </p>
                                    <h5 class="card-price" style="color: #ff5722; font-size: 1.3rem;">
                                        {{ number_format($menu->price, 0, ',', '.') }} VND
                                    </h5>
                                    <small class="text-muted">{{ $menu->created_at->format('d/m/Y') }}</small>
                                    <div class="mt-3">
                                        <a href="/user/details/{{ $menu->id }}" class="btn btn-success btn-sm">
                                            Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Nút Xem Thêm -->
                <div class="text-center mt-5">
                    <a href="/user/product" class="btn btn-outline-dark btn-lg">
                        Xem Thêm
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <script>
        // Khởi tạo popover cho các phần tử
        document.addEventListener("DOMContentLoaded", function () {
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl, {
                    trigger: 'hover',
                    html: true
                });
            });
        });
    </script>
@endsection
