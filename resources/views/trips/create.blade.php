@extends('layout')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Form Title -->
    <h2 class="text-3xl font-bold text-gray-900 mb-6">Book a Trip</h2>

    <!-- Booking Form -->
    <form method="POST" action="{{ route('trips.store') }}" class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
        @csrf

        <!-- Hidden Driver ID Field -->
        @if(request()->has('driver_id'))
            <input type="hidden" name="driver_id" value="{{ request('driver_id') }}">
        @endif

        <!-- Pickup Location -->
        <div class="mb-6">
            <label for="pickup_location" class="block text-sm font-medium text-gray-700 mb-2">
                Pickup Location
            </label>
            <input type="text" id="pickup_location" name="pickup_location" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300"
                   placeholder="Enter pickup location">
            @error('pickup_location')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Destination -->
        <div class="mb-6">
            <label for="destination" class="block text-sm font-medium text-gray-700 mb-2">
                Destination
            </label>
            <input type="text" id="destination" name="destination" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300"
                   placeholder="Enter destination">
            @error('destination')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Departure Time -->
        <div class="mb-6">
            <label for="departure_time" class="block text-sm font-medium text-gray-700 mb-2">
                Departure Time
            </label>
            <input type="datetime-local" id="departure_time" name="departure_time" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300">
            @error('departure_time')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Price -->
        <div class="mb-6">
            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                Price
            </label>
            <input type="number" step="0.01" id="price" name="price" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300"
                   placeholder="Enter price">
            @error('price')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 hover-scale transition duration-300">
                Book Trip
            </button>
        </div>
    </form>
</div>
@endsection