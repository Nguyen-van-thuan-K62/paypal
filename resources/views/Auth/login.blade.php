<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }
        .login-form {
            max-width: 400px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .login-form h2 {
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

<div class="login-form">
    <h2>Đăng nhập</h2>
    <form action="/login " method = "post">
        @csrf
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

        <!-- Remember me -->
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="remember-me" name="remember">
            <label class="form-check-label" for="remember-me">
                Ghi nhớ đăng nhập
            </label>
        </div>

        <!-- Submit Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
        </div>

        <!-- Forgot password link -->
        <div class="mt-3 text-center">
            <a href="#">Quên mật khẩu?</a>
        </div>
    </form>

    <!-- Divider -->
    <div class="divider">
        <span>hoặc</span>
    </div>

    <!-- Social Login Buttons -->
    <div class="social-login">
        <button class="btn btn-google btn-block"><i class="bi bi-google"></i>   Google   </button>
        <button class="btn btn-facebook btn-block"><i class="bi bi-facebook"></i>   Facebook   </button>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Icons from Bootstrap Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
</body>
</html>