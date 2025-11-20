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
        $query = Ride::with('user', 'vehicle')
            ->where('departure_time', '>', now());

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
        if (in_array($sortBy, ['departure_time', 'origin', 'destination', 'cost'])) {
            $query->orderBy($sortBy);
        }

        $rides = $query->paginate(12);

        return view('public.rides', compact('rides'));
    }

    /**
     * Show ride details.
     */
    public function show(Ride $ride)
    {
        $ride->load('vehicle', 'user');
        return view('public.ride-details', compact('ride'));
    }
}
