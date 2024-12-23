@extends('User.components.main')
@section('content')
    <div class="container mt-5">
        <div class="card p-4 shadow-lg text-center">
            <h3 class="mb-4">Thanh toán qua PayPal</h3>
            <p class="mb-3">Bạn sẽ được chuyển hướng đến cổng thanh toán PayPal.</p>
            {{-- <a href ="{{ route('paypal.create') }}" class="btn btn-primary w-100">Chuyển đến PayPal</a> --}}
            <a href="#" class="btn btn-primary w-100" onclick="event.preventDefault(); document.getElementById('post-form').submit();">Chuyển đến PayPal</a>
            <form id="post-form" action="{{ route('paypal.payment') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="key" value="value">
            </form>
        </div>
    </div>
@endsection 