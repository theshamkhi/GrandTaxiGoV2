@extends('layout')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="grid grid-cols-1 gap-8">
        <!-- Reservations Section -->
        <div class="overflow-x-auto">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Your Reservations</h2>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Passenger
                            </th>
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
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reservations as $trip)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $trip->passenger->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $trip->pickup_location }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $trip->destination }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $trip->departure_time->format('M d, Y H:i') }}
                            </td>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($trip->status === 'pending')
                                    <div class="flex space-x-2">
                                        <!-- Accept Button -->
                                        <form action="{{ route('trips.update-status', $trip) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="accepted">
                                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 hover:scale-105 transition duration-300">
                                                Accept
                                            </button>
                                        </form>
                            
                                        <!-- Reject Button -->
                                        <form action="{{ route('trips.update-status', $trip) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="canceled">
                                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 hover:scale-105 transition duration-300">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-500">No actions available</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Availability Section -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Your Availability</h2>
            <a href="{{ route('availability.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 hover-scale transition duration-300 mb-6 inline-block">
                Add Availability
            </a>
            <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($availabilities as $availability)
                <li class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-700">
                        <strong>{{ $availability->start_time->format('M d H:i') }} - {{ $availability->end_time->format('M d H:i') }}</strong>
                    </p>
                    <p class="text-xs text-gray-500">Location: {{ $availability->location }}</p>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection