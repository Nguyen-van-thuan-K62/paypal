<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AccountController extends Controller
{
   
    public function index(Request $request)
    {
        $query = User::query();

        // Tìm kiếm theo tên hoặc email
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Lọc theo vai trò
        if ($request->has('role') && !empty($request->role)) {
            $query->where('role', $request->role);
        }

        // Lọc theo trạng thái
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $users = $query->paginate(10);

        return view('admin.account.index', [
            'users' => $users,
            'title' => "Danh sách người dùng",
        ]);
    }

    //xem chi tiết người dùng
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.account.show', [
            'user' => $user,
            'title' => "Chi tiết người dùng",
        ]);
    }

    //chỉnh sửa người dùng
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.account.edit', [
            'user' => $user,
            'title' => "Chỉnh sửa người dùng",
        ]);
    }
    //cập nhật người dùng
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('admin.account.index')->with('success', 'Cập nhật người dùng thành công!');
    }

    //khóa tài khoản
    public function lock($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'inactive'; // Đổi trạng thái thành 'inactive'
        $user->save();
        return redirect()->route('admin.account.index')->with('success', 'Tài khoản đã bị khóa!');
    }

    //mở khóa tài khoản
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.account.index')->with('success', 'Người dùng đã bị xóa!');
    }





}
