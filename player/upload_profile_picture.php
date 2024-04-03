<?php
// Start the session to access session variables
session_start();

// Check if player is logged in, if not, redirect to login page
if (!isset($_SESSION['player_id'])) {
    header("Location: login_player.php");
    exit();
}

// Include the database connection file
include '../db_connection.php';

// Retrieve player ID from session
$player_id = $_SESSION['player_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_picture"])) {
    // File upload handling for Profile Picture
    $profile_picture_name = $_FILES['profile_picture']['name'];
    $profile_picture_tmp_name = $_FILES['profile_picture']['tmp_name'];
    $profile_picture_type = $_FILES['profile_picture']['type'];
    $profile_picture_size = $_FILES['profile_picture']['size'];

    // Check file type
    $allowed_types = array('image/jpeg');
    if (!in_array($profile_picture_type, $allowed_types)) {
        echo "Error: Only JPG files are allowed.";
        exit();
    }

    // Check file size (max 200KB)
    $max_size = 200 * 1024;
    if ($profile_picture_size > $max_size) {
        echo "Error: File size too large. Maximum size allowed is 200KB.";
        exit();
    }

    // Read Profile Picture data
    $profile_picture_data = file_get_contents($profile_picture_tmp_name);

    // Prepare SQL statement to update Profile Picture in players table
    $sql = "UPDATE players SET profile_picture=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $profile_picture_data, $player_id);

    // Execute the SQL statement
    if ($stmt->execute()) {
        header('Location: player_dashboard.php');
        exit();
    } else {
        echo "Error uploading Profile Picture: " . $stmt->error;
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
    <title>Upload Profile Picture</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Upload Profile Picture</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="profile_picture">Choose Profile Picture Image (JPG, max 200KB):</label>
                                <input type="file" id="profile_picture" name="profile_picture" class="form-control-file" accept="image/jpeg" required>
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
