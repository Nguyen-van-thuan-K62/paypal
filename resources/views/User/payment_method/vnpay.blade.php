@extends('User.components.main')
@section('content')
    <div class="container mt-5">
        <div class="card p-4 shadow-lg text-center">
            <h3 class="mb-4">Thanh toán qua Vnpay</h3>
            <p class="mb-3">Bạn sẽ được chuyển hướng đến cổng thanh toán Vnpay .</p>
            {{-- <a href ="{{ route('paypal.create') }}" class="btn btn-primary w-100">Chuyển đến Vnpay</a> --}}
            <a href="#" class="btn btn-primary w-100" onclick="event.preventDefault(); document.getElementById('post-form').submit();">Chuyển đến Vnpay</a>
            <form id="post-form" action="{{ route('vnpay.payment') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="key" value="value">
            </form>
        </div>
    </div>
@endsection 