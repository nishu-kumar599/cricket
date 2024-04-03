<?php
// Include the database connection file
include '../db_connection.php';

// Check if club_id is provided via POST request
if (isset ($_POST['club_id'])) {
    $club_id = $_POST['club_id'];

    // Fetch players associated with the selected club from the database
    $sql_players = "SELECT players.*, clubs.name AS club_name FROM players
                    LEFT JOIN clubs ON players.club_id = clubs.id
                    WHERE club_id = ?";
    $stmt = $conn->prepare($sql_players);
    $stmt->bind_param("i", $club_id);
    $stmt->execute();
    $result_players = $stmt->get_result();

    // Display players in HTML format
    if ($result_players->num_rows > 0) {
        echo '<table class="table table-bordered" id="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Club</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Address</th>
                        <th style="display: none;">Club ID</th>
                        <th>Aadhar Card</th>
                        <th>Profile Picture</th>
                        <th>payment_status</th>
                        <th>runs</th>
                        <th>wicket</th>
                        <th>catches</th>
                        <th>no_of_six</th>
                        <th>no_of_four</th>
                        <th>five_wicket_hall</th>
                        <th>no_of_hundred</th>
                        <th>no_of_fifty</th>
                        <th>no_of_stumping</th>
                        <th>Edit player</th>
                        <th>Edit scoreCard</th>
                    </tr>
                </thead>
                <tbody>';
        while ($player_row = $result_players->fetch_assoc()) {
            $aadhar_card_data = base64_encode($player_row['aadhar_card']);
            $aadhar_card_data_url = 'data:image/jpeg;base64,' . $aadhar_card_data;

            // Convert blob data to data URL for Profile Picture
            $profile_picture_data = base64_encode($player_row['profile_picture']);
            $profile_picture_data_url = 'data:image/jpeg;base64,' . $profile_picture_data;
            echo '<tr>
                    <td>' . $player_row['player_id'] . '</td>
                    <td>' . $player_row['name'] . '</td>
                    <td>' . $player_row['age'] . '</td>
                    <td>' . $player_row['mobile'] . '</td>
                    <td>' . $player_row['email'] . '</td>
                    <td>' . $player_row['type'] . '</td>
                    <td>' . $player_row['club_name'] . '</td>
                    <td>' . $player_row['state'] . '</td>
                    <td>' . $player_row['city'] . '</td>
                    <td>' . $player_row['address'] . '</td> 
                    <td style="display: none;">' . $club_id . '</td>
                    <td>';
            // Display Aadhar Card image
            if (!empty ($player_row['aadhar_card'])) {
                echo '<img src="' . $aadhar_card_data_url . '" alt="Aadhar Card" width="100">';
            } else {
                echo 'Not Available';
            }
            echo '</td>
                    <td>';
            // Display Profile Picture placeholder or icon
            if (!empty ($player_row['profile_picture'])) {
                echo '<img src="' . $profile_picture_data_url . '" alt="Profile Picture" width="100">';
            } else {
                echo 'Not Available';
            }
            echo '</td>
            <td>' . $player_row['payment_status'] . '</td>
            <td>' . $player_row['runs'] . '</td>
            <td>' . $player_row['wicket'] . '</td>
            <td>' . $player_row['catches'] . '</td>
            <td>' . $player_row['no_of_six'] . '</td>
            <td>' . $player_row['no_of_four'] . '</td>
            <td>' . $player_row['five_wicket_hall'] . '</td>
            <td>' . $player_row['no_of_hundred'] . '</td>
            <td>' . $player_row['no_of_fifty'] . '</td>
            <td>' . $player_row['no_of_stumping'] . '</td>
            <td><button class="btn btn-primary edit-player">Edit </button></td>
            <td><button class="btn btn-primary edit-scorecard">Edit </button></td>
          </tr>';
        }
        echo '</tbody></table> <div id="pagination-container"></div>';
    } else {
        echo '<p>No players found for the selected club.</p>';
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If club_id is not provided, return an error message
    echo '<p>Error: Club ID not provided.</p>';
}
?>


<!-- Bootstrap Modal for Editing Player -->
<!-- Bootstrap Modal for Editing Player -->
<div class="modal fade" id="editPlayerModal" tabindex="-1" role="dialog" aria-labelledby="editPlayerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPlayerModalLabel">Edit Player Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPlayerForm">
                    <input type="hidden" id="editPlayerId" name="player_id">
                    <div class="form-group">
                        <label for="editName">Name:</label>
                        <input type="text" id="editName" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editAge">Age:</label>
                        <input type="number" id="editAge" name="age" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editMobile">Mobile Number:</label>
                        <input type="text" id="editMobile" name="mobile" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email:</label>
                        <input type="email" id="editEmail" name="email" class="form-control" required>
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
                        <label for="editAadharCard">Aadhar Card:</label>
                        <input type="file" id="editAadharCard" name="aadhar_card" class="form-control-file">
                        <small class="form-text text-muted">Upload a new Aadhar Card image if needed.</small>
                    </div>
                    <div class="form-group">
                        <label for="editProfilePicture">Profile Picture:</label>
                        <input type="file" id="editProfilePicture" name="profile_picture" class="form-control-file">
                        <small class="form-text text-muted">Upload a new Profile Picture if needed.</small>
                    </div>
                    <div class="form-group">
                        <label for="editClub">Club:</label>
                        <select id="editClub" name="club" class="form-control" required>
                            <?php
                            include 'db_connection.php';
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
                        <label for="editPaymentStatus">PaymentStatus:</label>
                        <input type="text" id="editPaymentStatus" name="PaymentStatus" class="form-control"
                            readonly></input>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- model for scorecard -->
<div class="modal fade" id="editScoreModal" tabindex="-1" role="dialog" aria-labelledby="editScoreModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editScoreModalLabel">Edit ScoreCard</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editScoreForm">
                    <input type="hidden" id="editPlayerId" name="player_id">
                    <div class="form-group">
                        <label for="editRuns">Runs:</label>
                        <input type="number" min="0" id="editRuns" name="Runs" class="form-control" required></input>
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
                        <input type="number" min="0" id="editno_of_hundred" name="no_of_hundred" class="form-control"
                            required></input>
                    </div>
                    <div class="form-group">
                        <label for="editno_of_fifty">no of fifty:</label>
                        <input type="number" min="0" id="editno_of_fifty" name="no_of_fifty" class="form-control"
                            required></input>
                    </div>
                    <div class="form-group">
                        <label for="editno_of_stumping">no of stumping:</label>
                        <input type="number" min="0" id="editno_of_stumping" name="no_of_stumping" class="form-control"
                            required></input>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveScoreCard">Save Changes</button>
            </div>
        </div>
    </div>
</div>



<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        // Handle click event for "Editinformation" button
        $('table').on('click', '.edit-player', function () {
            var playerId = $(this).closest('tr').find('td:first').text(); // Get the player ID
            var playerName = $(this).closest('tr').find('td:eq(1)').text(); // Get the player name
            var playerAge = $(this).closest('tr').find('td:eq(2)').text(); // Get the player age
            var playerMobile = $(this).closest('tr').find('td:eq(3)').text(); // Get the player mobile number
            var playerEmail = $(this).closest('tr').find('td:eq(4)').text(); // Get the player email
            var playerType = $(this).closest('tr').find('td:eq(5)').text(); // Get the player type
            var clubName = $(this).closest('tr').find('td:eq(10)').text();
            var playerState = $(this).closest('tr').find('td:eq(7)').text(); // Get the player state
            var playerCity = $(this).closest('tr').find('td:eq(8)').text(); // Get the player city
            var playerAddress = $(this).closest('tr').find('td:eq(9)').text();
            var playerPaymentStatus = $(this).closest('tr').find('td:eq(13)').text();


            // Get the club name

            // Populate the edit form with the player's existing information
            $('#editPlayerId').val(playerId);
            $('#editName').val(playerName);
            $('#editAge').val(playerAge);
            $('#editMobile').val(playerMobile);
            $('#editEmail').val(playerEmail);
            $('#editType').val(playerType);
            $('#editState').val(playerState);
            $('#editCity').val(playerCity);
            $('#editAddress').val(playerAddress);
            $('#editClub').val(clubName); // Set the club name value
            $('#editPaymentStatus').val(playerPaymentStatus);

            // Show the edit modala
            $('#editPlayerModal').modal('show');

        });

        // Handle form submission for saving changes
        $('#saveChangesBtn').click(function () {
            var data = {
                playerId: $('#editPlayerId').val(),
                name: $('#editName').val(),
                age: $('#editAge').val(),
                mobile: $('#editMobile').val(),
                email: $('#editEmail').val(),
                type: $('#editType').val(),
                state: $('#editState').val(),
                city: $('#editCity').val(),
                address: $('#editAddress').val(),
                club: $('#editClub').val(),
            };

            // AJAX request to update the club information
            $.ajax({
                url: "update_players.php",
                type: 'POST',
                data: data,
                success: function (response) {
                    // Handle successful update
                    console.log(response);
                    $('#editPlayerModal').modal('hide');
                    // Optionally: Refresh the page or table to show updated information
                    location.reload();
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error("Error:", status, error);
                }
            });
        });


    });

</script>
<script>
    $(document).ready(function () {
        $('table').on('click', '.edit-scorecard', function () {
            var playerId = $(this).closest('tr').find('td:first').text(); // Example of getting the player ID
            var playerRuns = $(this).closest('tr').find('td:eq(14)').text();
            var playerWicket = $(this).closest('tr').find('td:eq(15)').text();
            var playerCatches = $(this).closest('tr').find('td:eq(16)').text();
            var playerNoOfSix = $(this).closest('tr').find('td:eq(17)').text();
            var playerNoOfFour = $(this).closest('tr').find('td:eq(18)').text();
            var playerFiveWicketHall = $(this).closest('tr').find('td:eq(19)').text();
            var playerNoOfHundred = $(this).closest('tr').find('td:eq(20)').text();
            var playerNoOfFifty = $(this).closest('tr').find('td:eq(21)').text();
            var playerNoOfStumping = $(this).closest('tr').find('td:eq(22)').text();

            $('#editPlayerId').val(playerId);
            $('#editRuns').val(playerRuns);
            $('#editWicket').val(playerWicket);
            $('#editCatches').val(playerCatches);
            $('#editno_of_six').val(playerNoOfSix);
            $('#editno_of_four').val(playerNoOfFour);
            $('#editfive_wickets_hall').val(playerFiveWicketHall);
            $('#editno_of_hundred').val(playerNoOfHundred);
            $('#editno_of_fifty').val(playerNoOfFifty);
            $('#editno_of_stumping').val(playerNoOfStumping);
            // Show the scorecard edit modal
            $('#editScoreModal').modal('show');
        });

        $('#saveScoreCard').click(function () {
            // Handle scorecard update via AJAX
            var data = {
                playerId: $('#editPlayerId').val(),
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
                url: "update_scorecard.php",
                type: 'POST',
                data: data,
                success: function (response) {
                    // Handle successful update
                    console.log(response);
                    $('#editScoreModal').modal('hide');
                    // Optionally: Refresh the page or table to show updated information
                    location.reload();
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error("Error:", status, error);
                }
            });
        });

    });
</script>


<script>
    $(document).ready(function () {
        var rowsToShow = 1; // Number of rows to show per page
        var totalRows = $('#data-table tbody tr').length; // Total rows in the table
        var totalPages = Math.ceil(totalRows / rowsToShow); // Total pages needed

        // Function to display rows based on the page number
        function displayRows(page) {
            var start = (page - 1) * rowsToShow;
            var end = start + rowsToShow;

            $('#data-table tbody tr').hide().slice(start, end).show();
        }

        // Initialize the table with the first page
        displayRows(1);

        // Function to generate pagination controls
        function setupPagination(totalPages) {
            for (var i = 1; i <= totalPages; i++) {
                $('#pagination-container').append($('<a href="#" class="page-link">').text(i));
            }

            // Add click event for pagination controls
            $('.page-link').on('click', function (e) {
                e.preventDefault();
                var page = parseInt($(this).text());
                displayRows(page);
            });
        }

        // Generate pagination controls
        setupPagination(totalPages);
    });
</script>