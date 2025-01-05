<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Hiển thị form đăng ký
    public function index(){
        return view("auth.register");
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'is_agreed_terms' => 'required'
        ]);
        
        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_agreed_terms' => '1',
            'status' => 'active'
        ]);
        // Tạo mã OTP ngẫu nhiên
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(5); // Mã OTP có thời hạn 10 phút
        $user->save();

        // Gửi mã OTP qua email
        Mail::to($user->email)->send(new OtpMail($otp));

        // Chuyển hướng người dùng tới trang nhập OTP
        return redirect()->route('verifyOtpForm')->with('email', $user->email);
    }

    // Hiển thị form xác thực OTP
    public function showVerifyOtpForm()
    {
        return view('auth.verify_otp');
    }

    // Xác thực OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'email' => 'required|email',
        ]);

        // Tìm người dùng theo email
        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp !== $request->otp || $user->otp_expires_at->isPast()) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }
        // OTP đúng, cập nhật thông tin người dùng
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->email_verified_at = now();
        $user->save();

        // Đăng nhập user
        Auth::login($user);

        // Chuyển hướng về trang người dùng muốn đến (hoặc trang chủ)
        return redirect()->intended(route('home'));
    }
}
