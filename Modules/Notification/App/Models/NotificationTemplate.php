<?php

namespace Modules\Notification\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationTemplate extends Model
{
    use HasFactory;

    protected $table = 'notification_templates';

    protected $fillable = [
        'code',
        'title',
        'subject',
        'body',
        'channel',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
