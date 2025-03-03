@extends('layout')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Page Title -->
    <h2 class="text-4xl font-extrabold text-center text-gray-900 mb-8">
        Trip Details
    </h2>

    <!-- Trip Card -->
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-2xl overflow-hidden">
        <!-- Card Header -->
        <div class="gradient-bg p-6">
            <h3 class="text-2xl font-semibold text-white flex items-center">
                <i class="fas fa-route mr-3"></i>
                {{ $trip->pickup_location }} to {{ $trip->destination }}
            </h3>
        </div>

        <!-- Card Body -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div>
                    <p class="text-lg text-gray-700 mb-4">
                        <i class="fas fa-clock mr-2 text-purple-500"></i>
                        <strong>Departure:</strong>
                        <span class="text-gray-600">{{ $trip->departure_time->format('M d, Y H:i') }}</span>
                    </p>
                    <p class="text-lg text-gray-700">
                        <i class="fas fa-tag mr-2 text-purple-500"></i>
                        <strong>Price:</strong>
                        <span class="text-green-600 font-bold">${{ number_format($trip->price, 2) }}</span>
                    </p>
                </div>

                <!-- Right Column -->
                <div>
                    <p class="text-lg text-gray-700 mb-4">
                        <i class="fas fa-info-circle mr-2 text-purple-500"></i>
                        <strong>Status:</strong>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-{{
                            [
                                'pending' => 'yellow-100 text-yellow-800',
                                'accepted' => 'green-100 text-green-800',
                                'canceled' => 'red-100 text-red-800',
                                'completed' => 'blue-100 text-blue-800'
                            ][$trip->status]
                        }}">
                            {{ ucfirst($trip->status) }}
                        </span>
                    </p>
                    <p class="text-lg text-gray-700">
                        <i class="fas fa-user mr-2 text-purple-500"></i>
                        <strong>Passenger:</strong>
                        <span class="text-gray-600">{{ auth()->user()->name }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Card Footer (Conditional Buttons) -->
        @if(auth()->user()->id === $trip->passenger_id)
            <div class="bg-gray-50 p-6">
                <div class="flex justify-end space-x-4">
                    <!-- Edit Button -->
                    <a href="#" class="bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600 hover-scale transition duration-300 flex items-center">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Trip
                    </a>

                    <!-- Cancel Button -->
                    <form action="{{ route('trips.destroy', $trip) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 hover-scale transition duration-300 flex items-center" onclick="return confirm('Are you sure you want to cancel this trip?')">
                            <i class="fas fa-times mr-2"></i>
                            Cancel Trip
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection