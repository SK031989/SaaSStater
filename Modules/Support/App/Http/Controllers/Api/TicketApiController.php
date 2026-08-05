<?php

namespace Modules\Support\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Support\Services\SupportService;

class TicketApiController extends Controller
{
    public function __construct(protected SupportService $supportService) {}

    public function index()
    {
        return response()->json($this->supportService->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject'  => 'required|string|max:255',
            'priority' => 'required|string',
            'message'  => 'required|string',
        ]);

        $ticket = $this->supportService->create($validated);
        return response()->json(['message' => 'Ticket opened successfully', 'data' => $ticket], 201);
    }

    public function show($id)
    {
        return response()->json($this->supportService->findById($id));
    }

    public function update(Request $request, $id)
    {
        $ticket = $this->supportService->findById($id);
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'status'  => 'required|string',
        ]);

        $ticket = $this->supportService->update($ticket, $validated);
        return response()->json(['message' => 'Ticket updated successfully', 'data' => $ticket]);
    }

    public function destroy($id)
    {
        $ticket = $this->supportService->findById($id);
        $this->supportService->delete($ticket);
        return response()->json(['message' => 'Ticket closed successfully']);
    }
}
