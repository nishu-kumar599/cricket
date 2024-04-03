<?php
// Start the session to access session variables
session_start();

// Check if admin is logged in, if not, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

// Include the database connection file
include '../db_connection.php';

// Fetch all clubs from the database
$sql_clubs = "SELECT * FROM clubs";
$result_clubs = $conn->query($sql_clubs);

// Fetch all players from the database
$sql_players = "SELECT * FROM players";
$result_players = $conn->query($sql_players);

// Close the database connection
$conn->close();
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
        /* Add your custom CSS styles here */
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Welcome,
            <?php echo $_SESSION['admin_username']; ?>!
        </h1>

        <h2>Filter by Club</h2>
        <div class="form-group">
            <select id="clubFilter" class="form-control">
                <option value="">Select Club</option>
                <?php
                if ($result_clubs->num_rows > 0) {
                    while ($club_row = $result_clubs->fetch_assoc()) {
                        echo "<option value='" . $club_row['id'] . "'>" . $club_row['name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No clubs found</option>";
                }
                ?>
            </select>
        </div>

        <h2>Players</h2>
        <div id="playersList" class="table-responsive">
            <!-- Players list will be displayed here -->
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // Load players associated with the selected club
            $('#clubFilter').change(function () {
                var clubId = $(this).val();
                if (clubId !== '') {
                    $.ajax({
                        url: 'get_player.php',
                        type: 'POST',
                        data: { club_id: clubId },
                        success: function (response) {
                            $('#playersList').html(response);
                        }
                    });
                } else {
                    $('#playersList').html('<p>No club selected.</p>');
                }
            });
        });
    </script>
</body>

</html>