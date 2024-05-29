<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment Form</title>
    <!-- Include Bootstrap CSS (Assuming you have it locally or use a CDN) -->
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
            position: relative;
        }

        form {
            position: relative;
            width: 90%;
            max-width: 400px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .loading-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 20px;
            color: #333;
        }
    </style>
</head>

<body>

<form id="paymentForm" action="{{ route('payment.form') }}" method="POST" >
            <!-- CSRF token for Laravel -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <label for="amount">Amount (in paise)</label>
            <input type="number" class="form-control" id="amount" name="amount" required>
        </div>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>

        <div class="form-group">
            <label for="Player_ID">Player ID</label>
            <input type="text" class="form-control" id="Player_ID" name="Player_ID" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <!-- Include Bootstrap JS (Assuming you have it locally or use a CDN) -->
    <script src="path/to/bootstrap.js"></script>
    <script>
        // Function to get query parameter value by name
        function getQueryParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

    document.addEventListener("DOMContentLoaded", function() {
        // Check if the form has already been submitted
        if (!window.location.search.includes("submitted=true")) {
            document.getElementById('amount').value = getQueryParameter('amount');
            document.getElementById('name').value = getQueryParameter('name');
            document.getElementById('email').value = getQueryParameter('email');
            document.getElementById('phone').value = getQueryParameter('phone');
            document.getElementById('Player_ID').value = getQueryParameter('Player_ID');

            // Append a parameter to the URL to indicate form submission
            window.location.search += "&submitted=true";
            
            // Submit the form automatically
            document.getElementById('paymentForm').submit();
        }
    });
    </script>
</body>

</html>
