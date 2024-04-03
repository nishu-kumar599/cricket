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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["aadhar_card"])) {
    // File upload handling for Aadhar Card image
    $aadhar_card_name = $_FILES['aadhar_card']['name'];
    $aadhar_card_tmp_name = $_FILES['aadhar_card']['tmp_name'];
    $aadhar_card_type = $_FILES['aadhar_card']['type'];
    $aadhar_card_size = $_FILES['aadhar_card']['size'];

    // Check file type
    $allowed_types = array('image/jpeg');
    if (!in_array($aadhar_card_type, $allowed_types)) {
        echo "Error: Only JPG files are allowed.";
        exit();
    }

    // Check file size (max 200KB)
    $max_size = 200 * 1024;
    if ($aadhar_card_size > $max_size) {
        echo "Error: File size too large. Maximum size allowed is 200KB.";
        exit();
    }

    // Read Aadhar Card image data
    $aadhar_card_data = file_get_contents($aadhar_card_tmp_name);

    // Prepare SQL statement to update Aadhar Card in players table
    $sql = "UPDATE players SET aadhar_card=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si",$aadhar_card_data, $player_id);

    // Execute the SQL statement
    if ($stmt->execute()) {
       header('Location: player_dashboard.php');    
       exit();
    } else {
        echo "Error uploading Aadhar Card: " . $stmt->error;
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
    <title>Upload Aadhar Card</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Upload Aadhar Card</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="aadhar_card">Choose Aadhar Card Image (JPG, max 200KB):</label>
                                <input type="file" id="aadhar_card" name="aadhar_card" class="form-control-file" accept="image/jpeg" required>
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
