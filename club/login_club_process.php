<?php
session_start(); // Start the session at the very beginning

// Include the database connection file
require '../db_connection.php'; // Change to require for critical includes

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // CSRF Token validation here if you have one

    // Prepare SQL statement to retrieve club data based on email
    $sql = "SELECT * FROM clubs WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $club = $result->fetch_assoc();

        // Verify password and set session variables if login is successful
        if ($club && password_verify($password, $club['password'])) {
            $_SESSION['club_id'] = $club['id'];
            $_SESSION['club_name'] = $club['name'];
            header("Location: club_dashboard.php");
            exit();
        } else {
            header("Location: login_club.php?error=1");
            exit();
        }
    } else {
        echo "SQL error: " . $conn->error; // Debugging purpose
        exit();
    }
}
