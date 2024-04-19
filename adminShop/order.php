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
                                    <th>Delete</th>
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
                                    <td><button class="btn btn-danger delete-btn" data-id="' . $row['order_id'] . '">Delete</button></td>
                                </tr>';
    }
    echo '
                            </tbody>
                        </table>
                        <div id="pagination-container"></div>
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

?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function () {
        // Function to refresh the table and pagination
        function refreshTableAndPagination() {
            var rowsToShow = 1; // Adjust number of rows per page as needed
            var totalRows = $('#data-table tbody tr').length; // Get total number of rows
            var totalPages = Math.ceil(totalRows / rowsToShow); // Calculate total pages

            function displayRows(page) {
                var start = (page - 1) * rowsToShow;
                var end = start + rowsToShow;
                $('#data-table tbody tr').hide().slice(start, end).show(); // Hide all rows and only show for the current page
            }

            // Clear and recreate pagination links
            $('#pagination-container').empty();
            for (var i = 1; i <= totalPages; i++) {
                var link = $('<a href="#" class="page-link">').text(i);
                $('#pagination-container').append(link);
            }

            $('.page-link').on('click', function (e) {
                e.preventDefault();
                var page = parseInt($(this).text());
                displayRows(page);
            });

            displayRows(1); // Show the first page
        }

        refreshTableAndPagination(); // Initial call to set up pagination

        $('#data-table').on('click', '.delete-btn', function () {
            var button = $(this); // Get the button that was clicked
            var orderId = button.data('id'); // Extract order ID from data-id attribute
            var row = button.closest('tr'); // Find the closest tr parent to remove later

            // if (confirm('Are you sure you want to delete this order?')) {
            $.ajax({
                url: '../adminShop/deleteProduct.php', // Correct server-side script to handle deletion
                type: 'POST',
                data: { order_id: orderId },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        row.fadeOut(400, function () {
                            $(this).remove(); // Remove the row from the DOM
                            refreshTableAndPagination(); // Refresh table and pagination after deletion
                        });
                        alert('Order deleted successfully');
                    } else {
                        alert('Error deleting order: ' + data.error);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error:", status, error);
                    alert('Failed to delete order');
                }
            });
            // }
        });
    });
</script>