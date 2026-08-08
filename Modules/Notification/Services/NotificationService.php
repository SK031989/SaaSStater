<?php

namespace Modules\Notification\Services;

use Modules\Notification\App\Models\ActivityLog;
use Modules\Notification\App\Models\UserNotification;
use Modules\Notification\App\Models\NotificationTemplate;
use Modules\Notification\App\Models\NotificationSetting;

class NotificationService
{
    // --- Activity Logs ---
    public function getAllActivityLogs(?string $module = null)
    {
        $query = ActivityLog::with('user')->latest();
        if ($module) {
            $query->where('module', $module);
        }
        return $query->paginate(15);
    }

    public function findActivityLogById(int $id): ActivityLog
    {
        return ActivityLog::with('user')->findOrFail($id);
    }

    public function createActivityLog(array $data): ActivityLog
    {
        return ActivityLog::create([
            'user_id'     => $data['user_id'] ?? auth()->id(),
            'tenant_id'   => $data['tenant_id'] ?? (auth()->user()?->tenant_id ?? 1),
            'module'      => $data['module'] ?? 'System',
            'log_type'    => $data['log_type'] ?? 'info',
            'action'      => $data['action'],
            'description' => $data['description'] ?? null,
            'ip_address'  => request()->ip(),
        ]);
    }

    public static function logModuleAction(string $module, string $action, ?string $description = null, string $logType = 'info', ?int $userId = null, ?int $tenantId = null): ActivityLog
    {
        return ActivityLog::create([
            'user_id'     => $userId ?? auth()->id(),
            'tenant_id'   => $tenantId ?? (auth()->user()?->tenant_id ?? 1),
            'module'      => $module,
            'log_type'    => $logType,
            'action'      => $action,
            'description' => $description,
            'ip_address'  => request()->ip() ?? '127.0.0.1',
        ]);
    }

    public function updateActivityLog(ActivityLog $log, array $data): ActivityLog
    {
        $log->update([
            'module'      => $data['module'] ?? $log->module,
            'log_type'    => $data['log_type'] ?? $log->log_type,
            'action'      => $data['action'] ?? $log->action,
            'description' => $data['description'] ?? $log->description,
        ]);
        return $log;
    }

    public function deleteActivityLog(ActivityLog $log): bool
    {
        return $log->delete();
    }

    // --- User In-App Notifications ---
    public function getAllNotifications()
    {
        return UserNotification::with('user')->latest()->paginate(10);
    }

    public function findNotificationById(int $id): UserNotification
    {
        return UserNotification::with('user')->findOrFail($id);
    }

    public function createNotification(array $data): UserNotification
    {
        return UserNotification::create([
            'tenant_id'  => $data['tenant_id'] ?? (auth()->user()?->tenant_id ?? 1),
            'user_id'    => $data['user_id'] ?? auth()->id(),
            'type'       => $data['type'] ?? 'info',
            'title'      => $data['title'],
            'message'    => $data['message'],
            'action_url' => $data['action_url'] ?? null,
            'is_read'    => false,
        ]);
    }

    public function markAsRead(UserNotification $notification): UserNotification
    {
        $notification->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
        return $notification;
    }

    public function deleteNotification(UserNotification $notification): bool
    {
        return $notification->delete();
    }

    // --- Notification Templates ---
    public function getAllTemplates()
    {
        return NotificationTemplate::latest()->paginate(10);
    }

    public function findTemplateById(int $id): NotificationTemplate
    {
        return NotificationTemplate::findOrFail($id);
    }

    public function createTemplate(array $data): NotificationTemplate
    {
        return NotificationTemplate::create($data);
    }

    public function updateTemplate(NotificationTemplate $template, array $data): NotificationTemplate
    {
        $template->update($data);
        return $template;
    }

    public function deleteTemplate(NotificationTemplate $template): bool
    {
        return $template->delete();
    }

    // --- Notification Settings ---
    public function getSettingsForUser(?int $userId = null)
    {
        $userId = $userId ?? auth()->id() ?? 1;
        return NotificationSetting::firstOrCreate(
            ['user_id' => $userId],
            [
                'tenant_id'            => auth()->user()?->tenant_id ?? 1,
                'email_notifications'  => true,
                'system_notifications' => true,
                'billing_alerts'       => true,
                'security_alerts'      => true,
            ]
        );
    }

    public function updateSettings(NotificationSetting $setting, array $data): NotificationSetting
    {
        $setting->update([
            'email_notifications'  => isset($data['email_notifications']),
            'system_notifications' => isset($data['system_notifications']),
            'billing_alerts'       => isset($data['billing_alerts']),
            'security_alerts'      => isset($data['security_alerts']),
        ]);
        return $setting;
    }
}
