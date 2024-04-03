<?php

session_start();

// Include the database connection file
include '../db_connection.php';
// Assuming the AJAX request sends the OTP as 'otp'
$otp = isset ($_POST['otp']) ? $_POST['otp'] : null;

// Validate the OTP
if ($otp == $_SESSION['otp']) {
    echo json_encode(['success' => 'otp successfully match.']);
} else {
    echo json_encode(['error' => 'invalid otp.']);
}
?>