<?php

namespace App\Exports;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TicketExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Ticket::with(['customer', 'assignedTo']);

        if ($this->request->filled('search')) {
            $search = '%' . $this->request->search . '%';

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', $search)
                    ->orWhere('description', 'like', $search)
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', $search);
                    });
            });
        }

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        if ($this->request->filled('priority')) {
            $query->where('priority', $this->request->priority);
        }

        if ($this->request->filled('assigned_to')) {
            $query->where('assigned_to', $this->request->assigned_to);
        }

        return $query->get()->map(function ($ticket) {
            return [
                'ID' => $ticket->id,
                'Customer' => $ticket->customer->name ?? '',
                'Title' => $ticket->title,
                'Description' => $ticket->description,
                'Status' => $ticket->status,
                'Priority' => $ticket->priority,
                'Assigned To' => $ticket->assignedTo->name ?? 'Unassigned',
                'Created At' => $ticket->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Customer',
            'Title',
            'Description',
            'Status',
            'Priority',
            'Assigned To',
            'Created At',
        ];
    }
}
