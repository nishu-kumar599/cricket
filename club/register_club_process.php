<?php
// Include the database connection file
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include '../db_connection.php';

// Initialize $stmt to null
$stmt = null;
// Retrieve data from registration form
if (isset($_POST['code']) && $_POST['code'] === 'PAYMENT_SUCCESS') {
    if (isset($_COOKIE['FormData'])) {
        $formData = json_decode($_COOKIE['FormData'], true);
        $csrf_token = $formData['csrf_token'] ?? '';
        if (!empty($csrf_token)) {
            $clubid = $formData['clubid'];
            $name = $formData['name'];
            $location = $formData['location'];
            $email = $formData['email'];
            $password = $formData['password'];
            $pan_number = $formData['pan_number'];
            $aadhar_number = $formData['aadhar_number'];
            $club_director_name = $formData['director_name'];
            $club_secretary_name = $formData['secretary_name'];
            $contact_number = $formData['contact_number'];
            $paymentStatus = $_POST['code'];
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Prepare SQL statement to insert data into clubs table
            $sql = "INSERT INTO clubs (clubid,name, location, email, password, pan_number, aadhar_number, club_director_name, club_secretary_name, contact_number ,payment_status) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssssss", $clubid, $name, $location, $email, $hashed_password, $pan_number, $aadhar_number, $club_director_name, $club_secretary_name, $contact_number, $paymentStatus);

            // Execute the SQL statement
            if ($stmt->execute()) {
                setcookie('FormData', '', time() - 3600, '/');
                setcookie('clubid', '', time() - 3600, '/');
                // Registration successful, redirect to club_dashboard.php
                header("Location: club_dashboard.php?club_id=" . $stmt->insert_id);
                exit();
            } else {
                // Registration failed
                echo "Error: " . $sql . "<br>" . $stmt->error;
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
// Close the statement if it was created
if ($stmt !== null) {
    $stmt->close();
}

$conn->close();
?>