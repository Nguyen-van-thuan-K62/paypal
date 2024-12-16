<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function index(){
        return view("auth.login");
    }

    public function login(Request $request){

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); 
        if (Auth::attempt($credentials,$remember)) {
           
            $user = Auth::user(); 

            if ($user->role==="admin") {
                return redirect()->intended('/admin/dashboard');  // Trang dành cho admin
            } else {
                return redirect()->intended('/user/userhome');  // Trang dành cho user
            }
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }
}
