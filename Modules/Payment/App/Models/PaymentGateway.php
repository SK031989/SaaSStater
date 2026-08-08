<?php

namespace Modules\Payment\App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $table = 'payment_gateways';

    protected $fillable = [
        'name',
        'code',
        'mode',
        'credentials',
        'is_active',
        'is_default',
        'instructions',
    ];

    protected $casts = [
        'credentials' => 'array',
        'is_active'   => 'boolean',
        'is_default'  => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function transactions()
    {
        return $this->hasMany(PaymentTransaction::class, 'gateway_id');
    }
}
