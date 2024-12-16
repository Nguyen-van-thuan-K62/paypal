<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AccountController extends Controller
{
    public function index(){
        return View('admin.account.index',[
            'title'=>"Danh sách người dùng",
            'users'=>User::paginate(100)
        ]);
    }
}
