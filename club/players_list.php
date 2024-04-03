<?php

session_start();

if (!isset ($_SESSION['club_id'])) {
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
// Fetch players belonging to the club from the database
$sql_players = "SELECT * FROM players WHERE club_id = ?";
$stmt_players = $conn->prepare($sql_players);
$stmt_players->bind_param("i", $club["id"]);
$stmt_players->execute();
$result_players = $stmt_players->get_result();
?>

<div class="row">
    <div class="col-md-12">

        <div class="dashboard-card">
            <div class="row">
                <div class="col-md-6">
                    <h3>Players of
                        <?php echo $club['name']; ?>
                    </h3>
                </div>
                <div class="col-md-6">
                    <form action="" method="POST">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" id="search"
                                placeholder="Search by club name..." value="" onkeyup="search_data()">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" onclick="search_data()">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <table class="table table-bordered" id="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Player Type</th>
                        <th>Image</th>
                        <th>ScoreCard</th>
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                <tbody class="search_data_coming">
                    <?php while ($row = $result_players->fetch_assoc()) {
                        $profile_picture_data = base64_encode($row['profile_picture']);
                        $profile_picture_data_url = 'data:image/jpeg;base64,' . $profile_picture_data;
                        ?>

                        <tr>
                            <td>
                                <?php echo $row['player_id']; ?>
                            </td>
                            <td>
                                <?php echo $row['name']; ?>
                            </td>
                            <td>
                                <?php echo $row['age']; ?>
                            </td>
                            <td>
                                <?php echo $row['mobile']; ?>
                            </td>
                            <td>
                                <?php echo $row['email']; ?>
                            </td>
                            <td>
                                <?php echo $row['type']; ?>
                            </td>
                            <td>
                                <?php if (!empty ($profile_picture_data_url)): ?>
                                    <img src="<?php echo htmlspecialchars($profile_picture_data_url); ?>" alt="Profile Picture"
                                        width="100">
                                <?php else: ?>
                                    <!-- Display a placeholder or nothing if the variable is not set or is empty -->
                                    <img src="" alt="Placeholder Image" width="100">
                                <?php endif; ?>
                            </td>
                            <td><button class="btn btn-primary edit-scorecard" data-toggle="modal"
                                    data-target="#editScoreModal" data-player-id="<?php echo $row['player_id']; ?>"
                                    data-runs="<?php echo $row['runs']; ?>" data-wickets="<?php echo $row['wicket']; ?>"
                                    data-catches="<?php echo $row['catches']; ?>"
                                    data-no_of_six="<?php echo $row['no_of_six']; ?>"
                                    data-no_of_four="<?php echo $row['no_of_four']; ?>"
                                    data-five_wickets_hall="<?php echo $row['five_wicket_hall']; ?>"
                                    data-no_of_hundred="<?php echo $row['no_of_hundred']; ?>"
                                    data-no_of_fifty="<?php echo $row['no_of_fifty']; ?>"
                                    data-no_of_stumping="<?php echo $row['no_of_stumping']; ?>">
                                    View
                                </button>
                            </td>
                            <!-- Add more columns as needed -->
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div id="pagination-container"></div>
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
                    <input type="hidden" id="editPlayerId" name='player_id'>
                    <div class="form-group">
                        <label for="editRuns">Runs:</label>
                        <input type="number" min="0" id="editRuns" name="Runs" class="form-control" readonly></input>
                    </div>
                    <div class="form-group">
                        <label for="editWicket">Wicket:</label>
                        <input type="number" min="0" id="editWicket" name="Wicket" class="form-control"
                            readonly></input>
                    </div>
                    <div class="form-group">
                        <label for="editCatches">Catches:</label>
                        <input type="number" min="0" id="editCatches" name="Catches" class="form-control"
                            readonly></input>
                    </div>
                    <div class="form-group">
                        <label for="editno_of_six">No of six:</label>
                        <input type="number" min="0" id="editno_of_six" name="no_of_six" class="form-control"
                            readonly></input>
                    </div>
                    <div class="form-group">
                        <label for="editno_of_four">no of four:</label>
                        <input type="number" min="0" id="editno_of_four" name="no_of_four" class="form-control"
                            readonly></input>
                    </div>
                    <div class="form-group">
                        <label for="editfive_wickets_hall">five wickets hall:</label>
                        <input type="number" min="0" id="editfive_wickets_hall" name="five_wickets_hall"
                            class="form-control" readonly></input>
                    </div>
                    <div class="form-group">
                        <label for="editno_of_hundred">no of hundred:</label>
                        <input type="number" min="0" id="editno_of_hundred" name="no_of_hundred" class="form-control"
                            readonly></input>
                    </div>
                    <div class="form-group">
                        <label for="editno_of_fifty">no of fifty:</label>
                        <input type="number" min="0" id="editno_of_fifty" name="no_of_fifty" class="form-control"
                            readonly></input>
                    </div>
                    <div class="form-group">
                        <label for="editno_of_stumping">no of stumping:</label>
                        <input type="number" min="0" id="editno_of_stumping" name="no_of_stumping" class="form-control"
                            readonly></input>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary" id="saveScoreCard">Save Changes</button> -->
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script type="text/javascript">
    function search_data() {
        const Data = $('#search').val(); // Make sure the input has an id="search"
        $.ajax({
            url: "search_club_name.php", // Point to the newly created PHP file
            type: 'POST',
            data: { search: Data, club_id: "<?php echo $club['id']; ?>" }, // Corrected data property name
            success: function (result) {
                $(".search_data_coming").html(result); // Uncomment this to output result
                if ($(".search_data_coming tr").length > 1) {
                    // Hide the second row
                    $(".search_data_coming tr").eq(1).hide();
                }
            }
        });
    }
</script>
<script>
    $(document).ready(function () {
        var rowsToShow = 4; // Number of rows to show per page
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
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $('table').on('click', '.edit-scorecard', function () {
            // Extract data from the clicked button
            var playerId = $(this).data('player-id');
            var runs = $(this).data('runs');
            var wickets = $(this).data('wickets');
            var catches = $(this).data('catches');
            var no_of_six = $(this).data('no_of_six');
            var no_of_four = $(this).data('no_of_four');
            var five_wickets_hall = $(this).data('five_wickets_hall');
            var no_of_hundred = $(this).data('no_of_hundred');
            var no_of_fifty = $(this).data('no_of_fifty');
            var no_of_stumping = $(this).data('no_of_stumping');

            // Populate modal fields
            $('#editScoreForm #editPlayerId').val(playerId);
            $('#editScoreForm #editRuns').val(runs);
            $('#editScoreForm #editWicket').val(wickets);
            $('#editScoreForm #editCatches').val(catches);
            $('#editScoreForm #editno_of_six').val(no_of_six);
            $('#editScoreForm #editno_of_four').val(no_of_four);
            $('#editScoreForm #editfive_wickets_hall').val(five_wickets_hall);
            $('#editScoreForm #editno_of_hundred').val(no_of_hundred);
            $('#editScoreForm #editno_of_fifty').val(no_of_fifty);
            $('#editScoreForm #editno_of_stumping').val(no_of_stumping);

            // Show the scorecard edit modal
            $('#editScoreModal').modal('show');
        });

    });
</script>
<?php
// Close the database connection
$stmt_players->close();
$conn->close();
?>