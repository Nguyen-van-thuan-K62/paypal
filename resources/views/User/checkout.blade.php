@extends('User.components.main')
@section('content')
<div class="container checkout-container mt-5 pt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Shipping Address -->
    <div class="shipping-address card p-3 mb-3 pt-5">
        <div class="d-flex justify-content-between align-items-center">
            <div class="address-container">
                <p class="section-header">Địa chỉ nhận hàng của bạn</p>
                @if($addressItemsfirst)
                    <div class=" main-address-info">
                        <p>Tên:<strong class="recipient-name">{{$addressItemsfirst->recipient_name}}</strong></p>
                        <p>Số điện thoại:<strong class="phone-number">(+84){{$addressItemsfirst->phone_number}}</strong></p>
                        <p>Địa chỉ:<strong class="address">{{$addressItemsfirst->address}},{{$addressItemsfirst->city}}</strong></p>
                    </div>
                @else
                    {{-- <div class="alert alert-info text-center" role="alert">
                        <strong>Chưa có địa chỉ nào !</strong>
                    </div> --}}
                    <strong>Chưa có địa chỉ nào !</strong>
                @endif
            </div>
            <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addressModal">Thêm</button>
        </div>

        <!-- Modal for Changing Address -->
        <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addressModalLabel">Địa Chỉ Của Tôi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Address List -->
                        <form id="addressForm">
                            @foreach($addressItems as $item)
                                <div class="mb-3 address-info" id="address-info-{{ $item->id }}">
                                    <label class="d-flex justify-content-between align-items-center">
                                        <input type="radio" name="address"  value="{{ $item->id }}" {{ $item->is_default ? 'checked' : '' }}>
                                        <div class="ms-2">
                                            <p class="recipient-name">{{ $item->recipient_name }}</p>
                                            <p class="phone-number"> {{ $item->phone_number }}</p>
                                            <p class="address">{{ $item->address }}</p>
                                            <p class="city">{{ $item->city }}</p>
                                        </div>
                                        <div>
                                            <span class="text-primary me-3">
                                                {{ $item->is_default ? 'Mặc định' : '' }}
                                            </span>
                                            <button type="button" class="btn btn-link" onclick="openEditModal({{ $item->id }})">Cập nhật</button>
                                        </div>
                                    </label>
                                </div>
                            @endforeach

                            <!-- Add New Address -->
                            <div class="mb-3">
                                <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#newAddressModal">+ Thêm Địa Chỉ Mới</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary">Xác nhận</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Adding New Address -->
        <div class="modal fade" id="newAddressModal" tabindex="-1" aria-labelledby="newAddressModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newAddressModalLabel">Thêm Địa Chỉ Mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="newAddressForm" method="POST" action="{{ route('save-address') }}">
                            @csrf <!-- Token bảo mật trong Laravel -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên người nhận</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên của bạn" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ giao hàng" required>
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">Thành phố</label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="Nhập thành phố" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Lưu Địa Chỉ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Editing Address -->
        <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAddressModalLabel">Sửa Địa Chỉ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editAddressForm" method="POST" action="{{ route('update-address') }}">
                            @csrf
                            <input type="hidden" name="addressId" id="editAddressId">
                            <div class="mb-3">
                                <label for="editName" class="form-label">Tên người nhận</label>
                                <input type="text" class="form-control" id="editName" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="editPhone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="editPhone" name="phone">
                            </div>
                            <div class="mb-3">
                                <label for="editAddress" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="editAddress" name="address">
                            </div>
                            <div class="mb-3">
                                <label for="editCity" class="form-label">Thành phố</label>
                                <input type="text" class="form-control" id="editCity" name="city">
                            </div>
                            {{-- <button type="submit" class="btn btn-primary w-100">Lưu Thay Đổi</button> --}}
                        </form>                            
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" form="editAddressForm">Lưu thay đổi</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product List -->
        <div class="product-list card p-3 mb-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPrice = 0;
                    @endphp
                    @foreach($orderItems as $item)
                        @php
                            $itemTotal = $item->price * $item->quantity;
                            $totalPrice += $itemTotal;
                        @endphp
                        <tr data-product-id="{{$item->product->id }}">
                            <td>
                                <div class="d-flex">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="product-img me-3">
                                    <div>
                                        <p>{{ $item->product->name }}</p>
                                        <p>{{ $item->product->description}}</p>
                                        <p class="size">size: {{ $item->size }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($itemTotal, 0, ',', '.') }} VND</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Payment Method -->
        <div class="payment-method card p-3 mb-3">
            <p class="section-header">Phương Thức Thanh Toán</p>
            <form id="paymentForm">
                <div class="mb-3">
                    <label for="paymentMethod" class="form-label">Chọn phương thức thanh toán</label>
                    <select class="form-select" id="paymentMethod" name="payment_method" required>
                        <option value="pay_on_pickup">Thanh toán khi nhận hàng</option>
                        <option value="paypal">PayPal</option>
                        <option value="vnpay">Vnpay</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="order-summary card p-3">
            <div class="d-flex justify-content-between">
                <p>Tổng tiền hàng</p>
                <p>{{ number_format($totalPrice, 0, ',', '.') }}VND</p>
            </div>
                <p>Phí vận chuyển</p>
            <div class="d-flex justify-content-between">
                <p>30.000 VND</p>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <p class="total-amount">Tổng thanh toán</p>
                <p class="total-amount">{{ number_format($totalPrice + 30000, 0, ',', '.')}}VND</p>
            </div>
            <button class="btn btn-danger w-100 mt-3" onclick="submitOrder()">Đặt hàng</button>
        </div>
        {{-- form ẩn để gửi dữ liệu --}}
        <form id="orderForm" action="{{ route('order.place') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="address_id" id="orderAddressId">
            <input type="hidden" name="payment_method" id="orderPaymentMethod">
            <input type="hidden" name="total_price" id="orderTotalPrice">
            <input type="hidden" name="order_items" id="orderItems">
        </form>        
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>

    function openEditModal(addressId) {
        var editAddressModal = new bootstrap.Modal(document.getElementById('editAddressModal'));
        if (!editAddressModal._isShown) {  // Kiểm tra nếu modal chưa được mở
            // Lấy thông tin địa chỉ
            let addressInfo = document.getElementById(`address-info-${addressId}`);
            let recipientName = document.querySelector(`#address-info-${addressId} .recipient-name`).innerText;
            let phoneNumber = document.querySelector(`#address-info-${addressId} .phone-number`).innerText;
            let address = document.querySelector(`#address-info-${addressId} .address`).innerText;
            let city = document.querySelector(`#address-info-${addressId} .city`).innerText;

            // Đặt giá trị vào form
            document.getElementById('editName').value = recipientName;
            document.getElementById('editPhone').value = phoneNumber;
            document.getElementById('editAddress').value = address;
            document.getElementById('editCity').value = city;
            document.getElementById('editAddressId').value = addressId;

            // Mở modal
            editAddressModal.show();
        }
    }
    
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('focusin', function(event) {
            event.stopPropagation();
        });
    });

    document.getElementById('addressModal').addEventListener('hidden.bs.modal', function () {
        document.querySelectorAll('.modal-backdrop').forEach((el) => el.remove());
        document.body.style.overflow = ''; // Đảm bảo cho phép cuộn
    });

    document.querySelector('#addressModal .btn-primary').addEventListener('click', function () {
        // Lấy địa chỉ được chọn
        const selectedAddress = document.querySelector('input[name="address"]:checked'); // Radio được chọn
        if (selectedAddress) {
            const addressInfo = selectedAddress.closest('.address-info'); // Lấy container thông tin địa chỉ
            const recipientName = addressInfo.querySelector('.recipient-name').innerText;
            const phoneNumber = addressInfo.querySelector('.phone-number').innerText;
            const address = addressInfo.querySelector('.address').innerText;
            const city = addressInfo.querySelector('.city').innerText;

            // Gán thông tin này ra màn chính
            document.querySelector('.main-address-info .recipient-name').innerText = ` ${recipientName}`;
            document.querySelector('.main-address-info .phone-number').innerText = ` ${phoneNumber}`;
            document.querySelector('.main-address-info .address').innerText = ` ${address}, ${city}`;

            const modal = bootstrap.Modal.getInstance(document.getElementById('addressModal'));
            if (modal) {
                modal.hide();
            }

        }
    });

    function submitOrder() {
        // Lấy thông tin địa chỉ người nhận
        const addressId = document.querySelector('input[name="address"]:checked')?.value;
        
        // Lấy danh sách sản phẩm trong giỏ hàng
        const orderItems = [];
        document.querySelectorAll('.product-list tbody tr').forEach(row => {
            const productName = row.querySelector('.product-img').alt;
            const quantity = parseInt(row.querySelector('td:nth-child(3)').innerText);
            const sizeText = row.querySelector('.size').innerText;
            const sizeValue = sizeText.replace('size: ', '').trim(); 
            const price = parseFloat(row.querySelector('td:nth-child(2)').innerText.replace(/[^0-9.-]+/g, "")); // Loại bỏ ký tự VND
            const productId = row.getAttribute('data-product-id'); // Đặt data-product-id vào mỗi hàng trong backend.

            orderItems.push({ product_id: productId, quantity,sizeValue, price });
        });

        // Lấy phương thức thanh toán
        const paymentMethod = document.getElementById('paymentMethod').value;

        // Tổng thanh toán
        const totalPrice = {{ $totalPrice + 30000 }}; // Thêm phí vận chuyển.

        // Đặt giá trị vào các trường của form
        document.getElementById('orderAddressId').value = addressId;
        document.getElementById('orderPaymentMethod').value = paymentMethod;
        document.getElementById('orderTotalPrice').value = totalPrice;

        // Chuyển đổi order_items thành chuỗi JSON
        document.getElementById('orderItems').value = JSON.stringify(orderItems);

        // Gửi form
        document.getElementById('orderForm').submit();
    }

        // Lắng nghe sự kiện thay đổi trên select
    document.getElementById('paymentMethod').addEventListener('change', function () {
        const selectedMethod = this.value; // Lấy giá trị được chọn
        let targetURL = ''; // URL cần điều hướng

        // Xác định URL dựa trên phương thức thanh toán
        switch (selectedMethod) {
            case 'pay_on_pickup':
                targetURL = ''; // Trang xác nhận thanh toán khi nhận hàng
                break;
            case 'credit_card':
                targetURL = '/user/payment_method/credit_card'; // Trang nhập thông tin thẻ tín dụng
                break;
            case 'paypal':
                targetURL = '/user/payment_method/paypal'; // Trang cổng thanh toán PayPal
                //targetURL = '/user/payment_method/paypal/create-payment';
                break;
            case 'vnpay':
                targetURL = '/user/payment_method/vnpay'; // Trang cong thanh toan vnpay
                break;
            default:
                alert('Vui lòng chọn phương thức thanh toán hợp lệ!');
                return; // Không làm gì nếu không có giá trị hợp lệ
        }

        // Điều hướng đến trang được chọn
        if (targetURL) {
            window.location.href = targetURL;
        }
    });

</script>
{{-- css --}}
<style>
    .product-img {
        width: 100px;
        height: 50px;
        object-fit: cover;
    }
</style>

@endsection 
