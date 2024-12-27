@extends('admin.components.main')
@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Chi tiết sản phẩm</h2>
    
    <!-- Thông tin sản phẩm -->
    <div class="card mb-4">
        <div class="card-body">
            <h3 class="card-title">{{ $product->name }}</h3>
            <p class="card-text">Mô tả: {{ $product->description }}</p>
            <p class="card-text">Giá: <span class="text-danger">{{ number_format($product->price, 0, ',', '.') }} VND</span></p>
            <p class="card-text">Tồn kho: {{ $product->stock }}</p>
            @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-fluid rounded mt-3" style="max-width: 300px;">
            @endif
        </div>
    </div>

    <!-- Lịch sử thay đổi sản phẩm -->
    <h3 class="mb-3">Lịch sử thay đổi</h3>
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Trường thay đổi</th>
                <th>Giá trị cũ</th>
                <th>Giá trị mới</th>
                <th>Người thay đổi</th>
                <th>Thời gian thay đổi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productChanges as $change)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $change->field_changed }}</td>
                <td>{{ $change->old_value }}</td>
                <td>{{ $change->new_value }}</td>
                <td>{{ $change->user->name ?? 'Hệ thống' }}</td>
                <td>{{ $change->changed_at}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted">Chưa có lịch sử thay đổi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Nút quay lại -->
    <div class="text-center mt-4">
        <a href="{{ route('admin.product.index')}}" class="btn btn-secondary">Quay lại</a>
    </div>

</div>

@endsection 