<?php
session_start();
// Include the database connection file
include '../db_connection.php';

// Retrieve data from login form
$email = $_POST['email'];
$password = $_POST['password'];
$csrf_token = $_POST['csrf_token'];

if ($csrf_token === $_SESSION['_token']) {
    // Prepare SQL statement to retrieve player data based on email
    $sql = "SELECT * FROM players WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $player = $result->fetch_assoc();

    // Verify password and redirect if login is successful
    if ($player && password_verify($password, $player['password'])) {
        // Start a session to store player data
        $_SESSION['player_id'] = $player['id'];
        $_SESSION['player_name'] = $player['name'];

        // Close the database connection
        $stmt->close();
        $conn->close();
        // Redirect to player dashboard
        header("Location: player_dashboard.php");
        exit();
    } else {
        // Redirect back to login page with error message
        header("Location: login_player.php?error=1");
        exit();
    }
} else {
    echo 'Token invalid. Operation not allowed.<br>';
}
session_destroy();
?>