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
                        <a class = "btn btn-primary btn-sm" href="/admin/menu/update/{{$user->id}}">
                            <i class = "fas fa-edit"></i>
                        </a>
                        <a href ='/admin/delete/{{$user->id}}'class = "btn btn-danger btn-sm" onclick = "removeRow(' .$user->id .' \'admin/menu/distroy/')" >
                            <i class = "fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 
