<?php

namespace App\Http\Controllers\paymentgateway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Transaction\Transaction;

class initiate extends Controller
{
    public function createpaymentreq(Request $request)
    {
        // Retrieve form input data
        $userid = $request->input('player_id');
        $orderID = $request->input('data-order_id');
        $key = 'rzp_test_eDWrhtXNOjpjcK';
        $amount = $request->input('data-amount');
        $currency = $request->input('data-currency');

        $api = new Api('rzp_test_eDWrhtXNOjpjcK', 'LiS0TAY2lZXeEthCxjnHDoYv'); // Initialize Razorpay API instance

        // Create an order
        $order = $api->order->create(array(
            'amount' => $amount, // Amount in paise (e.g., ₹500)
            'currency' => 'INR',
            'payment_capture' => 1 // Auto capture payments
        ));

        $orderID = $order->id; // Get the order ID

        // Save transaction details to the Transaction table
        $transaction = new Transaction();
        // Assuming userid and other necessary fields need to be populated
        $transaction->userid = $userid; // Assuming userid is available in the request
        $transaction->order_id = $orderID;
        $transaction->amount = $amount;
        $transaction->status = 'Pending'; // Assuming initial status is 'Pending'
        $transaction->trans_date = now(); // Assuming transaction date is current date-time
        $transaction->save();

        // Form HTML string
        $form = '<form action="https://localhost:8000/complete.php" method="POST">
                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                            data-key="' . $key . '"
                            data-amount="' . $amount . '"
                            data-currency="' . $currency . '"
                            data-order_id="' . $orderID . '"
                            data-buttontext="Pay with Razorpay"
                    </script>
                    <input type="hidden" custom="Hidden Element" name="hidden">
                </form>';

        // Return the form HTML
        return response($form);
    }
}
