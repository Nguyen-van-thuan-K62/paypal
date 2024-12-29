@extends('Admin.components.main')
@section('content')
<div class="container mt-4">
    <h2>Thống kê doanh thu</h2>

    <!-- Bộ lọc ngày -->
    <form method="GET" action="" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="start_date">Từ ngày:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label for="end_date">Đến ngày:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Lọc</button>
            </div>
        </div>
    </form>

    <!-- Tổng quan -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Tổng doanh thu</h5>
                    <p class="text-success h4">{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Tổng số đơn hàng</h5>
                    <p class="text-primary h4">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng thống kê -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ngày</th>
                <th>Số đơn hàng</th>
                <th>Doanh thu (VNĐ)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($revenueData as $data)
            <tr>
                <td>{{ $data->date }}</td>
                <td>{{ $data->order_count }}</td>
                <td>{{ number_format($data->revenue, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

