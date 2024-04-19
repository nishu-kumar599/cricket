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
                                <th>Delete</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_clubs->num_rows > 0) {
                                while ($row = $result_clubs->fetch_assoc()) {
                                    echo "<tr><td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['location']) . "</td>
                    <td><a href='delete_super_admin.php?type=club&id=" . $row['id'] . "' class='btn btn-danger'>Delete</a></td>
                    <td><button class='btn btn-primary edit-btn' data-bs-toggle='modal' data-bs-target='#editClubModal'
    data-club-id='" . $row['clubid'] . "'
    data-name='" . htmlspecialchars($row['name'], ENT_QUOTES) . "'
    data-location='" . htmlspecialchars($row['location'], ENT_QUOTES) . "'
    data-email='" . htmlspecialchars($row['email'], ENT_QUOTES) . "'
    data-panNumber='" . htmlspecialchars($row['pan_number'], ENT_QUOTES) . "'
    data-aadhar_number='" . htmlspecialchars($row['aadhar_number'], ENT_QUOTES) . "'
    data-club_director_name='" . htmlspecialchars($row['club_director_name'], ENT_QUOTES) . "'
    data-club_secretary_name='" . htmlspecialchars($row['club_secretary_name'], ENT_QUOTES) . "'
    data-contact_number='" . htmlspecialchars($row['contact_number'], ENT_QUOTES) . "'
    data-payment_status='" . htmlspecialchars($row['payment_status'], ENT_QUOTES) . "'>Edit</button></td>";
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
                                <th>Delete</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_players->num_rows > 0) {
                                while ($row = $result_players->fetch_assoc()) {
                                    echo "<tr><td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['age']) . "</td>
                    <td><a href='delete_super_admin.php?type=player&id=" . $row['id'] . "' class='btn btn-danger'>Delete</a></td>
                    <td><button class='btn btn-primary edit-player' data-bs-toggle='modal' data-bs-target='#editPlayerModal'
                    data-player_id='" . $row['player_id'] . "'
                    data-name='" . htmlspecialchars($row['name'], ENT_QUOTES) . "'
                    data-age='" . htmlspecialchars($row['age'], ENT_QUOTES) . "'
                    data-dob='" . htmlspecialchars($row['dob'], ENT_QUOTES) . "'
                    data-mobile='" . htmlspecialchars($row['mobile'], ENT_QUOTES) . "'
                    data-email='" . htmlspecialchars($row['email'], ENT_QUOTES) . "'
                    data-type='" . htmlspecialchars($row['type'], ENT_QUOTES) . "'
                    data-state='" . htmlspecialchars($row['state'], ENT_QUOTES) . "'
                    data-city='" . htmlspecialchars($row['city'], ENT_QUOTES) . "'
                    data-payment='" . htmlspecialchars($row['payment_status'], ENT_QUOTES) . "'
                    data-address='" . htmlspecialchars($row['address'], ENT_QUOTES) . "'
                    data-runs='" . htmlspecialchars($row['runs'], ENT_QUOTES) . "'
                    data-wicket='" . htmlspecialchars($row['wicket'], ENT_QUOTES) . "'
                    data-catches='" . htmlspecialchars($row['catches'], ENT_QUOTES) . "'
                    data-no_of_six='" . htmlspecialchars($row['no_of_six'], ENT_QUOTES) . "'
                    data-no_of_four='" . htmlspecialchars($row['no_of_four'], ENT_QUOTES) . "'
                    data-five_wicket_hall='" . htmlspecialchars($row['five_wicket_hall'], ENT_QUOTES) . "'
                    data-no_of_hundred='" . htmlspecialchars($row['no_of_hundred'], ENT_QUOTES) . "'
                    data-no_of_stumping='" . htmlspecialchars($row['no_of_stumping'], ENT_QUOTES) . "'
                    data-no_of_fifty='" . htmlspecialchars($row['no_of_fifty'], ENT_QUOTES) . "'>Edit</button></td></tr>";
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
                                <th>Delete</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_association_admins->num_rows > 0) {
                                while ($row = $result_association_admins->fetch_assoc()) {
                                    echo "<tr><td>" . htmlspecialchars($row['username']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td><a href='delete_super_admin.php?type=association_admin&id=" . $row['id'] . "' class='btn btn-danger'>Delete</a></td>
                    <td><button class='btn btn-primary edit-admin' data-bs-toggle='modal' data-bs-target='#editAdminModal'
                    data-admin_id='" . htmlspecialchars($row['id'], ENT_QUOTES) . "'
                    data-username='" . htmlspecialchars($row['username'], ENT_QUOTES) . "'
                    data-email='" . htmlspecialchars($row['email'], ENT_QUOTES) . "'
                    data-role='" . htmlspecialchars($row['role'], ENT_QUOTES) . "'>Edit</button></td>
                    </tr>";
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
    <div class="modal fade" id="editClubModal" tabindex="-1" role="dialog" aria-labelledby="editClubModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editClubModalLabel">Edit Club Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPlayerForm">
                        <input type="hidden" id="clubId" name="clubId">
                        <div class="form-group">
                            <label for="editName">Name:</label>
                            <input type="text" id="editName" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editLocation">Location:</label>
                            <input type="text" id="editLocation" name="Location" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email:</label>
                            <input type="mail" id="editEmail" name="Email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editPANNumber">PAN Number:</label>
                            <input type="text" id="editPANNumber" name="PANNumber" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editAadharNumber">Aadhar Number:</label>
                            <input type="text" id="editAadharNumber" name="AadharNumber" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editClubDirectorName">Club Director Name:</label>
                            <input type="text" id="editClubDirectorName" name="DirectorName" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="editClubSecretaryName">Club Secretary Name:</label>
                            <input type="text" id="editClubSecretaryName" name="SecretaryName" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="editMobile">Mobile Number:</label>
                            <input type="number" id="editMobile" name="mobileNumber" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editPaymentStatus">Payment Status:</label>
                            <input type="text" id="editPaymentStatus" name="editPaymentStatus" class="form-control"
                                required readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveClubChanges()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap Modal for Editing Player -->
    <div class="modal fade" id="editPlayerModal" tabindex="-1" role="dialog" aria-labelledby="editPlayerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPlayerModalLabel">Edit Player Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPlayerForm">
                        <input type="hidden" id="editPlayerId" name="player_id">
                        <div class="form-group">
                            <label for="editname">Name:</label>
                            <input type="text" id="editname" name="name" class="form-control" required>

                        </div>
                        <div class="form-group">
                            <label for="editAge">Age:</label>
                            <input type="number" id="editAge" name="age" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth:</label>
                            <div class="input-group date">
                                <input type="date" id="editDob" name="dob" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editmobile">Mobile Number:</label>
                            <input type="text" id="editmobile" name="mobile" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editemail">Email:</label>
                            <input type="email" id="editemail" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editType">Type of Player:</label>
                            <select id="editType" name="type" class="form-control" required>
                                <option value="bowler">Bowler</option>
                                <option value="batsman">Batsman</option>
                                <option value="wicketkeeper_batsman">Wicketkeeper/Batsman</option>
                                <option value="allrounder">Allrounder</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editState">State:</label>
                            <input type="text" id="editState" name="state" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editCity">City:</label>
                            <input type="text" id="editCity" name="city" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editAddress">Address:</label>
                            <textarea id="editAddress" name="address" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editClub">Club:</label>
                            <select id="editClub" name="club" class="form-control" required>
                                <?php
                                include '../db_connection.php';
                                $sql_clubs = "SELECT * FROM clubs";
                                $result_clubs = $conn->query($sql_clubs);
                                if ($result_clubs->num_rows > 0) {
                                    while ($row = $result_clubs->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editpaymentstatus">PaymentStatus:</label>
                            <input type="text" id="editpaymentstatus" name="payment" class="form-control"
                                readonly></input>
                        </div>
                        <div class="form-group">
                            <label for="editRuns">Runs:</label>
                            <input type="number" min="0" id="editRuns" name="Runs" class="form-control"
                                required></input>
                        </div>
                        <div class="form-group">
                            <label for="editWicket">Wicket:</label>
                            <input type="number" min="0" id="editWicket" name="Wicket" class="form-control"
                                required></input>
                        </div>
                        <div class="form-group">
                            <label for="editCatches">Catches:</label>
                            <input type="number" min="0" id="editCatches" name="Catches" class="form-control"
                                required></input>
                        </div>
                        <div class="form-group">
                            <label for="editno_of_six">No of six:</label>
                            <input type="number" min="0" id="editno_of_six" name="no_of_six" class="form-control"
                                required></input>
                        </div>
                        <div class="form-group">
                            <label for="editno_of_four">no of four:</label>
                            <input type="number" min="0" id="editno_of_four" name="no_of_four" class="form-control"
                                required></input>
                        </div>
                        <div class="form-group">
                            <label for="editfive_wickets_hall">five wickets hall:</label>
                            <input type="number" min="0" id="editfive_wickets_hall" name="five_wickets_hall"
                                class="form-control" required></input>
                        </div>
                        <div class="form-group">
                            <label for="editno_of_hundred">no of hundred:</label>
                            <input type="number" min="0" id="editno_of_hundred" name="no_of_hundred"
                                class="form-control" required></input>
                        </div>
                        <div class="form-group">
                            <label for="editno_of_fifty">no of fifty:</label>
                            <input type="number" min="0" id="editno_of_fifty" name="no_of_fifty" class="form-control"
                                required></input>
                        </div>
                        <div class="form-group">
                            <label for="editno_of_stumping">no of stumping:</label>
                            <input type="number" min="0" id="editno_of_stumping" name="no_of_stumping"
                                class="form-control" required></input>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="savePlayerChanges()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap Modal for admin Player -->
    <div class="modal fade" id="editAdminModal" tabindex="-1" role="dialog" aria-labelledby="editAdminModallLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAdminModalLabel">Edit admin Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAdminForm">
                        <input type="hidden" id="editAdminId" name="admin_id">
                        <div class="form-group">
                            <label for="editUsername">username:</label>
                            <input type="text" id="editUsername" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editemail">Email:</label>
                            <input type="text" id="adminEmail" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editRole">Role:</label>
                            <select class="form-control" id="editRole" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="adminChanges()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

<script>
    $(document).ready(function () {
        $('.edit-btn').on('click', function () {
            var $btn = $(this);
            $('#clubId').val($btn.data('club-id'));
            $('#editName').val($btn.data('name'));
            $('#editLocation').val($btn.data('location')),
                $('#editEmail').val($btn.data('email')),
                $('#editPANNumber').val($btn.data('pannumber')),
                $('#editAadharNumber').val($btn.data('aadhar_number')),
                $('#editClubDirectorName').val($btn.data('club_director_name')),
                $('#editClubSecretaryName').val($btn.data('club_secretary_name')),
                $('#editMobile').val($btn.data('contact_number')),
                $('#editPaymentStatus').val($btn.data('payment_status')),
                $('#editClubModal').modal('show');
        });
    });
    function saveClubChanges() {
        var data = {
            clubId: $('#clubId').val(),
            name: $('#editName').val(),
            location: $('#editLocation').val(),
            email: $('#editEmail').val(),
            panNumber: $('#editPANNumber').val(),
            aadharNumber: $('#editAadharNumber').val(),
            directorName: $('#editClubDirectorName').val(),
            secretaryName: $('#editClubSecretaryName').val(),
            mobile: $('#editMobile').val(),

        };
        $.ajax({
            type: "POST",
            url: "../admin/update_club.php", // The server-side script handling the update
            data: data,
            success: function (response) {
                $('#editClubModal').modal('hide'); // Hide the modal
                location.reload(); // Optionally reload the page or part of it
                alert('Update Successful!');
            },
            error: function () {
                alert('Error updating club.');
            }
        });
    }
    $(document).ready(function () {
        $('.edit-player').on('click', function () {
            var $btn = $(this);
            // Populate the edit form with the player's existing information
            $('#editPlayerId').val($btn.data('player_id'));
            $('#editname').val($btn.data('name'));
            $('#editAge').val($btn.data('age'));
            $('#editDob').val($btn.data('dob'));
            $('#editmobile').val($btn.data('mobile'));
            $('#editemail').val($btn.data('email'));
            $('#editType').val($btn.data('type'));
            $('#editState').val($btn.data('state'));
            $('#editCity').val($btn.data('city'));
            $('#editpaymentstatus').val($btn.data('payment'));
            $('#editAddress').val($btn.data('address'));
            $('#editRuns').val($btn.data('runs'));
            $('#editWicket').val($btn.data('wicket'));
            $('#editCatches').val($btn.data('catches'));
            $('#editno_of_six').val($btn.data('no_of_six'));
            $('#editno_of_four').val($btn.data('no_of_four'));
            $('#editfive_wickets_hall').val($btn.data('five_wicket_hall'));
            $('#editno_of_hundred').val($btn.data('no_of_hundred'));
            $('#editno_of_fifty').val($btn.data('no_of_fifty'));
            $('#editno_of_stumping').val($btn.data('no_of_stumping'));
            $('#editPlayerModal').modal('show');
        });
    });
    function savePlayerChanges() {
        var data = {
            playerId: $('#editPlayerId').val(),
            name: $('#editname').val(),
            age: $('#editAge').val(),
            dob: $('#editDob').val(),
            mobile: $('#editmobile').val(),
            email: $('#editemail').val(),
            type: $('#editType').val(),
            state: $('#editState').val(),
            city: $('#editCity').val(),
            address: $('#editAddress').val(),
            club: $('#editClub').val(),
            Runs: $('#editRuns').val(),
            Wicket: $('#editWicket').val(),
            Catches: $('#editCatches').val(),
            NoOfSix: $('#editno_of_six').val(),
            NoOffour: $('#editno_of_four').val(),
            FiveWicketHall: $('#editfive_wickets_hall').val(),
            NoOfHundred: $('#editno_of_hundred').val(),
            NoOfFifty: $('#editno_of_fifty').val(),
            NoOfStumping: $('#editno_of_stumping').val()
        };
        $.ajax({
            type: "POST",
            url: "update_superadmin_players.php", // The server-side script handling the update
            data: data,
            success: function (response) {
                $('#editPlayerModal').modal('hide'); // Hide the modal
                location.reload(); // Optionally reload the page or part of it
                alert('Update Successful!');
            },
            error: function () {
                alert('Error updating club.');
            }
        });
    }

    $(document).ready(function () {
        $('.edit-admin').on('click', function () {
            var $btn = $(this);
            // Populate the edit form with the player's existing information
            $('#editAdminId').val($btn.data('admin_id'));
            $('#editUsername').val($btn.data('username'));
            $('#adminEmail').val($btn.data('email'));
            $('#editRole').val($btn.data('role'));
            $('#editAdminModal').modal('show');
        });
    });
    function adminChanges() {
        var data = {
            adminId: $('#editAdminId').val(),
            userName: $('#editUsername').val(),
            role: $('#editRole').val(),
            email: $('#adminEmail').val(),
        };
        $.ajax({
            type: "POST",
            url: "update_super_Admin.php", // The server-side script handling the update
            data: data,
            success: function (response) {
                $('#editAdminModal').modal('hide'); // Hide the modal
                location.reload(); // Optionally reload the page or part of it
                alert('Update Successful!');
            },
            error: function () {
                alert('Error updating club.');
            }
        });
    }
</script>

</html>