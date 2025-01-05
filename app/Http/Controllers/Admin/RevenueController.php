<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class RevenueController extends Controller
{
    
     // Thống kê doanh thu
     public function index(Request $request)
     {
         // Lấy ngày bắt đầu và kết thúc từ request (mặc định lấy 30 ngày gần nhất)
         $startDate = $request->input('start_date', now()->subDays(30)->toDateString());
         $endDate = $request->input('end_date', now()->toDateString());
         $groupBy = $request->input('group_by', 'day'); // Mặc định là nhóm theo ngày
 
         // Lấy dữ liệu doanh thu theo ngày, tuần, hoặc tháng
         switch ($groupBy) {
             case 'week':
                 $revenueData = Order::where('status', 'delivered') // Chỉ tính đơn đã giao
                     ->whereBetween('created_at', [$startDate, $endDate])
                     ->selectRaw('YEAR(created_at) as year, WEEK(created_at) as week, SUM(total_amount) as revenue, COUNT(id) as order_count')
                     ->groupBy('year', 'week')
                     ->orderBy('year', 'asc')
                     ->orderBy('week', 'asc')
                     ->get();
                 break;
             
             case 'month':
                 $revenueData = Order::where('status', 'delivered')
                     ->whereBetween('created_at', [$startDate, $endDate])
                     ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_amount) as revenue, COUNT(id) as order_count')
                     ->groupBy('year', 'month')
                     ->orderBy('year', 'asc')
                     ->orderBy('month', 'asc')
                     ->get();
                 break;
 
             default: // Nhóm theo ngày
                 $revenueData = Order::where('status', 'delivered')
                     ->whereBetween('created_at', [$startDate, $endDate])
                     ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(id) as order_count')
                     ->groupBy('date')
                     ->orderBy('date', 'asc')
                     ->get();
                 break;
         }
 
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
             'groupBy' => $groupBy
         ]);
     }
 
        // Xem chi tiết doanh thu theo ngày, tuần, hoặc tháng
    public function showDetails($period, $id)
    {
        // Lấy danh sách đơn hàng đã giao
        $orders = Order::where('status', 'delivered');

        if ($period === 'day') {
            $orders->whereDate('created_at', $id);
        } elseif ($period === 'week') {
            $orders->whereBetween('created_at', [$this->startOfWeek($id), $this->endOfWeek($id)]);
        } elseif ($period === 'month') {
            $orders->whereMonth('created_at', $id);
        }

        $orders = $orders->get();

        return view('admin.revenue.details',[
                    'title' => "Chi tiết đơn hàng",
                    'orders' => $orders,
                    'period' => $period,
                    'id' => $id,
                ]);
    }
    // Tính ngày đầu tiên trong tuần
    private function startOfWeek($weekNumber)
    {
        $year = date('Y');
        $dto = new \DateTime();
        $dto->setISODate($year, $weekNumber);
        return $dto->format('Y-m-d');
    }
    // Tính ngày cuối cùng trong tuần
    private function endOfWeek($weekNumber)
    {
        $year = date('Y');
        $dto = new \DateTime();
        $dto->setISODate($year, $weekNumber);
        $dto->modify('+6 days');
        return $dto->format('Y-m-d');
    }
} 
