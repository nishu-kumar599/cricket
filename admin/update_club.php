<?php
include '../db_connection.php';

// Assuming $_POST contains all required fields
$id = $_POST['clubId'];
$name = $_POST['name'];
$location = $_POST['location'];
$email = $_POST['email'];
$panNumber = $_POST['panNumber'];
$aadharNumber = $_POST['aadharNumber'];
$directorName = $_POST['directorName'];
$secretaryName = $_POST['secretaryName'];
$mobile = $_POST['mobile'];

// Prepare statement
$sql = "UPDATE clubs SET name=?, location=?, email=?, pan_number=?, aadhar_number=?, club_director_name=?, club_secretary_name=?, contact_number=? WHERE clubid=?";
$stmt = $conn->prepare($sql);

// Check if prepare() failed
if ($stmt === false) {
    die ("Error preparing statement: " . $conn->error);
}

// Bind parameters and execute
$stmt->bind_param("sssssssss", $name, $location, $email, $panNumber, $aadharNumber, $directorName, $secretaryName, $mobile, $id);

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>