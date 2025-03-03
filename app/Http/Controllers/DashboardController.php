<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Trip;
use App\Models\Availability;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'passenger') {

            $trips = Trip::where('passenger_id', $user->id)
                        ->orderBy('departure_time', 'desc')
                        ->paginate(10);
    
            $availableDrivers = User::where('role', 'driver')
                ->whereHas('availabilities', function($query) {
                    $query->where('end_time', '>', now());
                })
                ->with('availabilities')
                ->get();
    
            return view('dashboard.passenger', compact('trips', 'availableDrivers'));
        }
    
        if ($user->role === 'driver') {

            $reservations = Trip::where('driver_id', $user->id)
                              ->orderBy('departure_time')
                              ->with('passenger')
                              ->get();
    
            $availabilities = Availability::where('driver_id', $user->id)
                                        ->orderBy('start_time')
                                        ->get();
    
            return view('dashboard.driver', compact('reservations', 'availabilities'));
        }
    
        return redirect('/');
    }
}