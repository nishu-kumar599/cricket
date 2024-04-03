<?php

session_start();

// Include the database connection file
include '../db_connection.php';

// Assuming the AJAX request sends the OTP as 'otp'
$otp = isset ($_POST['otp']) ? $_POST['otp'] : null;
// Validate the OTP
if ($otp == $_SESSION['otp']) {
    // OTP is correct, proceed with user registration

    // Retrieve form data from session
    $formData = isset ($_SESSION['form_data']) ? $_SESSION['form_data'] : null;

    if ($formData) {
        // Extract individual pieces of form data
        $username = isset ($formData['username']) ? $formData['username'] : null;
        $email = isset ($formData['email']) ? $formData['email'] : null;
        $password = isset ($formData['password']) ? $formData['password'] : null;
        $role = isset ($formData['role']) ? $formData['role'] : null;
        $csrf_token = isset ($formData['csrf_token']) ? $formData['csrf_token'] : null;

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if ($csrf_token === $_SESSION['_token']) {
            // Prepare SQL statement to insert data into association_admins table
            $sql = "INSERT INTO association_admins (username, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);

            // Execute the SQL statement
            if ($stmt->execute()) {
                echo json_encode(['success' => 'Registration successful.']);
                exit;

            } else {
                echo json_encode(['error' => 'Form data not found.']);
            }
        } else {
            echo 'Token invalid. Operation not allowed.<br>';
        }
    }
} else {
    // OTP is incorrect
    echo json_encode(['error' => 'Invalid OTP.']);
}
$conn->close();
?>