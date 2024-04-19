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
        <div class="row">
            <div class="col-md-6">
                <h2>Clubs</h2>
            </div>
            <div class="col-md-6">
                <form action="" method="POST"> <!-- Using GET method for simplicity and bookmarkable URLs -->
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

        <div class=" table-responsive">
            <table class="table table-bordered table-striped" id="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Email</th>
                        <th>PAN Number</th>
                        <th>Aadhar Number</th>
                        <th>Club Director Name</th>
                        <th>Club Secretary Name</th>
                        <th>Contact Number</th>
                        <th>paymentStatus</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="search_data_coming">
                    <?php
                    if ($result_clubs->num_rows > 0) {
                        while ($row = $result_clubs->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['clubid'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['location'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['pan_number'] . "</td>";
                            echo "<td>" . $row['aadhar_number'] . "</td>";
                            echo "<td>" . $row['club_director_name'] . "</td>";
                            echo "<td>" . $row['club_secretary_name'] . "</td>";
                            echo "<td>" . $row['contact_number'] . "</td>";
                            echo "<td>" . $row['payment_status'] . "</td>";
                            echo "<td><button class='btn btn-primary edit-btn' data-club-id='" . $row['id'] . "'>Edit</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No clubs found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div id="pagination-container"></div>
        </div>
    </div>

    <!-- Bootstrap Modal for Editing Player -->
    <!-- Bootstrap Modal for Editing Player -->
    <div class="modal fade" id="editPlayerModal" tabindex="-1" role="dialog" aria-labelledby="editPlayerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPlayerModalLabel">Edit Club Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    $(document).ready(function () {
        // Event listener for click on edit button
        $('body').on('click', '.edit-btn', function () {
            // Extract data from the table row where the edit button was clicked
            var clubId = $(this).data('club-id'); // Assuming data-club-id attribute is used
            var rowData = $(this).closest('tr').children('td').map(function () {
                return $(this).text();
            }).get();

            // Assigning extracted values to the modal inputs
            $('#clubId').val(rowData[0]);
            $('#editName').val(rowData[1]);
            $('#editLocation').val(rowData[2]);
            $('#editEmail').val(rowData[3]);
            $('#editPANNumber').val(rowData[4]);
            $('#editAadharNumber').val(rowData[5]);
            $('#editClubDirectorName').val(rowData[6]);
            $('#editClubSecretaryName').val(rowData[7]);
            $('#editMobile').val(rowData[8]);
            $('#editPaymentStatus').val(rowData[9]);

            // Display the modal
            $('#editPlayerModal').modal('show');
        });

        // Event listener for save changes button within the modal
        $('#saveChangesBtn').click(function () {
            // Fetching updated data from modal inputs
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

            // AJAX request to update the club information
            $.ajax({
                url: "update_club.php",
                type: 'POST',
                data: data,
                success: function (response) {
                    // Handle successful update
                    console.log(response);
                    // Update the corresponding table row with new data
                    var tableRow = $('#data-table tbody tr td:first-child:contains(' + data.clubId + ')').closest('tr');
                    tableRow.find('td:eq(1)').text(data.name);
                    tableRow.find('td:eq(2)').text(data.location);
                    tableRow.find('td:eq(3)').text(data.email);
                    tableRow.find('td:eq(4)').text(data.panNumber);
                    tableRow.find('td:eq(5)').text(data.aadharNumber);
                    tableRow.find('td:eq(6)').text(data.directorName);
                    tableRow.find('td:eq(7)').text(data.secretaryName);
                    tableRow.find('td:eq(8)').text(data.mobile);
                    $('#editPlayerModal').modal('hide');
                    // Optionally: Refresh the page or table to show updated information
                    // location.reload();
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error("Error:", status, error);
                }
            });
        });
    });

    function search_data() {
        const Data = $('#search').val(); // Make sure the input has an id="search"
        $.ajax({
            url: "search_clubs.php", // Point to the newly created PHP file
            type: 'POST',
            data: { search: Data }, // Corrected data property name
            success: function (result) {
                $(".search_data_coming").html(result); // Uncomment this to output result
                if ($(".search_data_coming tr").length > 1) {
                    // Hide the second row
                    $(".search_data_coming tr").eq(1).hide();
                }
            }
        });
    }

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

</html>