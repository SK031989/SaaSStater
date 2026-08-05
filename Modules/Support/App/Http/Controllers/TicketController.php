<?php

namespace Modules\Support\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Support\Services\SupportService;
use Modules\Tenant\App\Models\Tenant;

class TicketController extends Controller
{
    public function __construct(protected SupportService $supportService) {}

    public function index()
    {
        $tickets = $this->supportService->getAll();
        return view('Support::index', compact('tickets'));
    }

    public function create()
    {
        $tenants = Tenant::all();
        return view('Support::create', compact('tenants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'nullable|integer',
            'subject'   => 'required|string|max:255',
            'priority'  => 'required|string|in:low,medium,high,urgent',
            'status'    => 'required|string|in:open,in_progress,resolved,closed',
            'message'   => 'required|string',
        ]);

        $this->supportService->create($validated);

        return redirect()->route('tickets.index')->with('success', 'Support ticket opened successfully.');
    }

    public function show($id)
    {
        $ticket = $this->supportService->findById($id);
        return view('Support::show', compact('ticket'));
    }

    public function edit($id)
    {
        $ticket = $this->supportService->findById($id);
        $tenants = Tenant::all();
        return view('Support::edit', compact('ticket', 'tenants'));
    }

    public function update(Request $request, $id)
    {
        $ticket = $this->supportService->findById($id);

        $validated = $request->validate([
            'subject'  => 'required|string|max:255',
            'priority' => 'required|string|in:low,medium,high,urgent',
            'status'   => 'required|string|in:open,in_progress,resolved,closed',
            'message'  => 'required|string',
        ]);

        $this->supportService->update($ticket, $validated);

        return redirect()->route('tickets.index')->with('success', 'Support ticket updated successfully.');
    }

    public function destroy($id)
    {
        $ticket = $this->supportService->findById($id);
        $this->supportService->delete($ticket);

        return redirect()->route('tickets.index')->with('success', 'Support ticket closed and deleted successfully.');
    }
}
