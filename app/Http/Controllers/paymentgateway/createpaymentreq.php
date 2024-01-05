<?php
require '../../../../vendor/autoload.php'; // Include Razorpay PHP SDK

use Razorpay\Api\Api;

$api = new Api('rzp_test_eDWrhtXNOjpjcK', 'LiS0TAY2lZXeEthCxjnHDoYv'); // Initialize Razorpay API instance

// Create an order
$order = $api->order->create(array(
    'amount' => 50000, // Amount in paise (e.g., ₹500)
    'currency' => 'INR',
    'payment_capture' => 1 // Auto capture payments
));

$orderID = $order->id; // Get the order ID

// Display payment button with order ID
?>

<form action="http://127.0.0.1:8000/paymentsuccess" method="POST">
    <script src="https://checkout.razorpay.com/v1/checkout.js"
        data-key="rzp_test_eDWrhtXNOjpjcK"
        data-amount="50000" 
        data-currency="INR"
        data-order_id="<?php echo $orderID; ?>"
        data-buttontext="Pay with Razorpay"
        data-name="Your Company Name"
        data-description="Purchase Description"
        data-image="https://your-company-logo-url.com/your_logo.png"
        data-prefill.name="Your Customer Name"
        data-prefill.email="customer@example.com"
        data-theme.color="#F37254"
    ></script>
    <input type="hidden" custom="Hidden Element" name="hidden">
</form>
