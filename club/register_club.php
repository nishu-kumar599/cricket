<?php
session_start();
// Include the CSRF token management script
require ("../csrf_token.php");

// Generate unique player ID
$clubid = "BCLUB" . time() . mt_rand(100, 999);
$_SESSION['clubid'] = $clubid;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Club</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
 body {
    background: url(../images/banner3.png) no-repeat;
    background-size: cover;
}
        /* Additional custom styling */
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .text-danger {
            color: #dc3545;
        }
    </style>
</head>

<body>
    <!-- Image and text -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="../index.php">
    <img src="../images/new/logo.png" width="50" height="50" class="d-inline-block align-top" alt="">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="../index.php">Home</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Register as Club</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="../player/register_player.php">Register as Player </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./login_club.php">Club Login </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="../player/login_player.php">Player Login </a>
      </li>
    </ul>
  </div>

</nav>
    <div class="container">
        <h2 class="text-center mb-4">Register Club</h2>
        <form id="registrationForm" method="POST">
            <!-- Hidden input for player_id -->
            <input type="hidden" id="clubid" name="clubid" value="<?php echo $clubid; ?>">
            <div class="form-group">
                <label for="name">Club Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
                <span id="emailError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="pan_number">Pan Number:</label>
                <input type="text" id="pan_number" name="pan_number" class="form-control">
            </div>
            <div class="form-group">
                <label for="aadhar_number">Aadhar Number:</label>
                <input type="text" id="aadhar_number" name="aadhar_number" class="form-control">
            </div>
            <div class="form-group">
                <label for="director_name">Club Director Name:</label>
                <input type="text" id="director_name" name="director_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="secretary_name">Club Secretary Name:</label>
                <input type="text" id="secretary_name" name="secretary_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="text" id="contact_number" name="contact_number" class="form-control">
            </div>
            <input class="form-group" type="hidden" id="csrf_token" name="csrf_token"
                value="<?php echo htmlspecialchars($token); ?>">
            <button type="submit" id="registerBtn" class="btn btn-primary btn-block"
                onclick="payment()">Register</button>
        </form>
    </div>


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
        // Bind click event to your register button
        $('#registerBtn').click(function (e) {
            e.preventDefault(); // Prevent default form submission
            var FormData = {
                 csrf_token: $('#csrf_token').val(),
                clubid: $('#clubid').val(),
                name: $('#name').val(),
                location: $('#location').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                pan_number: $('#pan_number').val(),
                aadhar_number: $('#aadhar_number').val(),
                director_name: $('#director_name').val(),
                secretary_name: $('#secretary_name').val(),
                contact_number: $('#contact_number').val(),
            };

            // Send form data to paymentgateway.php using AJAX
            $.ajax({
                url: 'paymentgateway.php',
                type: 'POST',
                data: FormData,
                success: function (response) {
                    // Parse JSON response
                    var jsonResponse = JSON.parse(response);

                    if (jsonResponse.success === '1') {
                        // Redirect to the payment URL on success
                        window.location.href = jsonResponse.payUrl;
                    } else {
                        alert('Payment initiation failed: ' + jsonResponse.message);
                    }
                },
                error: function () {
                    alert('Payment initiation failed. Please try again.');
                }
            });
        });


    </script>
</body>

</html>