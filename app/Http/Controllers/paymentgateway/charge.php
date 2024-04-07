<?php
require '../../../../vendor/autoload.php'; // Include Razorpay PHP SDK

use Razorpay\Api\Api;

$api = new Api('rzp_test_eDWrhtXNOjpjcK', 'LiS0TAY2lZXeEthCxjnHDoYv'); // Initialize Razorpay API instance

$payment_id = $_POST['razorpay_payment_id']; // Get payment ID from the form submission

try {
    $payment = $api->payment->fetch($payment_id); // Fetch payment details
    // Handle successful payment
    echo "Payment successful! Payment ID: " . $payment->id;
} catch (Exception $e) {
    // Handle payment failure
    echo "Payment failed: " . $e->getMessage();
}
?>
