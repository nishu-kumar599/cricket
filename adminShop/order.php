<?php
// Include the database connection file
include '../db_connection.php';

// Prepare the SQL query with JOIN to get product name
$sql = 'SELECT orders.*, products.product_title FROM orders JOIN products ON orders.product_id = products.product_id';

// Try preparing the SQL statement
$stmt = $conn->prepare($sql);

// Check if the preparation was successful
if ($stmt === false) {
    die("Failed to prepare statement: " . $conn->error);
}

// Execute the prepared statement
if (!$stmt->execute()) {
    die('Execute failed: ' . $stmt->error);
}

// Get the result set from the executed statement
$results = $stmt->get_result();

// Check if there are any results
if ($results->num_rows > 0) {
    echo '
    <div class="container mt-5">
        <div class="col-md-14">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Orders List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive ps">
                        <table class="table table-bordered" id="data-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Phone Number</th>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                    <th>Transaction ID</th>
                                    <th>Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>';

    // Fetch and display each order along with product name
    while ($row = $results->fetch_assoc()) {
        echo '
                                <tr>
                                    <td>' . $row['order_id'] . '</td>
                                    <td>' . $row['email'] . '</td>
                                    <td>' . $row['address'] . '</td>
                                    <td>' . $row['phoneNumber'] . '</td>
                                    <td>' . $row['product_id'] . '</td>
                                    <td>' . $row['product_title'] . '</td>
                                    <td>' . $row['qty'] . '</td>
                                    <td>' . $row['amount'] . '</td>
                                    <td>' . $row['trx_id'] . '</td>
                                    <td>' . $row['p_status'] . '</td>
                                </tr>';
    }
    echo '
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>';
} else {
    echo '<p>No orders found.</p>';
}

// Close the statement and the database connection
$stmt->close();
$conn->close();
?>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function () {
        var rowsToShow = 5; // Number of rows to show per page
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