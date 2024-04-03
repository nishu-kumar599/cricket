<?php
session_start();
// Include the CSRF token management script
require ("../csrf_token.php");

clearstatcache();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Association Admin</title>
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
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        select {
            width: 100%;
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
    </style>
</head>

<body>
    <div class="container">
        <h2>Register Association Admin</h2>
        <form action="verify_otp.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <span id="emailError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="super_admin">Super Admin</option>
                </select>
            </div>
            <input class="form-group" type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($token); ?>">
            <button type="submit" id="registerBtn" onclick="send_otp()">Register</button>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    function send_otp() {
        var email = jQuery('#email').val();
        $.ajax({
            url: '../otp/send_otp.php',
            type: 'POST',
            data: { email: email },
            success: function (response) {
                var parsedResponse = JSON.parse(response);
                if (parsedResponse.error) {
                    alert(parsedResponse.error);
                } else if (parsedResponse.success) {
                    alert(parsedResponse.success);
                }
            },
            error: function (xhr, status, error) {
                // Handle low-level AJAX errors (e.g., connection issues)
                console.error('AJAX Error:', status, error);
            }
        });
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    document.getElementById("email").addEventListener("blur", function () {
        const emailInput = this.value;
        const emailError = document.getElementById("emailError");
        const registerBtn = document.getElementById("registerBtn");

        // Send AJAX request to check if email exists
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "check_email_ajax.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.exists) {
                    emailError.textContent = "Email already exists. Please use a different email.";
                    registerBtn.disabled = true; // Disable register button
                } else {
                    emailError.textContent = ""; // Clear error message
                    registerBtn.disabled = false; // Enable register button
                }
            }
        };
        xhr.send("email=" + encodeURIComponent(emailInput));
    });
</script>

</html>