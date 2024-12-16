@extends('User.components.main')
@section('content')
    <div class="container mt-5">
        <div class="card p-4 shadow-lg">
            <h3 class="mb-4 text-center">Thanh toán bằng Thẻ tín dụng</h3>
            <form>
                <div class="mb-3">
                    <label for="cardNumber" class="form-label">Số thẻ</label>
                    <input type="text" class="form-control" id="cardNumber" placeholder="Nhập số thẻ" required>
                </div>
                <div class="mb-3">
                    <label for="cardName" class="form-label">Tên trên thẻ</label>
                    <input type="text" class="form-control" id="cardName" placeholder="Nhập tên trên thẻ" required>
                </div>
                <div class="mb-3">
                    <label for="expiryDate" class="form-label">Ngày hết hạn</label>
                    <input type="month" class="form-control" id="expiryDate" required>
                </div>
                <div class="mb-3">
                    <label for="cvv" class="form-label">CVV</label>
                    <input type="password" class="form-control" id="cvv" placeholder="Nhập CVV" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Thanh Toán</button>
            </form>
        </div>
    </div>
@endsection 