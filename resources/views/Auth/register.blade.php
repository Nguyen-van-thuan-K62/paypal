<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }
        .registration-form {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .registration-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .social-login {
            display: flex;
            justify-content: space-between;
        }
        .btn-google {
            background-color: #dd4b39;
            color: white;
        }
        .btn-facebook {
            background-color: #3b5998;
            color: white;
        }
        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }
        .divider::before,
        .divider::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background-color: #ddd;
        }
        .divider::before {
            left: 0;
        }
        .divider::after {
            right: 0;
        }
        .divider span {
            background-color: #fff;
            padding: 0 10px;
        }
    </style>
</head>
<body>

<div class="registration-form">
    <h2>Đăng ký</h2>
    <form action="/register" method = "post">
        @csrf
        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Họ và Tên</label>
            <input type="text" class="form-control" id="name" placeholder="Nhập họ và tên" name="name">
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Địa chỉ Email</label>
            <input type="email" class="form-control" id="email" placeholder="Nhập email" name="email">
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" name="password">
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="confirm-password" class="form-label">Xác nhận mật khẩu</label>
            <input type="password" class="form-control" id="confirm-password" placeholder="Xác nhận mật khẩu" required oninput="validatePasswords()">
        </div>

        <!-- Terms Checkbox -->
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_agreed_terms" id="terms" required>
            <label class="form-check-label" for="terms">
                Tôi đồng ý với các <a href="#">Điều khoản dịch vụ</a> và <a href="#">Chính sách bảo mật</a>.
            </label>
            <div id="terms-error" class="text-danger" style="display: none;">Bạn cần đồng ý với các điều khoản để tiếp tục.</div>
        </div>

        <!-- Submit Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
        </div>
    </form>
    {{-- thong bao loi --}}
    <div id="error-message" class="text-danger" style="display: none;"></div>

    <!-- Divider -->
    <div class="divider">
        <span>hoặc</span>
    </div>

    <div class="mt-3 text-center">
        <a href="{{ route('google.login') }}" class="btn btn-danger">
            <button class="btn btn-google btn-block"><i class="bi bi-google"></i>   Google   </button>
        </a>
    </div>
    
</div>

<script>
    function validatePasswords() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
        const errorMessage = document.getElementById('error-message');
    
        if (confirmPassword && password !== confirmPassword) {
            errorMessage.style.display = 'block';
            errorMessage.textContent = 'Mật khẩu không khớp. Vui lòng kiểm tra lại.';
        } else {
            errorMessage.style.display = 'none'; // Ẩn thông báo lỗi nếu mật khẩu khớp
        }
    }

    function validateTerms() {
        const termsCheckbox = document.getElementById('terms');
        const termsError = document.getElementById('terms-error');

        if (!termsCheckbox.checked) {
            termsError.style.display = 'block';
            return false; // Ngăn không cho form được gửi
        } else {
            termsError.style.display = 'none'; // Ẩn thông báo lỗi nếu checkbox được chọn
        }
        return true; // Cho phép form được gửi
    }

    // Kết hợp xác thực mật khẩu và checkbox khi gửi form
    document.getElementById('registration-form').onsubmit = function() {
        const passwordsValid = validatePasswords();
        const termsValid = validateTerms();
        return passwordsValid && termsValid; // Chỉ gửi form nếu cả hai điều kiện đều hợp lệ
    };
</script>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Icons from Bootstrap Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
</body>
</html>
