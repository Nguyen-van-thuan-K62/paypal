@extends('User.components.main')
@section('content')
<div class="container mt-5 my-5 pt-5">
    <h2 class="text-center mb-4" style="font-weight: bold;">Giỏ hàng của bạn</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (count($cartItems) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><input type="checkbox" id="select-all"> Chọn tất cả</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Kích cỡ</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Tổng giá</th>
                        <th scope="col">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPrice = 0;
                    @endphp
                    @foreach ($cartItems as $item)
                        @php
                            $itemTotal = $item->price * $item->quantity;
                            $totalPrice += $itemTotal;
                        @endphp
                        <tr data-id="{{ $item->id }}">
                            <td class="text-center">
                                <input type="checkbox" class="item-select" data-price="{{ $itemTotal }}">
                            </td>
                            <td class="text-center">
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid rounded" style="max-width: 80px;">
                            </td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }} VND</td>
                            <td>{{ $item->size }}</td>
                            <td class="text-center">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="updateQuantity({{ $item->id }}, -1)">-</button>
                                        <input type="number" name="quantity" id="quantity-{{ $item->id }}" value="{{ $item->quantity }}" min="1" class="form-control text-center mx-2 " style="width: 60px;" readonly>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="updateQuantity({{ $item->id }}, 1)">+</button>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary mt-2">Sửa</button>
                                </form>
                            </td>
                            <td class="text-center item-quantity" style="display: none;" >{{ $item->quantity }}</td>
                            <td>{{ number_format($itemTotal, 0, ',', '.') }} VND</td>
                            <td class="text-center">
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <form id="cart-form" action="{{ route('checkout.view') }}" method="POST">
            @csrf
            @method('POST')
            <div class="text-end mt-4">
                <h4>Tổng tiền: <span class="text-danger" id="selected-total">0</span> VND</h4>
                <button type="submit" class="btn btn-success btn-lg mt-2">Mua hàng</button>
            </div>
        </form>

    @else
        <div class="alert alert-info text-center" role="alert">
            <strong>Chưa có sản phẩm nào trong giỏ hàng!</strong>
        </div>
    @endif
</div>

<style>
    .table thead th {
        vertical-align: middle;
        text-align: center;
    }
    .table td {
        vertical-align: middle;
    }
    .table img {
        transition: transform 0.3s ease;
    }
    .table img:hover {
        transform: scale(1.1);
    }
</style>

<script>
    //+ - SP
    function updateQuantity(itemId, change) {
        let quantityInput = document.getElementById('quantity-' + itemId);
        let currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity + change >= 1) {
            quantityInput.value = currentQuantity + change;
        }
    }
    
    // Update total price based on selected items
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.item-select:checked').forEach(checkbox => {
            total += parseFloat(checkbox.dataset.price);
        });
        document.getElementById('selected-total').textContent = total.toLocaleString();
    }

    // Handle select all checkbox
    document.getElementById('select-all').addEventListener('change', function() {
        const isChecked = this.checked;
        document.querySelectorAll('.item-select').forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        updateTotal();
    });

    // Update total when selecting individual items
    document.querySelectorAll('.item-select').forEach(checkbox => {
        checkbox.addEventListener('change', updateTotal);
    });

    document.getElementById('cart-form').addEventListener('submit', function(event) {
        // Gather selected item data
        const selectedItems = [];
        document.querySelectorAll('.item-select:checked').forEach(checkbox => {
            const row = checkbox.closest('tr');
            selectedItems.push({
                id: row.dataset.id, // Ensure each row has a data-id attribute with product ID
                quantity: parseInt(row.querySelector('.item-quantity').textContent), // Update selector to match your structure
                size: row.querySelector('td:nth-child(5)').textContent.trim()
            });
        });

        // Create a hidden input to hold selected items
        const selectedInput = document.createElement('input');
        selectedInput.type = 'hidden';
        selectedInput.name = 'selected_items';
        selectedInput.value = JSON.stringify(selectedItems);
        this.appendChild(selectedInput);
    });

</script>

@endsection

