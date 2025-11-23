<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display public rides search page.
     */
    public function index(Request $request)
    {
        $query = Ride::with(['vehicle', 'reservations'])
            ->where('departure_time', '>', now())
            ->whereRaw('seats > (SELECT COUNT(*) FROM reservations WHERE reservations.ride_id = rides.id AND reservations.status = "accepted")');

        // Filter by origin
        if ($request->filled('origin')) {
            $query->where('origin', 'like', '%' . $request->origin . '%');
        }

        // Filter by destination
        if ($request->filled('destination')) {
            $query->where('destination', 'like', '%' . $request->destination . '%');
        }

        // Sort
        $sortBy = $request->get('sort', 'departure_time');
        $sortOrder = $request->get('order', 'asc');
        
        if (in_array($sortBy, ['departure_time', 'origin', 'destination', 'cost'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $rides = $query->paginate(12)->withQueryString();

        return view('public.rides', compact('rides'));
    }

    /**
     * Show ride details.
     */
    public function show(Ride $ride)
    {
        $ride->load('vehicle');
        
        // Check if user is authenticated and is a passenger
        $canReserve = auth()->check() && auth()->user()->role === 'passenger';
        
        // Check if user already has a reservation for this ride
        $hasReservation = false;
        if (auth()->check()) {
            $hasReservation = $ride->reservations()
                ->where('passenger_id', auth()->id())
                ->whereIn('status', ['pending', 'accepted'])
                ->exists();
        }
        
        return view('public.ride-details', compact('ride', 'canReserve', 'hasReservation'));
    }
}
