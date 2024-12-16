<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(){
        return View('admin.dashboard',[
            'title'=>"Quản Trị Admin",
            'users'=>User::paginate(5)
        ]);
    }   
}
