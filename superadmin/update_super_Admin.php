<?php
// Include the database connection file
include '../db_connection.php';

// Check if the form was submitted
// Collect POST data and ensure it's properly escaped to prevent SQL injection
$id = $_POST['adminId'];
$userName = $_POST['userName'];
$role = $_POST['role'];
$email = $_POST['email'];

// Prepare the UPDATE statement
$sql = "UPDATE association_admins SET username=?, email=?, role=? WHERE id=?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters and execute
// Ensure your types are correct: i for integer, s for string, d for double, b for blob
$stmt->bind_param("sssi", $userName, $email, $role, $id);

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
?>