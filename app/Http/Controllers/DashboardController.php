<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Ticket;
use App\Models\Interaction;

class DashboardController extends Controller
{
    public function index()
    {
        // total customers
        $totalCustomers = Customer::count();

        // recent interactions
        $recentInteractions = Interaction::with('customer')
            ->latest()
            ->take(5)
            ->get();

        // pending
        $pendingFollowUps = Ticket::whereIn('status', ['open', 'in progress'])->count();

        // active tickets
        $ticketStatusCounts = Ticket::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('dashboard', compact(
            'totalCustomers',
            'recentInteractions',
            'pendingFollowUps',
            'ticketStatusCounts'
        ));
    }
}
