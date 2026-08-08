<?php

namespace Modules\Notification\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Notification\Services\NotificationService;

class NotificationApiController extends Controller
{
    public function __construct(protected NotificationService $notificationService) {}

    public function index()
    {
        return response()->json([
            'notifications' => $this->notificationService->getAllNotifications(),
            'activity_logs' => $this->notificationService->getAllActivityLogs(),
            'templates'     => $this->notificationService->getAllTemplates(),
            'settings'      => $this->notificationService->getSettingsForUser(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
            'type'    => 'nullable|string|max:50',
        ]);

        $notification = $this->notificationService->createNotification($validated);
        return response()->json(['message' => 'Notification created successfully', 'data' => $notification], 201);
    }

    public function show($id)
    {
        return response()->json($this->notificationService->findNotificationById($id));
    }

    public function markRead($id)
    {
        $notification = $this->notificationService->findNotificationById($id);
        $updated = $this->notificationService->markAsRead($notification);
        return response()->json(['message' => 'Notification marked as read', 'data' => $updated]);
    }

    public function destroy($id)
    {
        $notification = $this->notificationService->findNotificationById($id);
        $this->notificationService->deleteNotification($notification);
        return response()->json(['message' => 'Notification deleted successfully']);
    }
}
