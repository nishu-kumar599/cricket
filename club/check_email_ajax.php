<?php
// Include the database connection file
include '../db_connection.php';

// Check if email parameter is set in the POST request
if (isset($_POST['email'])) {
    // Retrieve email from POST data
    $email = $_POST['email'];

    // Prepare SQL statement to check if email exists in clubs table
    $sql = "SELECT COUNT(*) AS count FROM clubs WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Prepare response data
    $response = array();
    $response['exists'] = ($row['count'] > 0);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Handle invalid request
    http_response_code(400);
    echo "Invalid request";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
