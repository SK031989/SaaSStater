<?php

namespace Modules\Support\Services;

use Modules\Support\App\Models\Ticket;

class SupportService
{
    public function getAll()
    {
        return Ticket::with(['user', 'tenant'])->latest()->paginate(10);
    }

    public function findById(int $id): Ticket
    {
        return Ticket::with(['user', 'tenant'])->findOrFail($id);
    }

    public function create(array $data): Ticket
    {
        return Ticket::create([
            'tenant_id'     => $data['tenant_id'] ?? 1,
            'user_id'       => $data['user_id'] ?? auth()->id(),
            'ticket_number' => 'TICK-' . rand(100000, 999999),
            'subject'       => $data['subject'],
            'priority'      => $data['priority'] ?? 'medium',
            'status'        => $data['status'] ?? 'open',
            'message'       => $data['message'],
        ]);
    }

    public function update(Ticket $ticket, array $data): Ticket
    {
        $ticket->update([
            'subject'  => $data['subject'] ?? $ticket->subject,
            'priority' => $data['priority'] ?? $ticket->priority,
            'status'   => $data['status'] ?? $ticket->status,
            'message'  => $data['message'] ?? $ticket->message,
        ]);

        return $ticket;
    }

    public function delete(Ticket $ticket): bool
    {
        return $ticket->delete();
    }
}
