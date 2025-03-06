@extends('layout')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Your Trips Section -->
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Your Trips</h2>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pickup Location
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Destination
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Departure Time
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($trips as $trip)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <!-- Pickup Location -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $trip->pickup_location }}
                        </td>
            
                        <!-- Destination -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $trip->destination }}
                        </td>
            
                        <!-- Departure Time -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $trip->departure_time->format('M d, Y H:i') }}
                        </td>
            
                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{
                                [
                                    'pending' => 'yellow-100 text-yellow-800',
                                    'accepted' => 'green-100 text-green-800',
                                    'canceled' => 'red-100 text-red-800',
                                    'completed' => 'blue-100 text-blue-800'
                                ][$trip->status]
                            }}">
                                {{ ucfirst($trip->status) }}
                            </span>
                        </td>
            
                        <!-- Price -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($trip->price, 2) }} MAD
                        </td>
            
                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('trips.show', $trip) }}" class="text-indigo-600 hover:text-indigo-900 hover-scale transition duration-300">
                                View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50">
                {{ $trips->links() }}
            </div>
        </div>

        <!-- Available Drivers Section -->
        <h2 class="text-3xl font-bold text-gray-800 mt-12 mb-6">Available Drivers</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($availableDrivers as $driver)
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <!-- Driver Profile -->
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="{{ asset('storage/' . $driver->profile_photo) }}" alt="{{ $driver->name }}" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <h5 class="text-lg font-semibold text-gray-800">{{ $driver->name }}</h5>
                            <p class="text-sm text-gray-500">{{ $driver->phone }}</p>
                        </div>
                    </div>
                    <!-- Availability -->
                    <div class="space-y-2">
                        <p class="text-sm text-gray-700">
                            <strong>Availability:</strong>
                        </p>
                        @foreach($driver->availabilities as $availability)
                        <div class="text-sm text-gray-600">
                            <p>From: {{ $availability->start_time->format('M d, Y H:i') }}</p>
                            <p>To: {{ $availability->end_time->format('M d, Y H:i') }}</p>
                            <p class="text-sm text-gray-600">Location: {{ $availability->location }}</p>
                        </div>
                        @endforeach
                    </div>
                    <!-- Book Button -->
                    <div class="mt-6">
                        <a href="{{ route('trips.create', ['driver_id' => $driver->id]) }}" class="w-full block text-center bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 hover-scale transition duration-300">
                            Book This Driver
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection