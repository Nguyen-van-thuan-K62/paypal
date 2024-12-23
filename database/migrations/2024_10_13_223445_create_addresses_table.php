<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Liên kết đến bảng người dùng
            $table->string('recipient_name');  // Tên người nhận
            $table->string('phone_number');    // Số điện thoại
            $table->text('address');           // Địa chỉ chi tiết
            $table->string('city');            // Thành phố
            $table->boolean('is_default')->default(true); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
