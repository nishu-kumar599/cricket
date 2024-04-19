s
<?php
session_start();
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
require '../db_connection.php';

if (isset($_POST['code']) && $_POST['code'] === 'PAYMENT_SUCCESS') {
    if (isset($_COOKIE['FormData'])) {
        $formData = json_decode($_COOKIE['FormData'], true);
        $csrf_token = $formData['csrf_token'] ?? '';
        if (!empty($csrf_token)) {
            // Retrieve data from registration form
            $playerid = $formData['player_id'];
            $name = $formData['name'];
            $age = $formData['age'];
            $dob = $formData['dob'];
            $mobile = $formData['mobile'];
            $email = $formData['email'];
            $password = $formData['password'];
            $type = $formData['type'];
            $club_id = $formData['club'];
            $state = $formData['state'];
            $city = $formData['city'];
            $address = $formData['address'];
            $paymentStatus = $_POST['code'];
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Declare variables with default values before the SQL statement
            $runs = 0;
            $wicket = 0;
            $catches = 0;
            $no_of_six = 0;
            $no_of_four = 0;
            $five_wicket_hall = 0;
            $no_of_hundred = 0;
            $no_of_fifty = 0;
            $no_of_stumping = 0;

            // Check if club_id is '0' and set it to NULL if needed
            if ($club_id == '0') {
                $club_id = NULL;
            }

            // Prepare SQL statement
            $sql = "INSERT INTO players (player_id, name, age, dob, mobile, email, password, type, club_id, state, city, address, payment_status, runs, wicket, catches, no_of_six, no_of_four, five_wicket_hall, no_of_hundred, no_of_fifty, no_of_stumping) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Proceed with your existing code to prepare, bind, and execute the statement

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssissssssisssiiiiiiiii", $playerid, $name, $age, $dob, $mobile, $email, $hashed_password, $type, $club_id, $state, $city, $address, $paymentStatus, $runs, $wicket, $catches, $no_of_six, $no_of_four, $five_wicket_hall, $no_of_hundred, $no_of_fifty, $no_of_stumping);

                // Execute the SQL statement
                if ($stmt->execute()) {
                    setcookie('FormData', '', time() - 3600, '/');
                    setcookie('playerid', '', time() - 3600, '/');
                    // Registration successful, redirect to player dashboard or wherever you want
                    header("Location: login_player.php");
                    exit;
                } else {
                    // Registration failed
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error: Could not prepare SQL statement.";
            }
        } else {
            echo 'Token invalid. Operation not allowed.<br>';
        }
    } else {
        // Handle case where form data is not available
        echo "Form data not found.";
    }
} else {
    // Payment was not successful, handle it accordingly
    echo "Payment was not successful.";
}

// Close the database connection
clearstatcache();
$conn->close();
?>