<?php

namespace Modules\Addons\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Addon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'price_monthly',
        'status',
        'description',
    ];

    protected $casts = [
        'price_monthly' => 'decimal:2',
    ];
}
