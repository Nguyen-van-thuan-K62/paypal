@extends('admin.components.main')
@section('content')
{{-- <table class = "table table-striped">
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>           
            <th>email</th>
            <th>pasword</th>
            <th>role</th>
        </tr>
    </thead>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->password}}</td>
                <td>{{$user->role}}</td>
                <td>
                    <a class = "btn btn-primary btn-sm" href="/admin/menu/update/{{$user->id}}">
                        <i class = "fas fa-edit"></i>
                    </a>
                    <a href ='/admin/delete/{{$user->id}}'class = "btn btn-danger btn-sm" onclick = "removeRow(' .$user->id .' \'admin/menu/distroy/')" >
                        <i class = "fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            
        @endforeach
      
        
</table> --}}
<div class="container mt-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý người dùng</h2>
        <button class="btn btn-primary">Thêm người dùng</button>
    </div>

    <!-- Tìm kiếm và Lọc -->
    <div class="row mb-4">
        <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Tìm kiếm theo tên hoặc email">
        </div>
        <div class="col-md-3">
            <select class="form-select">
                <option value="">Lọc theo vai trò</option>
                <option value="admin">Admin</option>
                <option value="user">Người dùng</option>
                <option value="editor">Biên tập viên</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select">
                <option value="">Lọc theo trạng thái</option>
                <option value="active">Hoạt động</option>
                <option value="inactive">Vô hiệu hóa</option>
            </select>
        </div>
    </div>

    <!-- Bảng danh sách người dùng -->
    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>#ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Vai trò</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dữ liệu mẫu -->
            <tr>
                <td>1</td>
                <td>Nguyễn Văn A</td>
                <td>nguyenvana@gmail.com</td>
                <td>Admin</td>
                <td><span class="badge bg-success">Hoạt động</span></td>
                <td>
                    <button class="btn btn-warning btn-sm">Sửa</button>
                    <button class="btn btn-secondary btn-sm">Vô hiệu hóa</button>
                    <button class="btn btn-danger btn-sm">Xóa</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Trần Thị B</td>
                <td>tranthib@gmail.com</td>
                <td>Người dùng</td>
                <td><span class="badge bg-danger">Vô hiệu hóa</span></td>
                <td>
                    <button class="btn btn-warning btn-sm">Sửa</button>
                    <button class="btn btn-success btn-sm">Kích hoạt</button>
                    <button class="btn btn-danger btn-sm">Xóa</button>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Hoàng Văn C</td>
                <td>hoangvanc@gmail.com</td>
                <td>Biên tập viên</td>
                <td><span class="badge bg-success">Hoạt động</span></td>
                <td>
                    <button class="btn btn-warning btn-sm">Sửa</button>
                    <button class="btn btn-secondary btn-sm">Vô hiệu hóa</button>
                    <button class="btn btn-danger btn-sm">Xóa</button>
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
