@extends('admin.components.main')
@section('content')
<div class="container mt-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý người dùng</h2>
    </div>

    <!-- Tìm kiếm và Lọc -->
    <div class="row mb-4">
        <form action="" method="GET" class="row">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên hoặc email" value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select">
                    <option value="">Lọc theo vai trò</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Người dùng</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Lọc theo trạng thái</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Vô hiệu hóa</option>
                </select>
            </div>
            <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">Lọc và Tìm kiếm</button>
            </div>
        </form>
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
            
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role}}</td>
                    <td>
                        @if($user->status == 'active')
                            <span class="badge bg-success">Hoạt động</span>
                        @else
                            <span class="badge bg-secondary">Vô hiệu hóa</span>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('admin.account.show', $user->id) }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.account.edit', $user->id) }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a class="btn btn-danger btn-sm" href="{{ route('admin.account.delete', $user->id) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                            <i class="fas fa-trash"></i>
                        </a>
                        <a class="btn btn-warning btn-sm" href="{{ route('admin.account.lock', $user->id) }}" onclick="return confirm('Bạn có chắc chắn muốn khóa tài khoản này?')">
                            <i class="fas fa-lock"></i>
                        </a>
                    </td>                    
                    {{-- <td>
                        <a class = "btn btn-primary btn-sm" href="/admin/menu/update/{{$user->id}}">
                            <i class = "fas fa-edit"></i>
                        </a>
                        <a href ='/admin/delete/{{$user->id}}'class = "btn btn-danger btn-sm" onclick = "removeRow(' .$user->id .' \'admin/menu/distroy/')" >
                            <i class = "fas fa-trash"></i>
                        </a>
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 
