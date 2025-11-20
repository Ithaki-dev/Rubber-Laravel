<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'driver') {
            // Get all reservations for driver's rides
            $reservations = Reservation::whereHas('ride', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with('ride', 'passenger')->latest()->get();
        } else {
            // Get passenger's reservations
            $reservations = $user->reservations()->with('ride.user', 'ride.vehicle')->latest()->get();
        }
        
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ride_id' => 'required|exists:rides,id',
        ]);

        $ride = Ride::findOrFail($request->ride_id);

        // Check if ride has available seats
        if ($ride->availableSeats() <= 0) {
            return back()->with('error', 'No hay espacios disponibles en este ride.');
        }

        // Check if user already has a reservation for this ride
        $existingReservation = Reservation::where('ride_id', $ride->id)
            ->where('passenger_id', Auth::id())
            ->whereIn('status', ['pending', 'accepted'])
            ->first();

        if ($existingReservation) {
            return back()->with('error', 'Ya tienes una reserva para este ride.');
        }

        Reservation::create([
            'ride_id' => $ride->id,
            'passenger_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return redirect()->route('reservations.index')->with('success', 'Reserva creada exitosamente.');
    }

    /**
     * Remove the specified resource from storage (cancel reservation).
     */
    public function destroy(Reservation $reservation)
    {
        // Only passenger can cancel their own reservation
        if ($reservation->passenger_id !== Auth::id()) {
            abort(403);
        }

        // Can only cancel if pending or accepted
        if (!in_array($reservation->status, ['pending', 'accepted'])) {
            return back()->with('error', 'No puedes cancelar esta reserva.');
        }

        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('reservations.index')->with('success', 'Reserva cancelada exitosamente.');
    }

    /**
     * Accept a reservation (driver only).
     */
    public function accept(Reservation $reservation)
    {
        $ride = $reservation->ride;

        // Verify driver owns the ride
        if ($ride->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if ride has available seats
        if ($ride->availableSeats() <= 0) {
            return back()->with('error', 'No hay espacios disponibles.');
        }

        $reservation->update(['status' => 'accepted']);

        return back()->with('success', 'Reserva aceptada exitosamente.');
    }

    /**
     * Reject a reservation (driver only).
     */
    public function reject(Reservation $reservation)
    {
        $ride = $reservation->ride;

        // Verify driver owns the ride
        if ($ride->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->update(['status' => 'rejected']);

        return back()->with('success', 'Reserva rechazada.');
    }
}
