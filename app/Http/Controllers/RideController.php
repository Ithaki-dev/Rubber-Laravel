<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rides = Auth::user()->rides()->with('vehicle', 'reservations')->latest()->get();
        return view('rides.index', compact('rides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicles = Auth::user()->vehicles;
        
        if ($vehicles->count() === 0) {
            return redirect()->route('vehicles.create')->with('error', 'Debes registrar un vehículo antes de crear un ride.');
        }
        
        return view('rides.create', compact('vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'name' => 'required|string|max:255',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_time' => 'required|date|after:now',
            'cost' => 'required|numeric|min:0',
            'seats' => 'required|integer|min:1|max:50',
        ]);

        // Verify vehicle belongs to user
        $vehicle = Vehicle::where('id', $request->vehicle_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        Auth::user()->rides()->create([
            'vehicle_id' => $request->vehicle_id,
            'name' => $request->name,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'departure_time' => $request->departure_time,
            'cost' => $request->cost,
            'seats' => $request->seats,
        ]);

        return redirect()->route('rides.index')->with('success', 'Ride creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ride $ride)
    {
        $this->authorize('view', $ride);
        $ride->load('vehicle', 'reservations.passenger');
        return view('rides.show', compact('ride'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ride $ride)
    {
        $this->authorize('update', $ride);
        $vehicles = Auth::user()->vehicles;
        return view('rides.edit', compact('ride', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ride $ride)
    {
        $this->authorize('update', $ride);

        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'name' => 'required|string|max:255',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_time' => 'required|date|after:now',
            'cost' => 'required|numeric|min:0',
            'seats' => 'required|integer|min:1|max:50',
        ]);

        // Verify vehicle belongs to user
        $vehicle = Vehicle::where('id', $request->vehicle_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $ride->update([
            'vehicle_id' => $request->vehicle_id,
            'name' => $request->name,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'departure_time' => $request->departure_time,
            'cost' => $request->cost,
            'seats' => $request->seats,
        ]);

        return redirect()->route('rides.index')->with('success', 'Ride actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ride $ride)
    {
        $this->authorize('delete', $ride);
        $ride->delete();
        return redirect()->route('rides.index')->with('success', 'Ride eliminado exitosamente.');
    }
}
