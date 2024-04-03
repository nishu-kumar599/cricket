<?php
session_start();
include '../db_connection.php';

$password = $_POST['password'];
$email = $_SESSION['EMAIL'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
// Prepare statement
$sql = "UPDATE clubs SET password=? WHERE email=?";
$stmt = $conn->prepare($sql);

// Check if prepare() failed
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters and execute
$stmt->bind_param("ss", $hashedPassword, $email);

if ($stmt->execute()) {
    echo json_encode(['success' => 'password updated successful.']);
    exit;
} else {
    echo json_encode(['success' => 'Error updating  password.' . $stmt->error]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>