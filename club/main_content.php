<?php
ob_start(); // Start output buffering
session_start();

// Include the database connection file
include '../db_connection.php';

// Retrieve club ID from session
$club_id = $_SESSION['club_id'];

// Fetch club information from the database
$sql = "SELECT * FROM clubs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $club_id);
$stmt->execute();
$result = $stmt->get_result();
$club = $result->fetch_assoc();

// Check if club exists
if (!$club) {
    echo "Club not found.";
    exit();
}
// Convert blob data to data URL for Aadhar Card
$aadhar_card_data = base64_encode($club['aadhar_card_img']);
$aadhar_card_data_url = 'data:image/jpeg;base64,' . $aadhar_card_data;

$pan_card_data = base64_encode($club['pancard_img']);
$pan_card_data_url = 'data:image/jpeg;base64,' . $pan_card_data ;

// Convert blob data to data URL for Profile Pictu  re
$club_logo = base64_encode($club['club_logo']);
$club_logo_url = 'data:image/jpeg;base64,' . $club_logo;

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Custom CSS for professional-grade UI */
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 50px 20px;
        }
        .dashboard-heading {
            text-align: center;
            margin-bottom: 40px;
        }
        .dashboard-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        .dashboard-card h3 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .dashboard-card p {
            font-size: 16px;
            color: #666;
            margin-bottom: 15px;
        }
        .logout-link {
            text-align: center;
            margin-top: 30px;
        }
        .empty-thumbnail {
            text-align: center;
            color: #999;
            border: 2px dashed #ccc;
            padding: 20px;
            border-radius: 10px;
        }
        .empty-thumbnail i {
            font-size: 48px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="dashboard-heading">
            <h1>Welcome, <?php echo $club['name']; ?>!</h1>
            <p class="lead">Your Club Dashboard</p>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="dashboard-card">
                    <h3>Club Information</h3>
                    <p><strong>Club ID:</strong> <?php echo $club['clubid']; ?></p>
                    <p><strong>Location:</strong> <?php echo $club['location']; ?></p>
                    <p><strong>Email:</strong> <?php echo $club['email']; ?></p>
                    <p><strong>PAN Number:</strong> <?php echo $club['pan_number']; ?></p>
                    <p><strong>Aadhar Number:</strong> <?php echo $club['aadhar_number']; ?></p>
                    <p><strong>Club Director Name:</strong> <?php echo $club['club_director_name']; ?></p>
                    <p><strong>Club Secretary Name:</strong> <?php echo $club['club_secretary_name']; ?></p>
                    <p><strong>Contact Number:</strong> <?php echo $club['contact_number']; ?></p>
                </div>
            </div>
    </div>
    <div class="row">
            <div class="col-md-12">
                
                <div class="dashboard-card">
                    <h3>PAN Card Image</h3>
                    <?php if(!empty($club['pancard_img'])): ?>
                        <img src="<?php echo $pan_card_data_url; ?>" alt="PAN Card" class="img-fluid">
                    <?php else: ?>
                        <div class="empty-thumbnail">
                            <i class="fa fa-id-card"></i>
                            <p>No PAN Card uploaded</p>
                            <a href="upload_pancard.php" class="btn btn-primary mt-4">Upload PAN Card</a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="dashboard-card">
                    <h3>Aadhar Card Image</h3>
                    <?php if(!empty($club['aadhar_card_img'])): ?>
                        <img src="<?php echo $aadhar_card_data_url; ?>" alt="Aadhar Card" class="img-fluid">
                    <?php else: ?>
                        <div class="empty-thumbnail">
                            <i class="fa fa-id-card"></i>
                            <p>No Aadhar Card uploaded</p>
                            <a href="upload_aadharcard.php" class="btn btn-primary mt-4">Upload Aadhar Card</a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="dashboard-card">
                    <h3>Club Logo</h3>
                    <?php if(!empty($club['club_logo'])): ?>
                        <img src="<?php echo $club_logo_url; ?>" alt="Club Logo" class="img-fluid">
                    <?php else: ?>
                        <div class="empty-thumbnail">
                            <i class="fa fa-image"></i>
                            <p>No Club Logo uploaded</p>
                            <a href="upload_club_logo.php" class="btn btn-primary mt-4">Upload Club Logo</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>

