@extends('User.components.main')
@section('content')
<div class="container text-center mt-5 my-5 pt-5 py-5">
    <div class="card p-4 shadow-lg text-center py-5">
        <h1 class="text-success">Đặt hàng thành công!</h1>
        <p>Cảm ơn bạn đã mua sắm tại cửa hàng chúng tôi.</p>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">Quay về trang chủ</a>
    </div>
</div>
@endsection
