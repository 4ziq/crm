<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // =========================
    // Profile (All logged users)
    // =========================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // =========================
    // CUSTOMERS
    // =========================

    // View Customers
    Route::middleware('permission:manage customers')->group(function () {

        Route::get('/customers', [CustomerController::class, 'index'])
            ->name('customers.index');

        // Create Customer (admin only)
        Route::get('/customers/create', [CustomerController::class, 'create'])
            ->name('customers.create');

        Route::post('/customers', [CustomerController::class, 'store'])
            ->name('customers.store');

        // Edit Customer
        Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])
            ->name('customers.edit');

        Route::put('/customers/{customer}', [CustomerController::class, 'update'])
            ->name('customers.update');

        // Delete Customer
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])
            ->name('customers.destroy');
    });

    // =========================
    // INTERACTIONS
    // =========================

    Route::middleware(['role:admin|user'])->group(function () {

        Route::get('/interactions', [InteractionController::class, 'index'])->name('interactions.index');
        Route::get('/interactions/create', [InteractionController::class, 'create'])->name('interactions.create');
        Route::post('/interactions', [InteractionController::class, 'store'])->name('interactions.store');
        Route::get('/interactions/{interaction}/edit', [InteractionController::class, 'edit'])->name('interactions.edit');
        Route::put('/interactions/{interaction}', [InteractionController::class, 'update'])->name('interactions.update');
        Route::delete('/interactions/{interaction}', [InteractionController::class, 'destroy'])->name('interactions.destroy');
    });


    // =========================
    // TICKETS (Support + Admin)
    // =========================

    Route::middleware(['permission:manage tickets'])->group(function () {

        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
        Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
        Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
        Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    });


    // =========================
    // REPORT EXPORT (Admin Only)
    // =========================

    Route::get('/tickets-export-csv', [TicketController::class, 'exportCSV'])
        ->middleware('permission:view reports')
        ->name('tickets.export.csv');

    Route::get('/tickets-export-pdf', [TicketController::class, 'exportPDF'])
        ->middleware('permission:view reports')
        ->name('tickets.export.pdf');
});

require __DIR__ . '/auth.php';
