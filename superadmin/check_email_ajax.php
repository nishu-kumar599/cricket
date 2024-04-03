<?php
// Include the database connection file
include '../db_connection.php';

// Initialize response array
$response = array();

// Initialize a variable to hold the value to be searched
$searchValue = null;

// Determine the field and value to search for
if (isset($_POST['email'])) {
    // Prepare SQL statement to check if email exists in super_admins table
    $sql = "SELECT COUNT(*) AS count FROM super_admins WHERE email = ?";
    $searchValue = $_POST['email'];
} elseif (isset($_POST['username'])) {
    // Prepare SQL statement to check if username exists in super_admins table
    $sql = "SELECT COUNT(*) AS count FROM super_admins WHERE username = ?";
    $searchValue = $_POST['username'];
} else {
    // Handle invalid request
    http_response_code(400);
    echo "Invalid request";
    exit;
}

// Prepare SQL statement
$stmt = $conn->prepare($sql);

// Bind the parameter
$stmt->bind_param("s", $searchValue);

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Prepare response data
$response['exists'] = ($row['count'] > 0);

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$stmt->close();
$conn->close();