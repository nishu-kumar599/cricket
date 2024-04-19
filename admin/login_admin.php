<?php
session_start();
require ("../csrf_token.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        /* Basic styling for better UI */
        body {
            background-image: url('../images/banner3.png');
            background-size: cover;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
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
            text-align: left;
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"],
        input[type="text"],
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
    <div class="container">
        <h2>Admin Login</h2>
        <form action="login_admin_process.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <input class="form-group" type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($token); ?>">
            <button type="submit">Login</button>
        </form>
        <div class="container" style="box-shadow:none">
            <span class="psw">Forgot <a href="../resetPassword/forget_password.php">password?</a></span>
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