<?php
// Start the session to access session variables
session_start();

// Check if club is logged in, if not, redirect to login page
if (!isset($_SESSION['club_id'])) {
    header("Location: login_club.php");
    exit();
}

// Include the database connection file
include '../db_connection.php';

// Retrieve club ID from session
$club_id = $_SESSION['club_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["club_logo"])) {
    // File upload handling for Club Logo image
    $club_logo_name = $_FILES['club_logo']['name'];
    $club_logo_tmp_name = $_FILES['club_logo']['tmp_name'];
    $club_logo_type = $_FILES['club_logo']['type'];
    $club_logo_size = $_FILES['club_logo']['size'];

    // Check file type
    $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
    if (!in_array($club_logo_type, $allowed_types)) {
        echo "Error: Only JPG, PNG, and GIF files are allowed.";
        exit();
    }

    // Check file size (max 200KB)
    $max_size = 200 * 1024;
    if ($club_logo_size > $max_size) {
        echo "Error: File size too large. Maximum size allowed is 200KB.";
        exit();
    }

    // Read Club Logo image data
    $club_logo_data = file_get_contents($club_logo_tmp_name);

    // Prepare SQL statement to update Club Logo in clubs table
    $sql = "UPDATE clubs SET club_logo=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $club_logo_data, $club_id);

    // Execute the SQL statement
    if ($stmt->execute()) {
       header('Location: club_dashboard.php');    
       exit();
    } else {
        echo "Error uploading Club Logo: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Club Logo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Upload Club Logo</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="club_logo">Choose Club Logo Image (JPG, PNG, max 200KB):</label>
                                <input type="file" id="club_logo" name="club_logo" class="form-control-file" accept="image/jpeg, image/png, image/gif" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
