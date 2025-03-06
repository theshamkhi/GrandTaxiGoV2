@extends('layout')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Page Title -->
    <h2 class="text-4xl font-extrabold text-center text-gray-900 mb-8">
        Trip Details
    </h2>

    <!-- Trip Card -->
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all hover:shadow-3xl">
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
                        <span class="text-green-600 font-bold">{{ number_format($trip->price, 2) }} MAD</span>
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

    <!-- Review Section -->
    <div class="max-w-4xl mx-auto mt-16">
        <!-- Review Form -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Leave a Review</h3>
            <form action="{{ route('reviews.store', $trip) }}" method="POST">
                @csrf
                <!-- Star Rating -->
                <div class="mb-4">
                    <label for="rating" class="block text-gray-700 font-semibold mb-2">Your Rating:</label>
                    <div class="flex space-x-2" id="rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="text-3xl text-gray-300 cursor-pointer hover:text-yellow-500" data-rating="{{ $i }}">★</span>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="selected-rating" required>
                </div>

                <!-- Comment -->
                <div class="mb-4">
                    <label for="comment" class="block text-gray-700 font-semibold mb-2">Your Comment:</label>
                    <textarea name="comment" id="comment" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Share your experience..."></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white text-lg font-bold rounded-lg shadow-md hover:bg-blue-700">
                    Submit Review
                </button>
            </form>
        </div>

        <!-- Reviews List -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Reviews</h3>
            @foreach ($trip->reviews as $review)
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white text-lg font-bold">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-gray-700 font-semibold">{{ $review->user->name }}</p>
                            <small class="text-gray-500">{{ $review->created_at->format('M d, Y H:i') }}</small>
                        </div>
                    </div>

                    <!-- Star Rating -->
                    <p class="text-gray-700 mt-2">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $review->rating)
                                <span class="text-yellow-500 text-2xl">★</span>
                            @else
                                <span class="text-gray-300 text-2xl">★</span>
                            @endif
                        @endfor
                    </p>

                    <!-- Comment -->
                    @if ($review->comment)
                        <p class="text-gray-700 mt-2">{{ $review->comment }}</p>
                    @endif

                    <!-- Delete Button -->
                    @if(auth()->user()->id === $review->user_id || auth()->user()->isAdmin())
                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="flex justify-end">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none" onclick="return confirm('Are you sure you want to delete this review?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('#rating span');
        const selectedRating = document.getElementById('selected-rating');

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const rating = this.getAttribute('data-rating');
                selectedRating.value = rating;

                // Highlight selected stars
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.remove('text-gray-300');
                        s.classList.add('text-yellow-500');
                    } else {
                        s.classList.remove('text-yellow-500');
                        s.classList.add('text-gray-300');
                    }
                });
            });
        });
    });
</script>
@endsection