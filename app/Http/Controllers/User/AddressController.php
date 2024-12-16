<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
        ]);

        // Create a new address for the authenticated user
        $address = new Address();
        $address->recipient_name = $request->name;
        $address->phone_number = $request->phone;
        $address->address = $request->address;
        $address->city = $request->city;
        $address->user_id = Auth::id();  // Link address to the logged-in user
        $address->save();

        // Redirect with a success message
        return redirect()->back()->withInput()->with('success', 'Địa chỉ đã được lưu thành công!');

        // $request->validate([
        //     'name' => 'required|max:255',
        //     'phone' => 'required|numeric|digits:10',
        //     'address' => 'required|max:255',
        //     'city' => 'required|max:255',
        // ]);
    
        // Address::create([
        //     'user_id' => Auth::id(),
        //     'recipient_name' => $request->name,
        //     'phone_number' => $request->phone,
        //     'address' => $request->address,
        //     'city' => $request->city,
        //     'is_default' => false,
        // ]);
    
        // return redirect()->back()->with('success', 'Địa chỉ mới đã được thêm!');
    }

    public function update(Request $request)
    {
        $address = Address::find($request->addressId);

        //dd($address);

    //     // Validate input fields
    //     $validated = $request->validate([
    //         'addressId' => 'required|exists:addresses,id',
    //         'name' => 'required|string|max:255',
    //         'phone' => 'required|string|max:15',
    //         'address' => 'required|string|max:255',
    //         'city' => 'required|string|max:255',
    //     ]);

    //     // Find the address by ID
    //     $address = Address::find($request->id);
    //     dd($request->all());

    //     dd($address);
    //     // Update the address fields
        $address->recipient_name = $request->name;
        $address->phone_number = $request->phone;
        $address->address = $request->address;
        $address->city = $request->city;

    //     // Save the updated address to the database
        $address->save();

        // Redirect back with a success message
        return redirect()->back()->withInput()->with('success', 'Địa chỉ đã được cập nhật thành công!');
     }
}
