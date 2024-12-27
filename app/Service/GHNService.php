<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GHNService
{
    protected $apiUrl;
    protected $apiKey;
    protected $shopId;

    public function __construct()
    {
        $this->apiUrl = config('ghn.api_url');
        $this->apiKey = config('ghn.api_key');
        $this->shopId = config('ghn.shop_id');
    }

    // Gửi yêu cầu tới GHN API
    private function request($endpoint, $method = 'GET', $data = [])
    {
        $response = Http::withHeaders([
            'Token' => $this->apiKey,
        ])->{$method}($this->apiUrl . $endpoint, $data);

        return $response->json(); // Trả về JSON
    }

    // Lấy danh sách tỉnh/thành phố
    public function getProvinces()
    {
        return $this->request('/master-data/province');
    }

    // Lấy danh sách quận/huyện
    public function getDistricts($provinceId)
    {
        return $this->request('/master-data/district', 'POST', [
            'province_id' => $provinceId,
        ]);
    }

    // Lấy danh sách phường/xã
    public function getWards($districtId)
    {
        return $this->request('/master-data/ward', 'POST', [
            'district_id' => $districtId,
        ]);
    }

    // Tạo đơn hàng
    public function createOrder($data)
    {
        $data['shop_id'] = $this->shopId;
        return $this->request('/v2/shipping-order/create', 'POST', $data);
    }

    // Tính phí vận chuyển
    public function calculateFee($data)
    {
        $data['shop_id'] = $this->shopId;
        return $this->request('/v2/shipping-order/fee', 'POST', $data);
    }
}
