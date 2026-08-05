<?php

namespace Modules\Notification\Services;

use Modules\Notification\App\Models\ActivityLog;

class NotificationService
{
    public function getAll()
    {
        return ActivityLog::with('user')->latest()->paginate(10);
    }

    public function findById(int $id): ActivityLog
    {
        return ActivityLog::with('user')->findOrFail($id);
    }

    public function create(array $data): ActivityLog
    {
        return ActivityLog::create([
            'user_id'     => $data['user_id'] ?? auth()->id(),
            'tenant_id'   => $data['tenant_id'] ?? (auth()->user()?->tenant_id ?? 1),
            'log_type'    => $data['log_type'] ?? 'info',
            'action'      => $data['action'],
            'description' => $data['description'] ?? null,
            'ip_address'  => request()->ip(),
        ]);
    }

    public function update(ActivityLog $log, array $data): ActivityLog
    {
        $log->update([
            'log_type'    => $data['log_type'] ?? $log->log_type,
            'action'      => $data['action'] ?? $log->action,
            'description' => $data['description'] ?? $log->description,
        ]);

        return $log;
    }

    public function delete(ActivityLog $log): bool
    {
        return $log->delete();
    }
}
