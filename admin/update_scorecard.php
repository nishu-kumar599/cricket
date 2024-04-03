<?php
include '../db_connection.php';
// Assuming $_POST contains all required fields
$id = $_POST['playerId'];
$Runs = $_POST['Runs'];
$wicket = $_POST['Wicket'];
$Catches = $_POST['Catches'];
$NoOfSix = $_POST['NoOfSix'];
$NoOffour = $_POST['NoOffour'];
$FiveWicketHall = $_POST['FiveWicketHall'];
$NoOfHundred = $_POST['NoOfHundred'];
$NoOfFifty = $_POST['NoOfFifty'];
$NoOfStumping = $_POST['NoOfStumping'];

// Prepare statement
$sql = "UPDATE players SET  runs=?, wicket=?, catches=?, no_of_six=?, no_of_four=?, five_wicket_hall=?, no_of_hundred=?, no_of_fifty=?, no_of_stumping=? WHERE player_id=?";
$stmt = $conn->prepare($sql);

// Check if prepare() failed
if ($stmt === false) {
    die ("Error preparing statement: " . $conn->error);
}

// Bind parameters and execute
$stmt->bind_param("iiiiiiiiis", $Runs, $wicket, $Catches, $NoOfSix, $NoOffour, $FiveWicketHall, $NoOfHundred, $NoOfFifty, $NoOfStumping, $id);

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>