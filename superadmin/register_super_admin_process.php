<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
include '../db_connection.php';

$otp = isset($_POST['otp']) ? $_POST['otp'] : null;
if ($otp == $_SESSION['otp']) {
    $formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : null;

    if ($formData) {
        $username = isset($formData['username']) ? $formData['username'] : null;
        $email = isset($formData['email']) ? $formData['email'] : null;
        $password = isset($formData['password']) ? $formData['password'] : null;

        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement to insert data into super_admins table
        $sql = "INSERT INTO super_admins (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        // Execute the SQL statement
        if ($stmt->execute()) {
            echo json_encode(['success' => 'Registration successful.']);
            exit;

        } else {
            echo json_encode(['error' => 'Form data not found.']);
        }
    }
} else {
    echo json_encode(['error' => 'Invalid OTP.']);
    exit();
}

// Close the database connection
$stmt->close();
$conn->close();
?>