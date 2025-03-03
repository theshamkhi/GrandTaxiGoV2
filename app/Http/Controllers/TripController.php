<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TripController extends Controller
{
    use AuthorizesRequests;
    public function create(Request $request)
    {
        $driverId = $request->query('driver_id');
        return view('trips.create', compact('driverId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pickup_location' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_time' => 'required|date|after:now',
            'price' => 'required|numeric|min:0',
            'driver_id' => 'nullable|exists:users,id'
        ]);
    
        Trip::create([
            ...$validated,
            'passenger_id' => Auth::id(),
            'status' => 'pending'
        ]);
    
        return redirect()->route('dashboard')->with('success', 'Trip booked successfully!');
    }

    public function show(Trip $trip)
    {
        return view('trips.show', compact('trip'));
    }

    public function edit(Trip $trip)
    {
        return view('trips.edit', compact('trip'));
    }

    public function update(Request $request, Trip $trip)
    {

        $validated = $request->validate([
            'pickup_location' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_time' => 'required|date|after:now',
            'price' => 'required|numeric|min:0'
        ]);

        $trip->update($validated);
        return redirect()->route('trips.show', $trip)->with('success', 'Trip updated!');
    }

    public function updateStatus(Request $request, Trip $trip)
    {
        if (Auth::id() !== $trip->driver_id) {
            abort(403, 'You are not authorized to update this trip.');
        }
    
        $validated = $request->validate([
            'status' => 'required|in:accepted,canceled'
        ]);
    
        $trip->update(['status' => $validated['status']]);
    
        return redirect()->route('dashboard')->with('success', 'Trip status updated!');
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();
        return redirect()->route('dashboard')->with('success', 'Trip cancelled!');
    }
}