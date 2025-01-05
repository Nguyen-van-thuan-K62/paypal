@extends('admin.components.main')

@section('content')
<div class="container mt-5">
    <h2>Chi tiết người dùng</h2>
    <table class="table">
        <tr>
            <th>ID</th>
            <td>{{ $user->id }}</td>
        </tr>
        <tr>
            <th>Tên</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>Vai trò</th>
            <td>{{ $user->role }}</td>
        </tr>
        <tr>
            <th>Trạng thái</th>
            <td>{{ $user->status == 'active' ? 'Hoạt động' : 'Vô hiệu hóa' }}</td>
        </tr>
    </table>
    <a href="{{ route('admin.account.edit', $user->id) }}" class="btn btn-warning">Sửa</a>
</div>
@endsection
