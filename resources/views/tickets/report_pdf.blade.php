<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Tickets Report </title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f3f4f6;
        }

        h2 {
            margin-bottom: 0;
        }

        .small {
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>

    <h2>Tickets Report</h2>
    <p style="font-size: 11px; color: #666;">
        Generated on {{ now()->format('M d, Y H:i') }}
    </p>

    {{-- Show Active Filters --}}
    @if (array_filter($filters))
        <div style="margin-top: 10px; padding: 8px; background: #f3f4f6;">
            <strong>Applied Filters:</strong><br>

            @if ($filters['search'])
                Search: "{{ $filters['search'] }}"<br>
            @endif

            @if ($filters['status'])
                Status: {{ ucfirst($filters['status']) }}<br>
            @endif

            @if ($filters['priority'])
                Priority: {{ ucfirst($filters['priority']) }}<br>
            @endif

            @if ($filters['assigned_to'])
                Assigned To:
                {{ \App\Models\User::find($filters['assigned_to'])->name ?? '-' }}
                <br>
            @endif
        </div>
    @endif

    <p><strong>Total Tickets:</strong> {{ $tickets->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Title</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Assigned To</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->customer->name }}</td>
                    <td>{{ $ticket->title }}</td>
                    <td>{{ $ticket->status }}</td>
                    <td>{{ $ticket->priority }}</td>
                    <td>{{ $ticket->assignedTo->name ?? 'Unassigned' }}</td>
                    <td>{{ $ticket->created_at->format('M d, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
