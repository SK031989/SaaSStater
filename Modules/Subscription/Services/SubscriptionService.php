<?php

namespace Modules\Subscription\Services;

use Illuminate\Support\Str;
use Modules\Subscription\App\Models\SubscriptionPlan;

class SubscriptionService
{
    public function getAll()
    {
        return SubscriptionPlan::latest()->paginate(10);
    }

    public function findById(int $id): SubscriptionPlan
    {
        return SubscriptionPlan::findOrFail($id);
    }

    public function create(array $data): SubscriptionPlan
    {
        return SubscriptionPlan::create([
            'name'          => $data['name'],
            'slug'          => Str::slug($data['name']),
            'price_monthly' => $data['price_monthly'] ?? 0,
            'price_yearly'  => $data['price_yearly'] ?? 0,
            'max_users'     => $data['max_users'] ?? 10,
            'is_popular'    => isset($data['is_popular']) ? (bool)$data['is_popular'] : false,
            'status'        => $data['status'] ?? 'active',
            'description'   => $data['description'] ?? null,
        ]);
    }

    public function update(SubscriptionPlan $plan, array $data): SubscriptionPlan
    {
        $plan->update([
            'name'          => $data['name'],
            'slug'          => Str::slug($data['name']),
            'price_monthly' => $data['price_monthly'] ?? $plan->price_monthly,
            'price_yearly'  => $data['price_yearly'] ?? $plan->price_yearly,
            'max_users'     => $data['max_users'] ?? $plan->max_users,
            'is_popular'    => isset($data['is_popular']) ? (bool)$data['is_popular'] : false,
            'status'        => $data['status'] ?? $plan->status,
            'description'   => $data['description'] ?? $plan->description,
        ]);

        return $plan;
    }

    public function delete(SubscriptionPlan $plan): bool
    {
        return $plan->delete();
    }
}
