<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer('*', function ($view) {
            
            $cartCount = 0;
            $orderCount = 0;
            $orderCountpending = 0;
            $orderCountconfirmed = 0;
            $orderCountpreparing = 0;
            $orderCountready_to_ship = 0;
            $orderCountdelivered = 0;
            $orderCountcancelled = 0;

            if (Auth::check()) {
                // Nếu người dùng đã đăng nhập

                $cartCount = Cart::where('user_id', Auth::id()) // Lọc theo người dùng hiện tại 
                ->sum('quantity'); // Tính tổng số lượng

                $orderCount = Order::where('user_id', Auth::id())->count();// Đếm số đơn hàng của người dùng hiện tại
                $orderCountpending = Order::where('user_id', Auth::id())->where('status', 'pending')->count(); // Đếm số đơn hàng đang chờ xử lý
                $orderCountconfirmed = Order::where('user_id', Auth::id())->where('status', 'confirmed')->count(); // Đếm số đơn hàng đã xác nhận
                $orderCountpreparing = Order::where('user_id', Auth::id())->where('status', 'preparing')->count(); // Đếm số đơn hàng đang chuẩn bị
                $orderCountready_to_ship = Order::where('user_id', Auth::id())->where('status', 'ready_to_ship')->count(); // Đếm số đơn hàng sẵn sàng giao
                $orderCountdelivered = Order::where('user_id', Auth::id())->where('status', 'delivered')->count(); // Đếm số đơn hàng đã giao
                $orderCountcancelled = Order::where('user_id', Auth::id())->where('status', 'cancelled')->count();  // Đếm số đơn hàng đã hủy

            }
    
            $view->with([
                'cartCount' => $cartCount, 
                'orderCount' => $orderCount,
                'orderCountpending' => $orderCountpending,
                'orderCountconfirmed' => $orderCountconfirmed,
                'orderCountpreparing' => $orderCountpreparing,
                'orderCountready_to_ship' => $orderCountready_to_ship,
                'orderCountdelivered' => $orderCountdelivered,
                'orderCountcancelled' => $orderCountcancelled,
            ]);
        });
    }
}
