<?php

// Start the session 
session_start();
// Include the CSRF token management script
require ("../csrf_token.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Player Login</title>

    <style>
        /* Basic styling for better UI */
        body {
            background-image: url('../images/banner3.png');
            background-size: cover;
        }

        .container {
            width: 500px;
            background-color: rgba(255, 255, 255, 1);
            /* Semi-transparent background */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 50px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"],
        input[type="password"] {
            width: -webkit-fill-available;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
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

        .error-message {
            color: #dc3545;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="../index.php">
            <img src="../images/new/logo.png" width="50" height="50" class="d-inline-block align-top" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="../index.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../club/register_club.php">Register as Club</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../player/register_player.php">Register as Player </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../club/login_club.php">Club Login </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../player/login_player.php">Player Login </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div style="text-align: center;"><img width="35px" src="../images/new/logo.png" alt=""></div>
        <h2>Login to your player account</h2>
        <form action="login_player_process.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($token); ?>">
            <button type="submit">Login</button>
        </form>
        <div class="container" style="box-shadow:none;text-align:center">
            <span class="psw">Forgot <a href="forget_password.php">password?</a></span>
        </div>
        <?php
        // Display error message if login attempt failed
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo '<div class="error-message">Invalid username or password. Please try again.</div>';
        }
        ?>
    </div>
</body>

</html>