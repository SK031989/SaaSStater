<?php

namespace Modules\Coupons\Services;

use Modules\Coupons\App\Models\Coupon;

class CouponService
{
    public function getAll()
    {
        return Coupon::latest()->paginate(10);
    }

    public function findById(int $id): Coupon
    {
        return Coupon::findOrFail($id);
    }

    public function create(array $data): Coupon
    {
        return Coupon::create([
            'code'       => strtoupper($data['code']),
            'type'       => $data['type'] ?? 'percentage',
            'value'      => $data['value'],
            'max_uses'   => $data['max_uses'] ?? 100,
            'used_count' => 0,
            'status'     => $data['status'] ?? 'active',
            'expires_at' => $data['expires_at'] ?? now()->addMonth(),
        ]);
    }

    public function update(Coupon $coupon, array $data): Coupon
    {
        $coupon->update([
            'code'       => strtoupper($data['code']),
            'type'       => $data['type'] ?? $coupon->type,
            'value'      => $data['value'] ?? $coupon->value,
            'max_uses'   => $data['max_uses'] ?? $coupon->max_uses,
            'status'     => $data['status'] ?? $coupon->status,
            'expires_at' => $data['expires_at'] ?? $coupon->expires_at,
        ]);

        return $coupon;
    }

    public function delete(Coupon $coupon): bool
    {
        return $coupon->delete();
    }
}
