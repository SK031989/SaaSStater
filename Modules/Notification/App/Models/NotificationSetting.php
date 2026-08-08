<?php

namespace Modules\Notification\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class NotificationSetting extends Model
{
    use HasFactory;

    protected $table = 'notification_settings';

    protected $fillable = [
        'tenant_id',
        'user_id',
        'email_notifications',
        'system_notifications',
        'billing_alerts',
        'security_alerts',
    ];

    protected $casts = [
        'email_notifications'  => 'boolean',
        'system_notifications' => 'boolean',
        'billing_alerts'       => 'boolean',
        'security_alerts'      => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
