<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class RevenueController extends Controller
{
    //thong ke doanh thu
    public function index(Request $request)
    {
        // Lấy ngày bắt đầu và kết thúc từ request (mặc định lấy 30 ngày gần nhất)
        $startDate = $request->input('start_date', now()->subDays(30)->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        // Lấy dữ liệu doanh thu theo ngày
        $revenueData = Order::where('status', 'delivered') // Chỉ tính đơn đã giao
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(id) as order_count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Tổng doanh thu và số đơn hàng
        $totalRevenue = $revenueData->sum('revenue');
        $totalOrders = $revenueData->sum('order_count');

        return view('admin.revenue.index', [
            'title' => "Thống kê doanh thu",
            'revenueData' => $revenueData,
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
