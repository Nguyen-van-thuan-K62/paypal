@extends('Client.components.main')
@section('content')

<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Product Detail Card -->
    <div class="card mb-5 shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="row g-0">
            <div class="col-md-5 text-center bg-light d-flex justify-content-center align-items-center p-4">
                <img src="{{ asset('storage/' . $products->image) }}" alt="{{ $products->name }}" class="img-fluid shadow-sm rounded" style="max-height: 450px; object-fit: cover; width: 100%; border-radius: 10px;">
            </div>

            <div class="col-md-7 d-flex align-items-center">
                <div class="card-body p-4">
                    <h1 class="card-title mb-4 fw-bold">{{ $products->name }}</h1>

                    <p class="card-text fs-5 mb-3"><strong>Tên sản Phẩm:</strong> {{ $products->description }}</p>
                    <p class="card-text text-success fs-3 mb-3"><strong>Giá:</strong> {{ number_format($products->price) }} VND</p>
                    <p class="card-text text-muted mb-4"><strong>Còn:</strong> {{ $products->stock }}</p>

                    <!-- Select Size -->
                    <div class="mb-4">
                        <label for="size" class="form-label fs-5"><strong>Kích cỡ:</strong></label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach([38, 39, 40, 41, 42] as $size)
                                <button type="button" class="btn btn-outline-primary rounded-pill size-option" data-size="{{ $size }}">{{ $size }}</button>
                            @endforeach
                        </div>
                        <input type="hidden" id="selectedSize" name="size" value="">
                    </div>

                    <!-- Select Quantity -->
                    <div class="mb-4">
                        <label for="quantity" class="form-label fs-5"><strong>Số lượng:</strong></label>
                        <div class="input-group" style="max-width: 150px;">
                            <button class="btn btn-outline-secondary" type="button" id="decrease-quantity">-</button>
                            <input type="number" class="form-control text-center" id="quantity" value="1" min="1" max="{{ $products->stock }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" id="increase-quantity">+</button>
                        </div>
                    </div>

                    <!-- Add to Cart and Buy Now Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-4">
                        @guest
                            <button class="btn btn-primary btn-lg me-md-2 px-4 rounded-pill" onclick="showLoginAlert()">Thêm vào giỏ hàng</button>
                            <button class="btn btn-success btn-lg px-4 rounded-pill" onclick="showLoginAlert()">Mua ngay</button>
                        @else
                            <button class="btn btn-primary btn-lg me-md-2 px-4 rounded-pill">Thêm vào giỏ hàng</button>
                            <button class="btn btn-success btn-lg px-4 rounded-pill">Mua ngay</button>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Product Detail Card -->

    <!-- Comments Section -->
    <div class="card mb-4 shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <h5 class="card-title mb-4">Đánh giá sản phẩm</h5>

            <!-- Existing Comments -->
            <div class="mb-4">
                @foreach($products->comments as $comment)
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <img src="https://via.placeholder.com/50" alt="User Avatar" class="rounded-circle">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ $comment->user->name }}</h6>
                            <p class="mb-0">{{ $comment->content }}</p>
                            <small class="text-muted">Đăng vào {{ $comment->created_at->format('Y-m-d H:i:s') }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
            <a href="/login"> <p>Bạn cần đăng nhập để để lại đánh giá.</p></a>
        </div>
    </div>
    <!-- End Comments Section -->
</div>

<script>
    document.querySelectorAll('.size-option').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.size-option').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('selectedSize').value = this.getAttribute('data-size');
        });
    });

    function showLoginAlert() {
        alert('Bạn cần đăng nhập để thực hiện chức năng này.');
    }

    const decreaseQuantity = document.getElementById('decrease-quantity');
    const increaseQuantity = document.getElementById('increase-quantity');
    const quantityInput = document.getElementById('quantity');

    decreaseQuantity.addEventListener('click', function() {
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    increaseQuantity.addEventListener('click', function() {
        const currentValue = parseInt(quantityInput.value);
        const maxValue = parseInt(quantityInput.getAttribute('max'));
        if (currentValue < maxValue) {
            quantityInput.value = currentValue + 1;
        }
    });
</script>

@endsection
