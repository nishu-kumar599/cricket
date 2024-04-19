<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>forget password</title>
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
            width: 500px;
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
            width: -webkit-fill-available;
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

        body {
            background-image: url('../images/banner3.png');
            background-size: cover;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center mb-4">Forget Password</h2>
        <form id="forgetPasswordForm">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" class="form-control" name="email" required>
                <div id="emailError" class="text-danger"></div>
            </div>
            <button type="button" id="sendOtpBtn" class="btn btn-primary" onclick="sendOTP()">Send OTP</button>
            <div class="otp-field form-group d-none">
                <label for="otp">OTP:</label>
                <input type="text" id="otp" class="form-control">
                <button type="button" class="btn btn-success mt-3" onclick="submit_otp()">Verify OTP</button>
            </div>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        document.getElementById("email").addEventListener("blur", function () {
            const emailInput = this.value.trim();
            const emailError = document.getElementById("emailError");
            const sendOtpBtn = document.getElementById("sendOtpBtn");
            sendOtpBtn.disabled = true; // Disable the button by default

            if (emailInput === '') {
                emailError.textContent = "Please enter an email address.";
                return;
            }

            // Reset the error message while checking
            emailError.textContent = "";

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../admin/check_email_ajax.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.exists) {
                        emailError.textContent = ""; // Clear error message
                        sendOtpBtn.disabled = false; // Enable button if email exists
                    } else {
                        emailError.textContent = "Email doesn't exist. Please use a different email.";
                    }
                } else {
                    // Handle HTTP error (status code not 200)
                    emailError.textContent = "Failed to verify email. Please try again.";
                }
            };
            xhr.onerror = function () {
                // Handle network error
                emailError.textContent = "Network error. Please try again.";
            };
            xhr.send("email=" + encodeURIComponent(emailInput));
        });

        function sendOTP(event) {
            // Check if 'event' is defined and prevent the default action if so
            if (event && event.preventDefault) {
                event.preventDefault();
            }

            const email = document.getElementById('email').value.trim();
            if (!email) {
                alert('Please fill in the email field.');
                return;
            }

            // Proceed with sending OTP
            $.ajax({
                url: '../otp/send_otp.php',
                type: 'POST',
                data: { email: email },
                success: function (response) {
                    if (response.success) {
                        alert(response.success)
                    } else {
                        console.log(response.error);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    alert("An error occurred while sending OTP. Please try again.");
                }
            });
            if (sendOtpBtn.disabled == false) {
                // Hide the Send OTP button
                jQuery('#sendOtpBtn').hide();

                // Show the OTP verification field
                jQuery('.otp-field').show();
            }

        }

        function submit_otp(event) {
            if (event) event.preventDefault();
            const otp = $('#otp').val();
            const email = $('#email').val();

            $.ajax({
                url: 'forget_password_process.php',
                type: 'POST',
                data: { otp: otp, email: email },
                success: function (response) {
                    let parsedResponse = JSON.parse(response);
                    if (parsedResponse.success) {
                        window.location.href = 'reset_Password.php'; // Redirect on success
                    } else {
                        alert(parsedResponse.error || "Invalid OTP. Please try again.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    alert("An error occurred while verifying OTP.");
                }
            });
        }
    </script>

</body>

</html>