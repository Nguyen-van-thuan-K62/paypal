@extends('admin.components.main')
@section('content')
<div class="container mt-5">
    <!-- Header -->
    <div class="d-flex justify-content-between mb-4">
        <h2>Quản lý đơn hàng</h2>
        <button class="btn btn-primary">Thêm đơn hàng</button>
    </div>

    <!-- Tìm kiếm và Lọc -->
    <div class="row mb-4">
        <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Tìm kiếm theo tên khách hàng hoặc ID đơn hàng">
        </div>
        <div class="col-md-3">
            <select class="form-select">
                <option value="">Lọc theo trạng thái</option>
                <option value="processing">Đang xử lý</option>
                <option value="shipped">Đã giao</option>
                <option value="canceled">Đã hủy</option>
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-success w-100">Lọc</button>
        </div>
    </div>

    <!-- Bảng hiển thị đơn hàng -->
    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>#ID</th>
                <th>Tên khách hàng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dữ liệu mẫu -->
            <tr>
                <td>1001</td>
                <td>Nguyễn Văn A</td>
                <td>$150</td>
                <td><span class="badge bg-warning">Đang xử lý</span></td>
                <td>2024-06-10</td>
                <td>
                    <a href="#" class="btn btn-info btn-sm">Chi tiết</a>
                    <a href="#" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="#" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
            <tr>
                <td>1002</td>
                <td>Trần Thị B</td>
                <td>$200</td>
                <td><span class="badge bg-success">Đã giao</span></td>
                <td>2024-06-09</td>
                <td>
                    <a href="#" class="btn btn-info btn-sm">Chi tiết</a>
                    <a href="#" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="#" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
            <tr>
                <td>1003</td>
                <td>Hoàng Văn C</td>
                <td>$80</td>
                <td><span class="badge bg-danger">Đã hủy</span></td>
                <td>2024-06-08</td>
                <td>
                    <a href="#" class="btn btn-info btn-sm">Chi tiết</a>
                    <a href="#" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="#" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Phân trang -->
    <nav aria-label="Pagination">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link">Trước</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item active"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Sau</a>
            </li>
        </ul>
    </nav>
</div>

@endsection 
