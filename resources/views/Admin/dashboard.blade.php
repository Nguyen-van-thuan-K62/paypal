@extends('admin.components.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sản phẩm -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">Sản phẩm</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#ID sản phẩm </th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>#{{ $product->id }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ number_format($product->price, 0, ',', '.') }} VND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right">
                    <a href="/admin/product/index" class="btn btn-sm btn-primary">Xem tất cả</a>
                </div>
            </div>
        </div>

        <!-- Người dùng -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="card-title mb-0">Người dùng</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#ID người dùng </th>
                                <th>Tên</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>#{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right">
                    <a href="/admin/account/index" class="btn btn-sm btn-success">Xem tất cả</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Đơn hàng -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="card-title mb-0">Đơn hàng</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#ID đơn hàng</th>
                                <th>Tên người đặt</th>
                                <th>Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ number_format($order->total_amount, 0, ',', '.') }} VND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right">
                    <a href="/admin/order/index" class="btn btn-sm btn-warning">Xem tất cả</a>
                </div>
            </div>
        </div>

        <!-- Bình luận -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="card-title mb-0">Bình luận</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#ID đánh giá</th>
                                <th>Người đánh giá</th>
                                <th>Nội dung</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $comment)
                                <tr>
                                    <td>#{{ $comment->id }}</td>
                                    <td>{{ $comment->user->name }}</td>
                                    <td>{{ Str::limit($comment->content, 50) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right">
                    <a href="/admin/manage_comment/index" class="btn btn-sm btn-danger">Xem tất cả</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
