<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Payment;
use App\Mail\ReservationAccepted;
use Illuminate\Support\Facades\Mail;

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
    
        $trip = Trip::create([
            ...$validated,
            'passenger_id' => Auth::id(),
            'status' => 'pending'
        ]);
    
        return redirect()->route('payment.form', ['trip_id' => $trip->id, 'price' => $trip->price])
                         ->with('success', 'Trip booked successfully! Please complete the payment.');
    }

    public function updateStatus(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $trip->update(['status' => $validated['status']]);

        if ($validated['status'] === 'accepted') {
            Mail::to($trip->passenger->email)->send(new ReservationAccepted($trip));
        }

        return redirect()->route('trips.show', $trip->id)->with('success', 'Trip status updated successfully.');
    }

    public function show(Trip $trip)
    {
        $payment = Payment::where('trip_id', $trip->id)->first();

        return view('trips.show', compact('trip', 'payment'));
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

    public function destroy(Trip $trip)
    {
        $trip->delete();
        return redirect()->route('dashboard')->with('success', 'Trip cancelled!');
    }
}