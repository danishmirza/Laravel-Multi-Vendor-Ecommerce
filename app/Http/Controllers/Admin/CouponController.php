<?php


namespace App\Http\Controllers\Admin;


use App\DTO\SaveCouponDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveCouponRequest;
use App\Models\Coupon;
use App\Services\CouponService;
use App\Services\DatatableService;

class CouponController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.coupons.index');
    }

    public function all(DatatableService $datatableService)
    {
        $pages = $datatableService->couponDatabase();
        return response($pages);
    }

    public function create(Coupon $coupon)
    {
        return view('admin.dashboard.coupons.edit', [
            'couponId' => 0,
            'action' => route('admin.dashboard.coupons.update', 0),
            'heading' => 'Add Coupon',
            'coupon' => $coupon->getInitialObject()
        ]);
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.dashboard.coupons.edit', [
            'couponId' => $coupon->id,
            'action' => route('admin.dashboard.coupons.update', $coupon->id),
            'heading' => 'Edit Coupon',
            'coupon' => $coupon
        ]);
    }

    public function update(SaveCouponRequest $request, $id, CouponService $couponService)
    {
        try {
            $couponService->save(SaveCouponDTO::fromCollection(collect($request->validated())), $id);
            return redirect(route('admin.dashboard.coupons.index'))->with('status', ($id == 0) ? 'Coupon added successfully.' : 'Coupon updated successfully.');
        } catch (\Exception $e) {
            return response(['err' => $e->getMessage()]);
        }
    }

    public function destroy(Coupon $coupon)
    {
        try {
            $coupon->delete();
            return response(['msg' => 'Coupon deleted']);
        } catch (\Exception $e) {
            return response(['err' => $e->getMessage()]);
        }
    }
}
