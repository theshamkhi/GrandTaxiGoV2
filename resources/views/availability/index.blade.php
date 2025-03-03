@extends('layout')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Page Title -->
    <h2 class="text-3xl font-bold text-gray-900 mb-6">Your Availability</h2>

    <!-- Add New Availability Button -->
    <a href="{{ route('availability.create') }}" class="inline-block bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 hover-scale transition duration-300 mb-6">
        <i class="fas fa-plus mr-2"></i> Add New Availability
    </a>

    <!-- Availability Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Start Time
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        End Time
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Location
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($availabilities as $availability)
                <tr class="hover:bg-gray-50 transition duration-200">
                    <!-- Start Time -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $availability->start_time->format('M d, Y H:i') }}
                    </td>

                    <!-- End Time -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $availability->end_time->format('M d, Y H:i') }}
                    </td>

                    <!-- Location -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $availability->location }}
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-4">
                            <!-- Edit Button -->
                            <a href="{{ route('availability.edit', $availability) }}" class="text-yellow-600 hover:text-yellow-900 hover-scale transition duration-300">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('availability.destroy', $availability) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 hover-scale transition duration-300" onclick="return confirm('Are you sure you want to delete this availability?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection