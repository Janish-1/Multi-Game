<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        .container h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .form-group button:disabled {
            background-color: #aaa;
            cursor: not-allowed;
        }
        .message {
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Withdraw Form</h2>
        <div class="form-group">
            <label for="userid">User ID</label>
            <input type="text" id="userid" required>
        </div>
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" id="amount" required>
        </div>
        <div class="form-group">
            <label for="payment_method">Payment Method</label>
            <input type="text" id="payment_method" required>
        </div>
        <div class="form-group">
            <label for="wallet_number">Wallet Number</label>
            <input type="text" id="wallet_number" required>
        </div>
        <div class="form-group">
            <label for="bank_name">Bank Name</label>
            <input type="text" id="bank_name" required>
        </div>
        <div class="form-group">
            <label for="account_number">Account Number</label>
            <input type="text" id="account_number" required>
        </div>
        <div class="form-group">
            <label for="ifsc_code">IFSC Code</label>
            <input type="text" id="ifsc_code" required>
        </div>
        <div class="form-group">
            <button id="submitBtn" onclick="submitForm()">Submit</button>
        </div>
        <div class="message" id="message"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const urlParams = new URLSearchParams(window.location.search);
            const userId = urlParams.get('userid');
            if (userId) {
                document.getElementById('userid').value = userId;
            }
        });

        async function submitForm() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            const messageDiv = document.getElementById('message');
            messageDiv.innerHTML = '';

            const data = {
                userid: document.getElementById('userid').value,
                amount: parseFloat(document.getElementById('amount').value),
                payment_method: document.getElementById('payment_method').value,
                wallet_number: document.getElementById('wallet_number').value,
                bank_name: document.getElementById('bank_name').value,
                account_number: document.getElementById('account_number').value,
                ifsc_code: document.getElementById('ifsc_code').value,
            };

            try {
                const response = await fetch('/createwithdraw', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                });

                const result = await response.json();

                if (response.ok) {
                    messageDiv.innerHTML = `<p style="color: green;">${result.message}</p>`;
                } else {
                    messageDiv.innerHTML = `<p style="color: red;">${result.message}: ${JSON.stringify(result.errors)}</p>`;
                }
            } catch (error) {
                messageDiv.innerHTML = `<p style="color: red;">Error: ${error.message}</p>`;
            }

            submitBtn.disabled = false;
        }
    </script>
</body>
</html>
