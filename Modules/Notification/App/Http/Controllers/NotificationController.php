<?php

namespace Modules\Notification\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Notification\Services\NotificationService;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $notificationService) {}

    public function index(Request $request)
    {
        $tab = $request->get('tab', 'notifications');

        $notifications = $this->notificationService->getAllNotifications();
        $logs          = $this->notificationService->getAllActivityLogs();
        $templates     = $this->notificationService->getAllTemplates();
        $settings      = $this->notificationService->getSettingsForUser();

        return view('Notification::index', compact('tab', 'notifications', 'logs', 'templates', 'settings'));
    }

    public function create()
    {
        return view('Notification::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'message'    => 'required|string',
            'type'       => 'required|string|max:50',
            'action_url' => 'nullable|string|max:255',
        ]);

        $this->notificationService->createNotification($validated);

        return redirect()->route('notifications.index', ['tab' => 'notifications'])->with('success', 'Notification created successfully.');
    }

    public function markAsRead($id)
    {
        $notification = $this->notificationService->findNotificationById($id);
        $this->notificationService->markAsRead($notification);

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function show($id)
    {
        $log = $this->notificationService->findActivityLogById($id);
        return view('Notification::show', compact('log'));
    }

    public function showNotification($id)
    {
        $notification = $this->notificationService->findNotificationById($id);
        return view('Notification::show_notification', compact('notification'));
    }

    public function edit($id)
    {
        $log = $this->notificationService->findActivityLogById($id);
        return view('Notification::edit', compact('log'));
    }

    public function update(Request $request, $id)
    {
        $log = $this->notificationService->findActivityLogById($id);

        $validated = $request->validate([
            'log_type'    => 'required|string|max:50',
            'action'      => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->notificationService->updateActivityLog($log, $validated);

        return redirect()->route('notifications.index', ['tab' => 'logs'])->with('success', 'Activity log updated successfully.');
    }

    public function destroy($id)
    {
        $notification = $this->notificationService->findNotificationById($id);
        $this->notificationService->deleteNotification($notification);

        return redirect()->route('notifications.index', ['tab' => 'notifications'])->with('success', 'Notification deleted successfully.');
    }

    public function updateSettings(Request $request)
    {
        $settings = $this->notificationService->getSettingsForUser();
        $this->notificationService->updateSettings($settings, $request->all());

        return redirect()->route('notifications.index', ['tab' => 'settings'])->with('success', 'Notification settings updated successfully.');
    }
}
