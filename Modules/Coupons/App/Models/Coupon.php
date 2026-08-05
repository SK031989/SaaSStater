<?php

namespace Modules\Coupons\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'max_uses',
        'used_count',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'value'      => 'decimal:2',
        'max_uses'   => 'integer',
        'used_count' => 'integer',
        'expires_at' => 'date',
    ];
}
