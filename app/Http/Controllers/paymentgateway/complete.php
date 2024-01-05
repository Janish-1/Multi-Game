<?php

namespace App\Http\Controllers\paymentgateway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Transaction\Transaction;
use Throwable; // Import Throwable

class complete extends Controller
{
    public function completePay(Request $request)
    {
        $api = new Api('rzp_test_eDWrhtXNOjpjcK', 'LiS0TAY2lZXeEthCxjnHDoYv'); // Initialize Razorpay API instance

        $payment_id = $request->input('razorpay_payment_id'); // Get payment ID from the form submission

        try {
            $payment = $api->payment->fetch($payment_id); // Fetch payment details

            // Handle successful payment
            $transaction = Transaction::where('txn_id', $payment->id)->first(); // Find the transaction by payment ID

            if ($transaction) {
                // Update transaction status based on payment status
                $transaction->status = $payment->status; // Assuming payment status is directly mapped to the transaction status
                $transaction->save();
                
                return "Payment successful! Transaction updated: " . $transaction->id;
            } else {
                return "Transaction not found for payment ID: " . $payment->id;
            }
        } catch (Throwable $e) {
            // Handle payment failure
            return "Payment failed: " . $e->getMessage();
        }
    }
}
