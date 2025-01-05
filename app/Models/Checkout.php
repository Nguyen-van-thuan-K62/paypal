<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{

    use HasFactory;

    protected $fillable = ['user_id', 'selected_items', 'default_address_id'];
    
    protected $casts = [
        'selected_items' => 'array', // Lưu trữ selected_items dưới dạng mảng
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'default_address_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    
}
