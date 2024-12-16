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
}
