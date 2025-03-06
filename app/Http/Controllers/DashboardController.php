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
    
        if ($user->role === 'admin') {

            $users = User::whereIn('role', ['driver', 'passenger'])->get();

            $trips = Trip::with(['passenger', 'driver'])
                         ->orderBy('departure_time', 'desc')
                         ->get();

            $totalTrips = $trips->count();
            $canceledTrips = $trips->where('status', 'canceled')->count();
            $completedTrips = $trips->where('status', 'completed')->count();
            $revenue = $trips->where('status', 'completed')->sum('price');

            $availabilities = Availability::with('driver')
                                         ->orderBy('start_time', 'desc')
                                         ->get();

            return view('dashboard.admin', compact(
                'users',
                'trips',
                'totalTrips',
                'canceledTrips',
                'completedTrips',
                'revenue',
                'availabilities'
            ));
        }
    
        return redirect('/');
    }
}