<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    //thêm địa chỉ mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
        ]);
        
        $address = new Address();
        $address->recipient_name = $request->name;
        $address->phone_number = $request->phone;
        $address->address = $request->address;
        $address->city = $request->city;
        $address->user_id = Auth::id();  // Lấy ID của người dùng hiện tại
        $address->save();

        return redirect()->back()->withInput()->with('success', 'Địa chỉ đã được lưu thành công!');

    }
    // cập nhật địa chỉ
    public function update(Request $request)
    {
        $address = Address::find($request->addressId);

        $address->recipient_name = $request->name;
        $address->phone_number = $request->phone;
        $address->address = $request->address;
        $address->city = $request->city;

        $address->save();

        return redirect()->back()->withInput()->with('success', 'Địa chỉ đã được cập nhật thành công!');
     }
}
