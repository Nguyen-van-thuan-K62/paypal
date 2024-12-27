<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ProductChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'field_changed',
        'old_value',
        'new_value',
        'changed_by',
        'changed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
