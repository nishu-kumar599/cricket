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

// Fetch player information from the database
$sql = "SELECT * FROM players WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $player_id);
$stmt->execute();
$result = $stmt->get_result();
$player = $result->fetch_assoc();

// Check if player exists
if (!$player) {
    echo "Player not found.";
    exit();
}

// Convert blob data to data URL for Aadhar Card
$aadhar_card_data = base64_encode($player['aadhar_card']);
$aadhar_card_data_url = 'data:image/jpeg;base64,' . $aadhar_card_data;

// Convert blob data to data URL for Profile Picture
$profile_picture_data = base64_encode($player['profile_picture']);
$profile_picture_data_url = 'data:image/jpeg;base64,' . $profile_picture_data;

$club_id = $player['club_id'];
if ($club_id == null) {
    $club_name = 'Independent';
} else {
    // Prepare and execute a query to fetch club name
    $query = "SELECT name FROM clubs WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $club_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch club name from the result
    $club = $result->fetch_assoc();
    $club_name = $club['name'];
}

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* Custom CSS styles */
        .container {
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .empty-thumbnail {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            position: relative;
            height: 150px;
            /* Adjust height as needed */
        }

        .empty-thumbnail i {
            font-size: 48px;
            color: #ccc;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .empty-thumbnail p {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Player Profile</h3>
                    </div>
                    <div class="card-body">
                        <div class="row" id="playerInfo">
                            <div class="col-md-6">
                                <p><strong>ID:</strong>
                                    <?php echo $player['player_id']; ?>
                                </p>
                                <p><strong>Name:</strong>
                                    <?php echo $player['name']; ?>
                                </p>
                                <p><strong>Age:</strong>
                                    <?php echo $player['age']; ?>
                                </p>
                                <p><strong>Email:</strong>
                                    <?php echo $player['email']; ?>
                                </p>
                                <p><strong>Mobile:</strong>
                                    <?php echo $player['mobile']; ?>
                                </p>
                                <p><strong>Type of Player:</strong>
                                    <?php echo $player['type']; ?>
                                </p>
                                <p><strong>Club:</strong>
                                    <?php echo $club_name ?>
                                </p>
                                <p><strong>State:</strong>
                                    <?php echo $player['state']; ?>
                                </p>
                                <p><strong>City:</strong>
                                    <?php echo $player['city']; ?>
                                </p>
                                <p><strong>Address:</strong>
                                    <?php echo $player['address']; ?>
                                </p>
                            </div>
                            <div class="col-md-6">

                                <p><strong>payment status:</strong>
                                    <?php echo $player['payment_status']; ?>
                                </p>
                                <p><strong>runs:</strong>
                                    <?php echo $player['runs']; ?>
                                </p>
                                <p><strong>wicket:</strong>
                                    <?php echo $player['wicket']; ?>
                                </p>
                                <p><strong>catches:</strong>
                                    <?php echo $player['catches']; ?>
                                </p>
                                <p><strong>no of six:</strong>
                                    <?php echo $player['no_of_six']; ?>
                                </p>
                                <p><strong>no of four:</strong>
                                    <?php echo $player['no_of_four']; ?>
                                </p>
                                <p><strong>five wicket hall:</strong>
                                    <?php echo $player['five_wicket_hall']; ?>
                                </p>
                                <p><strong>no of hundred:</strong>
                                    <?php echo $player['no_of_hundred']; ?>
                                </p>
                                <p><strong>no of fifty:</strong>
                                    <?php echo $player['no_of_fifty']; ?>
                                </p>
                                <p><strong>no of stumping:</strong>
                                    <?php echo $player['no_of_stumping']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Documents</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Aadhar Card:</strong></p>
                                <?php if (!empty($aadhar_card_data)): ?>
                                    <img src="<?php echo $aadhar_card_data_url; ?>" alt="Aadhar Card" class="img-fluid">
                                <?php else: ?>
                                    <div class="empty-thumbnail">
                                        <i class="fa fa-user-edit"></i>
                                        <p>No Aadhar Card uploaded</p>
                                        <a href="upload_aadhar_card.php" class="btn btn-primary mt-4">Upload Aadhar Card</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Profile Picture:</strong></p>
                                <?php if (!empty($profile_picture_data)): ?>
                                    <img src="<?php echo $profile_picture_data_url; ?>" alt="Profile Picture"
                                        class="img-fluid">
                                <?php else: ?>
                                    <div class="empty-thumbnail">
                                        <i class="fa fa-user-edit"></i>
                                        <p>No Profile Picture uploaded</p>
                                        <a href="upload_profile_picture.php" class="btn btn-primary mt-4">Upload Profile
                                            Picture</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="logout_player.php" class="btn btn-danger">Logout</a>
                    <!--<button class='btn btn-success' id='shareProfileBtn'>Share Profile</button>-->
                    <button class='btn btn-success' id="copyBtn">Copy Info</button>
                    <button class='btn btn-success' id="shareBtn">Share Profile</button>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- Include this script tag in your HTML head for clipboard functionality -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
<script>
    document.getElementById('copyBtn').addEventListener('click', () => {
        const playerInfo = document.getElementById('playerInfo').innerText;
        navigator.clipboard.writeText(playerInfo)
            .then(() => alert('Player info copied to clipboard!'))
            .catch(err => console.error('Error copying text: ', err));
    });
</script>
<script>
    document.getElementById('shareBtn').addEventListener('click', async () => {
        const playerInfo = document.getElementById('playerInfo').innerText;
          console.log(playerInfo);
        if (navigator.share) {
            console.log('Attempting to share player info...');
            try {
                await navigator.share({
                    title: 'Player Info',
                    text: playerInfo

                })
                console.log('Player info shared successfully');
            } catch (error) {
                console.error('Error sharing:', error);
                // Additional fallback logic here, e.g., copying to clipboard
            }
        } else {
            console.error('Web Share API not supported.');
            alert('Share API not supported. Player info copied to clipboard. You can paste it anywhere.');
            // Fallback logic, e.g., copying to clipboard
        }
    });

</script>

</html>