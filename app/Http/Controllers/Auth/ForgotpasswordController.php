<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class ForgotpasswordController extends Controller
{
    public function showCheckEmailForm()
    {
        return view('auth.forgot_password');
    }
    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Tài khoản không tồn tại.');
        }

        // Tạo mã OTP ngẫu nhiên
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(5); // Mã OTP có thời hạn 10 phút
        $user->save();

        // Gửi email
        Mail::raw("Mã OTP của bạn là: $otp", function ($message) use ($request) {
            $message->to($request->email)->subject('Xác nhận OTP');
        });

        return view('auth.forgot_password_otp')->with(['email' => $request->email]);
    }

    public function checkOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        dd($user);
        if (!$user || $user->otp !== $request->otp || $user->otp_expires_at->isPast()) {
            return back()->withErrors(['error' => 'Mã OTP không hợp lệ.']);
        }

        // OTP đúng, chuyển sang bước đặt lại mật khẩu
        return view('auth.forgot_password_reset')->with(['email' => session('email')]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Tài khoản không tồn tại.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Xóa session OTP
        session()->forget(['otp', 'email']);

        return redirect()->route('login')->with('success', 'Mật khẩu đã được cập nhật.');
    }
}
