<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Address;


class ProfileController extends Controller
{
    public function edit()
    {
        $user = User::with('address')->find(Auth::id());
        return view('user.user_profile',[
                'title' => 'Thông tin người dùng',
                'user' => $user
            ]);
    }

    // Update user information
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        User::updateOrCreate(
            ['email' => $request->email], // Điều kiện tìm kiếm
            [
                'name' => $request->name,
                'email' => $request->email,
            ] // Dữ liệu để thêm/cập nhật
        );

        // Cập nhật thông tin địa chỉ
        $address = $user->address;
        if (!$address) {
            $address = new Address();
            $address->user_id = $user->id;
        }
        $address->phone_number = $request->input('phone');
        $address->address = $request->input('address');
        $address->city = $request->input('city');

        $address->save();

        return redirect()->back()->with('success', 'Thông tin cá nhân đã được cập nhật.');
    }

    // Update user password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Kiểm tra mật khẩu hiện tại   
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        // Cập nhật mật khẩu
        User::updateOrCreate(
            ['email' => $request->email], // Điều kiện tìm kiếm
            [
                'password' => bcrypt($request->new_password), // Mã hóa mật khẩu
            ] 
        );
        
        return redirect()->back()->with('success', 'Mật khẩu đã được thay đổi.');
    }
}
