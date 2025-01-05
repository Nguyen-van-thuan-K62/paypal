@extends('User.components.main')
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
            <form action="{{ route('cart.add', $products->id) }}" method="POST" class="d-flex flex-wrap">
                @csrf
                <!-- Product Image -->
                <div class="col-md-5 text-center bg-light d-flex justify-content-center align-items-center p-4">
                    <img src="{{ asset('storage/' . $products->image) }}" alt="{{ $products->name }}" class="img-fluid shadow-sm rounded" style="max-height: 450px; object-fit: cover; width: 100%; border-radius: 10px;">
                </div>
    
                <!-- Product Details -->
                <div class="col-md-7 d-flex align-items-center">
                    <div class="card-body p-4">
                        <!-- Product Name -->
                        <h1 class="card-title mb-4 fw-bold">{{ $products->name }}</h1>
    
                        <!-- Description -->
                        <p class="card-text fs-5 mb-3">
                            <strong>Tên sản Phẩm:</strong> {{ $products->description }}
                        </p>
    
                        <!-- Price -->
                        <p class="card-text text-success fs-3 mb-3">
                            <strong>Giá:</strong>{{ number_format($products->price)}} VND
                        </p>
    
                        <!-- Stock -->
                        <p class="card-text text-muted mb-4">
                            <strong>Còn:</strong> {{ $products->stock }}
                        </p>

                        <!-- Stock -->
                        <p class="card-text text-muted mb-4">
                            <strong>Đã bán:</strong> {{ $products->sold_quantity }}
                        </p>
                        
    
                        <!-- Select Size -->
                        <div class="mb-4">
                            <label for="size" class="form-label fs-5"><strong>Kích cỡ:</strong></label>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-outline-primary rounded-pill size-option" data-size="38">38</button>
                                <button type="button" class="btn btn-outline-primary rounded-pill size-option" data-size="39">39</button>
                                <button type="button" class="btn btn-outline-primary rounded-pill size-option" data-size="40">40</button>
                                <button type="button" class="btn btn-outline-primary rounded-pill size-option" data-size="41">41</button>
                                <button type="button" class="btn btn-outline-primary rounded-pill size-option" data-size="42">42</button>
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
                            <button class="btn btn-primary btn-lg me-md-2 px-4 rounded-pill">Thêm vào giỏ hàng</button>
                            {{-- <button class="btn btn-success btn-lg px-4 rounded-pill">Mua ngay</button> --}}
                            <button type="submit" formaction="{{ route('cart.buyNow', $products->id) }}" class="btn btn-success btn-lg px-4 rounded-pill">Mua ngay</button>
                        </div>
                    </div>
                </div>
            </form>
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
    
            <!-- Add New Comment -->
            @auth
            <form action="{{ route('comment.store', $products->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="comment" class="form-label">Để lại một đánh giá</label>
                    <textarea class="form-control" id="comment" name="content" rows="3" placeholder="Viết đánh giá của bạn ở đây..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
            @else
                <p>Please <a href="{{ route('login') }}">login</a> to leave a comment.</p>
            @endauth
        </div>
    </div>
    <!-- End Comments Section -->
</div>

<script>
    // Handle size selection
    document.querySelectorAll('.size-option').forEach(button => {
    button.addEventListener('click', function() {
        document.querySelectorAll('.size-option').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('selectedSize').value = this.getAttribute('data-size');
        });
    });


    // Handle quantity increase and decrease
    const decreaseQuantity = document.getElementById('decrease-quantity');
    const increaseQuantity = document.getElementById('increase-quantity');
    const quantityInput = document.getElementById('quantity');

    decreaseQuantity.addEventListener('click', function() {
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    increaseQuantity.addEventListener('click', function() {
        let currentValue = parseInt(quantityInput.value);
        let maxValue = parseInt(quantityInput.getAttribute('max'));
        if (currentValue < maxValue) {
            quantityInput.value = currentValue + 1;
        }
    });
</script>

@endsection 