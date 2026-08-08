<?php

namespace Modules\Notification\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class UserNotification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'tenant_id',
        'user_id',
        'type',
        'title',
        'message',
        'action_url',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
