<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $existingReview = Review::where('user_id', Auth::id())->where('trip_id', $trip->id)->first();

        if ($existingReview) {
            return redirect()->route('trips.show', $trip)->with('error', 'You have already reviewed this trip.');
        }

        $review = new Review();
        $review->user_id = Auth::id();
        $review->trip_id = $trip->id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return redirect()->route('trips.show', $trip)->with('success', 'Thank you for reviewing this trip!');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted successfully.');
    }
}