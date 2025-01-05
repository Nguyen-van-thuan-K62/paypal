<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class GoogleController extends Controller
{
    // Chuyển hướng người dùng tới trang đăng nhập Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Xử lý callback từ Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Kiểm tra xem user đã tồn tại chưa
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Cập nhật thông tin nếu cần
                $user->update([
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // Tạo user mới
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt('123456dummy'), // Mật khẩu mặc định hoặc bỏ
                    'is_agreed_terms' => true, // Đã đồng ý điều khoản
                ]);
            }

            // Tạo mã OTP ngẫu nhiên
            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->otp_expires_at = now()->addMinutes(5); // Mã OTP có thời hạn 10 phút
            $user->save();

            // Gửi mã OTP qua email
            Mail::to($user->email)->send(new OtpMail($otp));

            // Chuyển hướng người dùng tới trang nhập OTP
            return redirect()->route('verifyOtpForm')->with('email', $user->email);

        } catch (\Exception $e) {
            // Log lỗi và hiển thị thông báo lỗi
            Log::error('Google login error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Đã xảy ra lỗi trong quá trình đăng nhập Google. Xin thử lại sau.');
        }
    }
}
