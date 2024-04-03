<?php
 
// Include the database connection file
include '../db_connection.php';

// Retrieve data from login form
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare SQL statement to retrieve super admin data based on username
$sql = "SELECT * FROM super_admins WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$super_admin = $result->fetch_assoc();

// Verify password and redirect if login is successful
if ($super_admin && password_verify($password, $super_admin['password'])) {
    // Start a session to store super admin data
   session_start();
    $_SESSION['super_admin_id'] = $super_admin['id'];
    $_SESSION['super_admin_username'] = $super_admin['username'];

    // Redirect to super admin dashboard or appropriate page
    header("Location: super_admin_dashboard.php");
    exit();
} else {
    // Redirect back to login page with error message
    header("Location: login_super_admin.php?error=1");
    exit();
}

// Close the database connection
$stmt->close();
$conn->close();
?>

