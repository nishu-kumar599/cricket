<?php
// Include the database connection file
include '../db_connection.php';

// Check if the form was submitted
print_r($_POST);
// Collect POST data and ensure it's properly escaped to prevent SQL injection
$id = $_POST['playerId'];
$name = $_POST['name'];
$age = $_POST['age'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$type = $_POST['type'];
$state = $_POST['state'];
$city = $_POST['city'];
$address = $_POST['address'];
$club = $_POST['club'];

// Prepare the UPDATE statement
$sql = "UPDATE players SET name=?, age=?, email=?, mobile=?, type=?, state=?, city=?, address=?, club_id=? WHERE player_id=?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die ("Error preparing statement: " . $conn->error);
}

// Bind parameters and execute
// Ensure your types are correct: i for integer, s for string, d for double, b for blob
$stmt->bind_param("sissssssis", $name, $age, $email, $mobile, $type, $state, $city, $address, $club, $id);

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();

?>