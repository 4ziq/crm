<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Customer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tickets = $this->filterTickets($request)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $users = User::all();

        return view('tickets.index', compact('tickets', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $users = User::all();

        return view('tickets.create', compact('customers', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'assigned_to' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,in_progress,closed',
            'priority' => 'required|in:low,medium,high',
        ]);

        Ticket::create($validated);

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load(['customer', 'assignedTo']);

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $customers = Customer::all();
        $users = User::all();

        return view('tickets.edit', compact('ticket', 'customers', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'priority' => 'required|string',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $ticket->update($validated);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    private function filterTickets($request)
    {
        $query = Ticket::with(['customer', 'assignedTo']);

        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', $search)
                    ->orWhere('description', 'like', $search)
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', $search);
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        return $query;
    }

    public function exportCSV(Request $request)
    {
        return Excel::download(
            new \App\Exports\TicketExport($request),
            'tickets-report.csv'
        );
    }

    public function exportPDF(Request $request)
    {
        $tickets = $this->filterTickets($request)
            ->with(['customer', 'assignedTo'])
            ->get();

        $filters = [
            'search'      => $request->search,
            'status'      => $request->status,
            'priority'    => $request->priority,
            'assigned_to' => $request->assigned_to,
        ];

        $pdf = PDF::loadView('tickets.report_pdf', compact('tickets', 'filters'));

        return $pdf->download('tickets-report.pdf');
    }
}
