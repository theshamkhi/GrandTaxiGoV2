<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class AvailabilityController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $availabilities = Availability::where('driver_id', Auth::id())
                                    ->orderBy('start_time')
                                    ->get();
        return view('availability.index', compact('availabilities'));
    }

    public function create()
    {
        return view('availability.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255'
        ]);

        Availability::create([
            ...$validated,
            'driver_id' => Auth::id()
        ]);

        return redirect()->route('availability.index')->with('success', 'Availability set!');
    }

    public function edit(Availability $availability)
    {
        return view('availability.edit', compact('availability'));
    }

    public function update(Request $request, Availability $availability)
    {
        $validated = $request->validate([
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255'
        ]);

        $availability->update($validated);
        return redirect()->route('availability.index')->with('success', 'Availability updated!');
    }

    public function destroy(Availability $availability)
    {
        $availability->delete();
        return redirect()->route('availability.index')->with('success', 'Availability removed!');
    }
}