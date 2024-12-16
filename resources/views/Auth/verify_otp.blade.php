<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhập OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Nhập Mã OTP</h2>
        <p class="text-center">Vui lòng nhập mã OTP đã gửi đến email của bạn.</p>

        <form action="{{ route('verifyOtp') }}" method="POST" id="otp-form">
            @csrf
            
            <input type="hidden" name="email" value="{{ session('email') }}">
            <div class="mb-3">
                <label for="otp" class="form-label">Mã OTP</label>
                <input type="text" name="otp" class="form-control" id="otp" placeholder="Nhập mã OTP" required>
            </div>
            <button type="submit" class="btn btn-primary">Xác minh</button>
            <p class="mt-3"> Chưa nhận được mã? <a href="#">Gửi lại mã</a></p>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
