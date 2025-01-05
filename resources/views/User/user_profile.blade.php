@extends('User.components.main')
@section('content')
<div class="container mt-5 mb-5">
    <h1 class="text-center mb-4">Thông tin của bạn</h1>
    
    <!-- User Information -->
    <div class="card mb-4 mt-5">
        <div class="card-body">
            <h5 class="card-title">Thông tin cá nhân</h5>
            <form action="/user/profile/update" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="userName" class="form-label">Họ và tên :</label>
                    <input type="text" name="name" class="form-control" id="userName" value="{{$user->name}}" required>
                </div>
                <div class="mb-3">
                    <label for="userEmail" class="form-label">Email :</label>
                    <input type="email" name="email" class="form-control" id="userEmail" value="{{$user->email}}" required>
                </div>
                <div class="mb-3">
                    <label for="userPhone" class="form-label">Số điện thoại :</label>
                    <input type="text" name="phone" class="form-control" id="userPhone" value="{{$user->address->phone_number}}" required>
                </div>
                <div class="mb-3">
                    <label for="userAddress" class="form-label">Địa chỉ :</label>
                    <input type="text" name="address" class="form-control" id="userAddress" value="{{ $user->address->address }}" required>
                </div>
                <div class="mb-3">
                    <label for="userCity" class="form-label">Thành phố :</label>
                    <input type="text" name="city" class="form-control" id="userCityCity" value="{{ $user->address->city }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhập thông tin</button>
            </form>
        </div>
    </div>

    <!-- Password Update -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Thay đổi mật khẩu</h5>
            <form  action="/user/profile/update_password" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="currentPassword" class="form-label">Mật khẩu hiện tại :</label>
                    <input type="password" name ="current_password" class="form-control" id="currentPassword" required>
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label">Mật khẩu mới :</label>
                    <input type="password"  name="new_password" class="form-control" id="newPassword" required>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Nhập lại mật khẩu mới :</label>
                    <input type="password" name="" class="form-control" id="confirmPassword" required>
                </div>
                <button type="submit" class="btn btn-primary">Thay đổi mật khẩu</button>
            </form>
        </div>
    </div>
</div>
@endsection 