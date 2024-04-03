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
$pan_card_data_url = 'data:image/jpeg;base64,' . $pan_card_data;

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

        /* Styling for the side menu */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            overflow-x: hidden;
            padding-top: 20px;
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 20px;
            color: #fff;
            display: block;
        }

        .sidebar a:hover {
            background-color: #555;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        #pagination-container .page-link {
            width: fit-content;
        }

        #pagination-container {
            display: flex;
            margin-left: 1px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" id="mainTab">Main</a>
        <a href="#" id="playersTab">Players</a>
        <a href="logout_club.php" id="logout">Logout</a>
    </div>

    <!-- Page content -->
    <div class="content">
        <div id="mainContent">
            <!-- This container will display the content for the Main tab -->
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // Load the main content initially
            loadMainContent();

            // Click event for the Main tab
            $("#mainTab").click(function (e) {
                e.preventDefault();
                loadMainContent();
            });

            // Click event for the Players tab
            $("#playersTab").click(function (e) {
                e.preventDefault();
                // Load the content from player.php into the mainContent container
                $("#mainContent").load("players_list.php");
            });

            // Function to load the main content
            function loadMainContent() {
                // Load the content from main_content.php into the mainContent container
                $("#mainContent").load("main_content.php");
            }
        });
    </script>
</body>

</html>