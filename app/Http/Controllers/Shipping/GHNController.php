<?php

namespace App\Http\Controllers\Shipping;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GHNService;

class GHNController extends Controller
{
    protected $ghnService;

    public function __construct(GHNService $ghnService)
    {
        $this->ghnService = $ghnService;
    }

    // Lấy danh sách tỉnh/thành phố
    public function getProvinces()
    {
        $provinces = $this->ghnService->getProvinces();
        return response()->json($provinces);
    }

    // Tạo đơn hàng
    public function createOrder(Request $request)
    {
        $orderData = [
            'to_name' => $request->to_name,
            'to_phone' => $request->to_phone,
            'to_address' => $request->to_address,
            'to_ward_code' => $request->to_ward_code,
            'to_district_id' => $request->to_district_id,
            'weight' => $request->weight,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'service_type_id' => $request->service_type_id,
        ];

        $response = $this->ghnService->createOrder($orderData);
        return response()->json($response);
    }

    // Tính phí vận chuyển
    public function calculateFee(Request $request)
    {
        $feeData = [
            'to_district_id' => $request->to_district_id,
            'service_type_id' => $request->service_type_id,
            'weight' => $request->weight,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
        ];

        $response = $this->ghnService->calculateFee($feeData);
        return response()->json($response);
    }
}
