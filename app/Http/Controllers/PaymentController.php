<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Exception\CardException;
use App\Models\Trip;
use App\Models\Payment;

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
    
            Payment::create([
                'trip_id' => $trip->id,
                'passenger_id' => $trip->passenger_id,
                'driver_id' => $trip->driver_id,
                'amount' => $request->input('price'),
                'currency' => 'MAD',
                'stripe_payment_intent_id' => $charge->id,
                'status' => 'passed',
            ]);

            return redirect()->route('dashboard')->with('success', 'Payment successful! Your trip is confirmed.');

        } catch (CardException $e) {

            $errorMessage = $this->getCardErrorMessage($e->getDeclineCode() ?? $e->getCode());
            return back()->withErrors($errorMessage);

        } catch (\Exception $e) {

            dd($e);
            return back()->withErrors('An unexpected error occurred. Please try again.');
        }
    }

    private function getCardErrorMessage($declineCode)
    {
        switch ($declineCode) {
            case 'stolen_card':
                return 'Your card was declined because it was reported as stolen. Please use a different card.';
            case 'insufficient_funds':
                return 'Your card was declined due to insufficient funds. Please use a different card or add funds to your account.';
            case 'expired_card':
                return 'Your card was declined because it has expired. Please use a different card.';
            case 'card_declined':
                return 'Your card was declined. Please check your card details or use a different card.';
            default:
                return 'Your card was declined. Please try again or use a different card.';
        }
    }
}