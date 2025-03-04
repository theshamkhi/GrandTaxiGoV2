<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Trip;

class PaymentController extends Controller
{
    public function showPaymentForm($trip_id, $price)
    {
        return view('payment', [
            'trip_id' => $trip_id,
            'price' => $price,
        ]);
    }

    public function processPayment(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    
        try {
            $charge = Charge::create([
                'amount' => $request->input('price') * 100,
                'currency' => 'MAD',
                'source' => $request->input('stripeToken'),
                'description' => 'Trip Booking Payment',
            ]);
    
            $trip = Trip::find($request->input('trip_id'));
            $trip->update(['status' => 'accepted']);
    
            return redirect()->route('dashboard')->with('success', 'Payment successful! Your trip is confirmed.');
    
        } catch (\Exception $e) {
            
            return back()->withErrors('Error! ' . $e->getMessage());
        }
    }
}