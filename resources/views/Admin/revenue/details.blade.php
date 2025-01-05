@extends('Admin.components.main')
@section('content')
<div class="container mt-4">
    <h2>Danh sách đơn hàng</h2>
    
    <!-- Bảng danh sách đơn hàng -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#ID</th>
                <th>#ID_user</th>
                <th>Doanh thu (VNĐ)</th>
                <th>Ngày đặt</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user_id }}</td>
                <td>{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                <td>{{ $order->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
