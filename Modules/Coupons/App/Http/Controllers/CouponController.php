<?php

namespace Modules\Coupons\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Coupons\Services\CouponService;

class CouponController extends Controller
{
    public function __construct(protected CouponService $couponService) {}

    public function index()
    {
        $coupons = $this->couponService->getAll();
        return view('Coupons::index', compact('coupons'));
    }

    public function create()
    {
        return view('Coupons::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'       => 'required|string|max:50|unique:coupons,code',
            'type'       => 'required|string|in:percentage,fixed',
            'value'      => 'required|numeric|min:0',
            'max_uses'   => 'required|integer|min:1',
            'status'     => 'required|string',
            'expires_at' => 'nullable|date',
        ]);

        $this->couponService->create($validated);

        return redirect()->route('coupons.index')->with('success', 'Coupon discount voucher created successfully.');
    }

    public function show($id)
    {
        $coupon = $this->couponService->findById($id);
        return view('Coupons::show', compact('coupon'));
    }

    public function edit($id)
    {
        $coupon = $this->couponService->findById($id);
        return view('Coupons::edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = $this->couponService->findById($id);

        $validated = $request->validate([
            'code'       => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'type'       => 'required|string|in:percentage,fixed',
            'value'      => 'required|numeric|min:0',
            'max_uses'   => 'required|integer|min:1',
            'status'     => 'required|string',
            'expires_at' => 'nullable|date',
        ]);

        $this->couponService->update($coupon, $validated);

        return redirect()->route('coupons.index')->with('success', 'Coupon discount voucher updated successfully.');
    }

    public function destroy($id)
    {
        $coupon = $this->couponService->findById($id);
        $this->couponService->delete($coupon);

        return redirect()->route('coupons.index')->with('success', 'Coupon discount voucher deleted successfully.');
    }
}
