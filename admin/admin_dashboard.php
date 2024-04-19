<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
    <?php if (isset($_SESSION["logged-in"]) && $_SESSION["logged-in"] === true): ?>
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="#" id="clubsTab">Clubs</a>
            <a href="#" id="playersTab">Players</a>
            <a href="#" id="merchandiseTab">Merchandise</a>
            <a href="#" id="CategoriesTab">Categories</a>
            <a href="#" id="orderTab">Order</a>
            <a href="#" id="editorTab">Editor</a>
            <a href="logout_admin.php" id="playersTab">Logout</a>
        </div>

        <!-- Page content -->
        <div class="content">
            <div id="mainContent">
                <!-- This container will display the content for the selected tab -->
            </div>
        </div>
    <?php else: ?>
        <!-- If not logged in, show a login link or redirect to login page -->
        <p>You are not logged in. <a href="login_admin.php">Click here to log in</a></p>
    <?php endif; ?>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Load the clubs content initially
            loadClubsContent();

            // Click event for the Clubs tab
            $("#clubsTab").click(function (e) {
                e.preventDefault();
                loadClubsContent();
            });

            // Click event for the Players tab
            $("#playersTab").click(function (e) {
                e.preventDefault();
                loadPlayersContent();
            });
            // Click event for the merchandise tab
            $("#merchandiseTab").click(function (e) {
                e.preventDefault();
                loadmerchandiseContent();
            });

            // Click event for the Categories tab
            $("#CategoriesTab").click(function (e) {
                e.preventDefault();
                loadCategoriesContent();
            });
            // Click event for the order tab
            $("#orderTab").click(function (e) {
                e.preventDefault();
                loadorderContent();
            });
            //click event for the editor tab
            $("#editorTab").click(function (e) {
                e.preventDefault();
                loadblogContent();
            });
            // Function to load the clubs content
            function loadClubsContent() {
                // Load the content from clubs.php into the mainContent container
                $("#mainContent").load("club_list.php");
            }

            // Function to load the players content
            function loadPlayersContent() {
                // Load the content from players.php into the mainContent container
                $("#mainContent").load("player_list.php");
            }
            // Function to load the merchandise content
            function loadmerchandiseContent() {
                // Load the content from merchandise.php into the mainContent container
                $("#mainContent").load("../adminShop/merchandise.php");
            }

            // Function to load the Categories content
            function loadCategoriesContent() {
                // Load the content from Categories.php into the mainContent container
                $("#mainContent").load("../adminShop/Categories.php");
            }
            // Function to load the Categories content
            function loadorderContent() {
                // Load the content from order.php into the mainContent container
                $("#mainContent").load("../adminShop/order.php");
            }
            // Function to load the blog content
            function loadblogContent() {
                // Load the content from order.php into the mainContent container
                $("#mainContent").load("../adminShop/blog.php");
            }
        });
    </script>
</body>

</html>