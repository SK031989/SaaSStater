<?php

namespace Modules\Entitlement\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Subscription\App\Models\SubscriptionPlan;

class Entitlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'feature_key',
        'feature_name',
        'limit_value',
        'unit',
        'is_unlimited',
    ];

    protected $casts = [
        'is_unlimited' => 'boolean',
        'limit_value'  => 'integer',
    ];

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }
}
