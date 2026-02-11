<?php

namespace App\Http\Controllers;

use App\Models\Interaction;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInteractionRequest;
use App\Http\Requests\UpdateInteractionRequest;

class InteractionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $interactions = Interaction::with('customer')->latest()->paginate(10);
        return view('interaction.index', compact('interactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        return view('interaction.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'type' => 'required|string|max:100',
            'interaction_date' => 'required|date',
            'notes' => 'nullable|string|max:2000',
        ]);

        Interaction::create($validatedData);

        return redirect()->route('interactions.index')->with('success', 'Interaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Interaction $interaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Interaction $interaction)
    {
        $customers = Customer::all();
        return view('interaction.edit', compact('interaction', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInteractionRequest $request, Interaction $interaction)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'type' => 'required|string|max:100',
            'interaction_date' => 'required|date',
            'notes' => 'nullable|string|max:2000',
        ]);

        $interaction->update($validatedData);

        return redirect()->route('interactions.index')->with('success', 'Interaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Interaction $interaction)
    {
        $interaction->delete();
        return redirect()->route('interactions.index')->with('success', 'Interaction deleted successfully.');
    }
}
