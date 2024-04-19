<?php
// Include the database connection file
include '../db_connection.php';

// Check if the form was submitted
// Collect POST data and ensure it's properly escaped to prevent SQL injection
$id = $_POST['playerId'];
$name = $_POST['name'];
$age = $_POST['age'];
$age = $_POST['age'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$type = $_POST['type'];
$state = $_POST['state'];
$city = $_POST['city'];
$address = $_POST['address'];
$club = $_POST['club'];
$dob = $_POST['dob'];
$Runs = $_POST['Runs'];
$wicket = $_POST['Wicket'];
$Catches = $_POST['Catches'];
$NoOfSix = $_POST['NoOfSix'];
$NoOffour = $_POST['NoOffour'];
$FiveWicketHall = $_POST['FiveWicketHall'];
$NoOfHundred = $_POST['NoOfHundred'];
$NoOfFifty = $_POST['NoOfFifty'];
$NoOfStumping = $_POST['NoOfStumping'];
// Prepare the UPDATE statement
$sql = "UPDATE players SET name=?, age=?, dob=?, email=?, mobile=?, type=?, state=?, city=?, address=?, club_id=? ,runs=?, wicket=?, catches=?, no_of_six=?, no_of_four=?, five_wicket_hall=?, no_of_hundred=?, no_of_fifty=?, no_of_stumping=? WHERE player_id=?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters and execute
// Ensure your types are correct: i for integer, s for string, d for double, b for blob
$stmt->bind_param("sisssssssiiiiiiiiiis", $name, $age, $dob, $email, $mobile, $type, $state, $city, $address, $club, $Runs, $wicket, $Catches, $NoOfSix, $NoOffour, $FiveWicketHall, $NoOfHundred, $NoOfFifty, $NoOfStumping, $id);

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
?>