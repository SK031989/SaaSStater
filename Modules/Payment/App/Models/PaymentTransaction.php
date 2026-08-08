<?php

namespace Modules\Payment\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\App\Models\Tenant;
use Modules\Auth\App\Models\User;

class PaymentTransaction extends Model
{
    protected $table = 'payment_transactions';

    protected $fillable = [
        'tenant_id',
        'user_id',
        'gateway_id',
        'transaction_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'metadata',
    ];

    protected $casts = [
        'amount'     => 'decimal:2',
        'metadata'   => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gateway()
    {
        return $this->belongsTo(PaymentGateway::class, 'gateway_id');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeForTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }
}
