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
        return response()->json($this->notificationService->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'log_type' => 'required|string|max:50',
            'action'   => 'required|string|max:255',
        ]);

        $log = $this->notificationService->create($validated);
        return response()->json(['message' => 'Log recorded successfully', 'data' => $log], 201);
    }

    public function show($id)
    {
        return response()->json($this->notificationService->findById($id));
    }

    public function update(Request $request, $id)
    {
        $log = $this->notificationService->findById($id);
        $validated = $request->validate([
            'log_type' => 'required|string|max:50',
            'action'   => 'required|string|max:255',
        ]);

        $log = $this->notificationService->update($log, $validated);
        return response()->json(['message' => 'Log updated successfully', 'data' => $log]);
    }

    public function destroy($id)
    {
        $log = $this->notificationService->findById($id);
        $this->notificationService->delete($log);
        return response()->json(['message' => 'Log deleted successfully']);
    }
}
