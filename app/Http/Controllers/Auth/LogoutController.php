<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    // Đăng xuất người dùng
    public function logout(Request $request)
    {
        Auth::logout(); // Đăng xuất người dùng

        // Xoá session hiện tại
        $request->session()->invalidate();

        // Tạo lại session token để tránh các tấn công CSRF sau khi đăng xuất
        $request->session()->regenerateToken();

        // Chuyển hướng về trang chủ (hoặc bất kỳ trang nào bạn muốn)
        return redirect('/');
    }
}
