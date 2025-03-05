@extends('layout')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Page Title -->
    <h2 class="text-4xl font-extrabold text-center text-gray-900 mb-8">
        Trip Details
    </h2>

    <!-- Trip Card -->
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all">
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
                    <p class="text-lg text-gray-700 mb-4 flex items-center">
                        <i class="fas fa-clock mr-2 text-purple-500"></i>
                        <strong class="mr-2">Departure:</strong>
                        <span class="text-gray-600">{{ $trip->departure_time->format('M d, Y H:i') }}</span>
                    </p>
                    <p class="text-lg text-gray-700 flex items-center">
                        <i class="fas fa-tag mr-2 text-purple-500"></i>
                        <strong class="mr-2">Price:</strong>
                        <span class="text-green-600 font-bold">${{ number_format($trip->price, 2) }}</span>
                    </p>
                </div>

                <!-- Right Column -->
                <div>
                    <p class="text-lg text-gray-700 mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-purple-500"></i>
                        <strong class="mr-2">Status:</strong>
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
                    <p class="text-lg text-gray-700 flex items-center">
                        <i class="fas fa-user mr-2 text-purple-500"></i>
                        <strong class="mr-2">Passenger:</strong>
                        <span class="text-gray-600">{{ auth()->user()->name }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Card Footer -->
        @if(auth()->user()->id === $trip->passenger_id)
            <div class="bg-gray-50 p-6">
                <div class="flex justify-end space-x-4">
                    <!-- Payment Status Logic -->
                    @if(!$payment || $payment->status === 'pending')
                        <!-- Complete Payment Button -->
                        <a href="{{ route('payment.form', ['trip_id' => $trip->id, 'price' => $trip->price]) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:from-green-600 hover:to-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-105">
                            <i class="fas fa-credit-card mr-2"></i>
                            Complete Payment
                        </a>
                    @elseif($payment->status === 'canceled')
                        <!-- Canceled Payment Badge -->
                        <span class="text-gray-500 flex items-center">
                            <i class="fas fa-times-circle mr-2 text-red-500"></i>
                            Payment Canceled
                        </span>
                    @elseif($payment->status === 'passed')
                        <!-- Paid Badge -->
                        <span class="text-gray-500 flex items-center mr-8">
                            <i class="fas fa-check-circle mr-2 text-green-500"></i>
                            Paid
                        </span>
                    @endif

                    <!-- Cancel Button -->
                    @if($trip->status === 'pending')
                        <form action="{{ route('trips.destroy', $trip) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:from-red-600 hover:to-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-105" onclick="return confirm('Are you sure you want to cancel this trip?')">
                                <i class="fas fa-times mr-2"></i>
                                Cancel Trip
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection