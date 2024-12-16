@extends('Client.components.main')
@section('content')
    <!-- Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide mt-5" data-bs-ride="carousel">
        @include('Client.components.carousel')
    </div>
    
    <section class="py-5">
        <div class="container">
            <h3 class="mb-4 text-center">Nike</h3>
            <div class="row">
                <!-- Khóa học 1 -->
                <div class="container-fluid">
                    <div class="row justify-content-center"> <!-- Đảm bảo căn giữa các sản phẩm -->
                        @foreach($menunike as $menu)
                            <div class="col-sm-6 col-md-4 col-lg-3 p-3"
                            data-bs-toggle="popover"
                            data-bs-trigger="hover"
                            data-bs-html="true"
                            data-bs-content='
                                {{-- <img class="card-img-top img-thumbnail" src="{{ asset('storage/' . $menu->image) }}"> --}}
                                <h5>{{ $menu->name }}</h5>
                                <p>{{ $menu->description }}</p>';>
                                <div class="card zoom-card" style="width:100%"> <!-- Đặt width: 100% để card có chiều rộng tương ứng -->
                                    <img class="card-img-top img-thumbnail" src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}"> <!-- Thêm class img-fluid -->
                                    <div class="card-body">
                                        <h6 class="card-title">{{$menu->name}}</h6>
                                        <h5 class="card-title">{{$menu->price}}</h5>
                                        <p>{{$menu->created_at->format('d/m/Y')}}</p>
                                        <a href="/login" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Bạn cần đăng nhập">Thêm vào giỏ hàng</a>
                                        <a href="/login" class="btn btn-primary">Mua</a>     
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>   
                </div>
            </div>
        </div>

        <div class="container">
            <h3 class="mb-4 text-center">Jordan</h3>
            <div class="row">
                <!-- Khóa học 1 -->
                <div class="container-fluid">
                    <div class="row justify-content-center"> <!-- Đảm bảo căn giữa các sản phẩm -->
                        @foreach($menujordan as $menu)
                            <div class="col-sm-6 col-md-4 col-lg-3 p-3"
                            data-bs-toggle="popover"
                            data-bs-trigger="hover"
                            data-bs-html="true"
                            data-bs-content='
                                {{-- <img class="card-img-top img-thumbnail" src="{{ asset('storage/' . $menu->image) }}"> --}}
                                <h5>{{ $menu->name }}</h5>
                                <p>{{ $menu->description }}</p>';>
                                <div class="card zoom-card" style="width:100%"> <!-- Đặt width: 100% để card có chiều rộng tương ứng -->
                                    <img class="card-img-top img-thumbnail" src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}"> <!-- Thêm class img-fluid -->
                                    <div class="card-body">
                                        <h6 class="card-title">{{$menu->name}}</h6>
                                        <h5 class="card-title">{{$menu->price}}</h5>
                                        <p>{{$menu->created_at->format('d/m/Y')}}</p>
                                        <a href="/login" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Bạn cần đăng nhập">Thêm vào giỏ hàng</a>
                                        <a href="/login" class="btn btn-primary">Mua</a>     
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>   
                </div>
            </div>
        </div>

    </section>

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