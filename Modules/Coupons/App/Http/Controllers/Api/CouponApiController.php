<?php

namespace Modules\Coupons\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Coupons\Services\CouponService;

class CouponApiController extends Controller
{
    public function __construct(protected CouponService $couponService) {}

    public function index()
    {
        return response()->json($this->couponService->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'     => 'required|string|max:50|unique:coupons,code',
            'type'     => 'required|string|in:percentage,fixed',
            'value'    => 'required|numeric|min:0',
            'max_uses' => 'required|integer|min:1',
            'status'   => 'required|string',
        ]);

        $coupon = $this->couponService->create($validated);
        return response()->json(['message' => 'Coupon created successfully', 'data' => $coupon], 201);
    }

    public function show($id)
    {
        return response()->json($this->couponService->findById($id));
    }

    public function update(Request $request, $id)
    {
        $coupon = $this->couponService->findById($id);
        $validated = $request->validate([
            'code'     => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'type'     => 'required|string|in:percentage,fixed',
            'value'    => 'required|numeric|min:0',
            'max_uses' => 'required|integer|min:1',
            'status'   => 'required|string',
        ]);

        $coupon = $this->couponService->update($coupon, $validated);
        return response()->json(['message' => 'Coupon updated successfully', 'data' => $coupon]);
    }

    public function destroy($id)
    {
        $coupon = $this->couponService->findById($id);
        $this->couponService->delete($coupon);
        return response()->json(['message' => 'Coupon deleted successfully']);
    }
}
