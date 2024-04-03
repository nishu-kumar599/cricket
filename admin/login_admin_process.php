<?php
session_start();

// Include the database connection file
include '../db_connection.php';

// already login
if (isset($_SESSION["logged-in"]) === true) {
    header("Location:admin_dashboard.php");
}
// Retrieve data from login form
$username = $_POST['username'];
$password = $_POST['password'];
$csrf_token = $_POST['csrf_token'];
if ($csrf_token === $_SESSION['_token']) {
    // Prepare SQL statement to retrieve admin data based on username
    $sql = "SELECT * FROM association_admins WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Verify password and redirect if login is successful
    if ($admin && password_verify($password, $admin['password'])) {
        // Start a session to store admin data
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_role'] = $admin['role'];
        $_SESSION["logged-in"] = true;
        // Redirect to admin dashboard or appropriate page
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Redirect back to login page with error message
        header("Location: login_admin.php?error=1");
        exit();
    }
    // Close the database connection


} else {
    echo 'Token invalid. Operation not allowed.<br>';
}
$stmt->close();
$conn->close();
?>