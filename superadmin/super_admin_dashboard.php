<?php
// Start the session to access session variables
session_start();

// Check if super admin is logged in, if not, redirect to login page
if (!isset($_SESSION['super_admin_id'])) {
    header("Location: login_super_admin.php");
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

// Fetch all association admins from the database
$sql_association_admins = "SELECT * FROM association_admins";
$result_association_admins = $conn->query($sql_association_admins);



// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin-top: 20px;
        }

        .dashboard-table th {
            background-color: #007bff;
            color: #fff;
        }

        .btn-danger {
            margin-top: -5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mb-4 text-center">Welcome,
            <?php echo htmlspecialchars($_SESSION['super_admin_username']); ?>!
        </h1>

        <div class="row">
            <div class="col-lg-12 mb-5">
                <h2 class="mb-3">Clubs</h2>
                <div class="table-responsive">
                    <table class="table dashboard-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_clubs->num_rows > 0) {
                                while ($row = $result_clubs->fetch_assoc()) {
                                    echo "<tr><td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['location']) . "</td>
                    <td><a href='delete_super_admin.php?type=club&id=" . $row['id'] . "' class='btn btn-danger'>Delete</a></td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No clubs found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-12 mb-5">
                <h2 class="mb-3">Players</h2>
                <div class="table-responsive">
                    <table class="table dashboard-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_players->num_rows > 0) {
                                while ($row = $result_players->fetch_assoc()) {
                                    echo "<tr><td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['age']) . "</td>
                    <td><a href='delete_super_admin.php?type=player&id=" . $row['id'] . "' class='btn btn-danger'>Delete</a></td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No players found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-12 mb-5">
                <h2 class="mb-3">Association Admins</h2>
                <div class="table-responsive">
                    <table class="table dashboard-table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_association_admins->num_rows > 0) {
                                while ($row = $result_association_admins->fetch_assoc()) {
                                    echo "<tr><td>" . htmlspecialchars($row['username']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td><a href='delete_super_admin.php?type=association_admin&id=" . $row['id'] . "' class='btn btn-danger'>Delete</a></td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No association admins found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="logout_super_admin.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>