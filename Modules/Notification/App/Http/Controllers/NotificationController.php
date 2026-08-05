<?php

namespace Modules\Notification\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Notification\Services\NotificationService;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $notificationService) {}

    public function index()
    {
        $logs = $this->notificationService->getAll();
        return view('Notification::index', compact('logs'));
    }

    public function create()
    {
        return view('Notification::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'log_type'    => 'required|string|max:50',
            'action'      => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->notificationService->create($validated);

        return redirect()->route('notifications.index')->with('success', 'Activity log recorded successfully.');
    }

    public function show($id)
    {
        $log = $this->notificationService->findById($id);
        return view('Notification::show', compact('log'));
    }

    public function edit($id)
    {
        $log = $this->notificationService->findById($id);
        return view('Notification::edit', compact('log'));
    }

    public function update(Request $request, $id)
    {
        $log = $this->notificationService->findById($id);

        $validated = $request->validate([
            'log_type'    => 'required|string|max:50',
            'action'      => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->notificationService->update($log, $validated);

        return redirect()->route('notifications.index')->with('success', 'Activity log updated successfully.');
    }

    public function destroy($id)
    {
        $log = $this->notificationService->findById($id);
        $this->notificationService->delete($log);

        return redirect()->route('notifications.index')->with('success', 'Activity log deleted successfully.');
    }
}
