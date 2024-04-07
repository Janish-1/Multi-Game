<?php

namespace App\Http\Controllers\paymentgateway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Transaction\Transaction;

class initiate extends Controller
{
    public function showPaymentForm(Request $request)
    {
        // Extract data from the URL parameters or any other source
        $amount = $request->input('amount');
        $name = $request->input('name'); // Encode the name parameter
        $phone = $request->input('phone');
        $Player_ID = $request->input('Player_ID');
        $email = $request->input('email');

        // Make API request to get the URL with data
        $apiUrl = route('payment.page', [
            'amount' => $amount,
            'name' => $name,
            'phone' => $phone,
            'Player_ID' => $Player_ID,
            'email' => $email,
        ]);

        // Redirect the user to the API URL
        return response()->json([
            "url" => $apiUrl
        ]);
    }

    public function paymentPage(Request $request)
    {
        return view('razorpay-form', $request->all());
    }
}
