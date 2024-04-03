<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
    <style>
        /* Basic styling for better UI */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: fit-content;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .otp-field {
            display: none;
            margin-top: 24px;
        }

        .otp-field button {
            margin-top: 16px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Reset password</h2>
        <form method="POST" id="forgetPasswordForm">
            <div class="form-group">
                <label for="password">Enter password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="button" id="sendOtpBtn" onclick="setPassword()">setPassword</button>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function setPassword() {
        var data = {
            password: jQuery('#password').val(),
        };
        jQuery.ajax({
            url: 'reset_password_process.php',
            type: 'POST',
            data: data,
            success: function (response) {
                var parsedResponse = JSON.parse(response);
                if (parsedResponse.success) {
                    window.location.href = 'login_club.php';
                } else {
                    alert(parsedResponse.error)
                }
            },
            error: function (xhr, status, error) {
                // Handle low-level AJAX errors (e.g., connection issues)
                console.error('AJAX Error:', status, error);
            }
        });
    }

</script>

</html>