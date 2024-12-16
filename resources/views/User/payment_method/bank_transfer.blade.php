@extends('User.components.main')
@section('content')
    <div class="container mt-5">
        <div class="card p-4 shadow-lg">
            <h3 class="mb-4 text-center">Chuyển khoản ngân hàng</h3>
            <p class="mb-3">Vui lòng chuyển khoản đến tài khoản ngân hàng dưới đây:</p>
            <ul class="list-group mb-3">
                <li class="list-group-item">Ngân hàng: <strong>Ngân hàng ACB</strong></li>
                <li class="list-group-item">Chủ tài khoản: <strong>Nguyễn Văn A</strong></li>
                <li class="list-group-item">Số tài khoản: <strong>123456789</strong></li>
            </ul>
            <p class="mb-3">Hoặc quét mã QR bên dưới để thực hiện thanh toán nhanh:</p>
            <div class="text-center">
                <img src="qr-code-placeholder.png" alt="QR Code" class="img-fluid" style="max-width: 200px;">
            </div>
            <a href="/" class="btn btn-primary mt-3 w-100">Quay lại Trang chủ</a>
        </div>
    </div>  
@endsection 