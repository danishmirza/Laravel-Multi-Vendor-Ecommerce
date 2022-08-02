<?php


namespace App\Services;


use App\DTO\SaveCouponDTO;
use App\Models\Coupon;

class CouponService
{
    public function save(SaveCouponDTO $couponDTO, $id)
    {
        try {
            $data = $couponDTO->all();
            return Coupon::updateOrCreate(['id' => $id], $data);
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }
}
