<?php
// Include the database connection file
include '../db_connection.php';

// Check if all required fields are provided
if (
    isset(
    $_POST['playerId'],
    $_POST['name'],
    $_POST['age'],
    $_POST['dob'],
    $_POST['email'],
    $_POST['mobile'],
    $_POST['type'],
    $_POST['state'],
    $_POST['city'],
    $_POST['address'],
    $_POST['club']
)
) {
    // Sanitize input data to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_POST['playerId']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = intval($_POST['age']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $club = intval($_POST['club']);

    // Prepare the UPDATE statement
    $sql = "UPDATE players SET name=?, age=?, dob=?, email=?, mobile=?, type=?, state=?, city=?, address=?, club_id=? WHERE player_id=?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sisssssssis", $name, $age, $dob, $email, $mobile, $type, $state, $city, $address, $club, $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    // If any required field is missing, return an error message
    echo "Error: Missing required fields.";
}

// Close connection
$conn->close();
?>