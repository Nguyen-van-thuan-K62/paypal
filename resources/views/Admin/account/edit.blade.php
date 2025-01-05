@extends('admin.components.main')

@section('content')
<div class="container mt-5">
    <h2>Sửa người dùng</h2>
    <form action="{{ route('admin.account.update', $user->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
        </div>
        <div class="form-group">
            <label for="role">Vai trò</label>
            <select name="role" class="form-control">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Người dùng</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
    </form>
</div>
@endsection
