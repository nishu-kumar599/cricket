<?php
session_start();
include '../db_connection.php'; // Ensure this file exists and correctly initializes the database connection
error_reporting(0);

if (isset($_GET['action']) && $_GET['action'] == 'delete') {


    // Prepare to fetch product image
    $stmt = $conn->prepare("SELECT product_image FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $picture = $row['product_image'];
        $path = "../images/product_images/$picture";
        if (file_exists($path)) {
            unlink($path); // Delete the image file
        }
    }

}
// Fetch clubs from the database
$sql = "SELECT * FROM categories";
$category = $conn->query($sql);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$items_per_page = 2;
$offset = ($page - 1) * $items_per_page;
?>

<div class="container mt-5">
    <div class="col-md-14">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Products List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive ps">
                    <table class="table tablesorter" id="page1">
                        <thead class="text-primary">
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Discount Price</th>
                                <th>product category</th>
                                <th><button class='btn btn-primary edit-btn'>add New</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Pagination and fetch products
                            $stmt = $conn->prepare("SELECT product_id, product_image, product_title, product_price, Discount_price FROM products LIMIT ?, ?");
                            $stmt->bind_param("ii", $offset, $items_per_page);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr><td><img src='../images/product_images/{$row['product_image']}' style='width:50px; height:50px; border:groove #000'></td>
                                    <td>{$row['product_title']}</td>
                                    <td>{$row['product_price']}</td>
                                    <td>{$row['Discount_price']}</td>";
                                $sql = "SELECT products.*, categories.cat_title FROM products 
                                    JOIN categories ON products.product_cat = categories.cat_id WHERE products.product_id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $row['product_id']);
                                $stmt->execute();
                                $show_category = $stmt->get_result();

                                if ($show_category->num_rows > 0) {
                                    while ($categoryRow = $show_category->fetch_assoc()) {
                                        echo "<td>" . $categoryRow['cat_title'] . "</td>";
                                    }
                                }
                                echo "<td><button class='btn btn-success delete-btn'  data-delete-id='" . $row['product_id'] . "'>Delete</button></td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <nav aria-label=" Page navigation example">
            <ul class="pagination">
                <?php
                // Count total products for pagination
                $result = $conn->query("SELECT COUNT(product_id) AS total FROM products");
                $row = $result->fetch_assoc();
                $total_pages = ceil($row['total'] / $items_per_page);

                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<li class='page-item'><a class='page-link' href='../adminShop/merchandise.php?page=$i'>$i</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>
</div>


<!-- Bootstrap Modal for add merchandise -->
<div class="modal fade" id="addMerchandise" tabindex="-1" role="dialog" aria-labelledby="addMerchandiseLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMerchandiseLabel">Add New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addMerchandiseForm">
                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product Title</label>
                                    <input type="text" id="product_name" required name="product_name"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="">
                                    <label for="">Add Image</label>
                                    <input type="file" name="picture" required class="btn btn-fill" id="picture">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea rows="4" cols="80" id="details" required name="details"
                                        class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product Category</label>
                                    <!-- <input type="number" id="product_type" name="product_type" required
                                        class="form-control"> -->
                                    <select id="product_type" name="product_type" class="form-control">
                                        <?php
                                        // Check if clubs are found
                                        if ($category->num_rows > 0) {
                                            // Loop through each club and generate option elements
                                            while ($row = $category->fetch_assoc()) {
                                                echo "<option value='" . $row['cat_id'] . "'>" . $row['cat_title'] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No category found</option>";
                                        }

                                        // Close the database connection
                                        $conn->close();
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Pricing</label>
                                    <input type="number" id="price" name="price" min="0" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Discount Pricing</label>
                                    <input type="number" id="Discount_price" min="0" name="Discount_price" required
                                        class="form-control">
                                </div>
                            </div>
                        </div>
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
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>

    $(document).ready(function () {
        // Event listener for click on edit button
        $('body').on('click', '.edit-btn', function () {
            // Display the modal
            $('#addMerchandise').modal('show');
        });

        $('#saveChangesBtn').click(function (e) {
            e.preventDefault(); // Prevent the default form submission

            var formData = new FormData();
            formData.append('product_name', $('#product_name').val());
            formData.append('picture', $('#picture')[0].files[0]); // Append file input
            formData.append('details', $('#details').val());
            formData.append('product_type', $('#product_type').val());
            formData.append('price', $('#price').val());
            formData.append('Discount_price', $('#Discount_price').val());

            var data = {
                clubId: $('#product_name').val(),
                name: $('#picture').val(),
                location: $('#details').val(),
                email: $('#product_type').val(),
                panNumber: $('#price').val(),
                aadharNumber: $('#Discount_price').val(),

            };
            $.ajax({
                url: "../adminShop/addProduct.php",
                type: "POST",
                data: formData,
                contentType: false, // Necessity for FormData
                processData: false, // Necessity for FormData
                dataType: 'json', // Expect JSON response
                success: function (response) {
                    console.log(response);

                    if (response.product) {
                        var newRow = "<tr>" +
                            "<td><img src='../images/product_images/" + response.product.product_image + "' style='width:50px; height:50px; border:groove #000'></td>" +
                            "<td>" + response.product.product_title + "</td>" +
                            "<td>" + response.product.product_price + "</td>" +
                            "<td>" + response.product.Discount_price + "</td>" +
                            "<td>" + response.product.cat_title + "</td>" +
                            "<td><button class='btn btn-success delete-btn' data-delete-id='" + response.product.product_id + "'>Delete</button></td>" +
                            "</tr>";

                        $('#page1 tbody').append(newRow); // Assuming you have a tbody within your table
                        $('#addMerchandise').modal('hide');

                    } else if (response.error) {
                        console.error("Error:", response.error);
                    }
                },
                // console.log("🚀 ~ response:", response)
                error: function (xhr, status, error) {
                    console.error("Error:", status, error);
                }
            });


        });
    });
    $(document).ready(function () {
        $('body').on('click', '.delete-btn', function () {
            var button = $(this); // Capture the button that was clicked
            var product_id = button.data('delete-id'); // Get the product ID stored in the button
            var row = button.closest('tr'); // Capture the row to be potentially removed

            // Confirm before deleting
            // if (confirm('Are you sure you want to delete this product?')) {
            $.ajax({
                url: "../adminShop/deleteProduct.php",
                type: "POST",
                data: { product_id: product_id },
                dataType: 'json', // Expect JSON response
                success: function (response) {
                    console.log(response); // Log the response for debugging
                    if (response.success) {
                        row.fadeOut(400, function () {
                            row.remove();
                        });
                    } else {
                        // Log the error or display it to the user
                        alert("Failed to delete the product: " + response.error);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error:", status, error);
                }
            });
            // }
        });
    });

    $(document).ready(function () {
        // Handle pagination click
        $('body').on('click', '.pagination a', function (e) {
            e.preventDefault(); // Prevent the default hyperlink action

            var pageLink = $(this).attr('href'); // Get the URL to navigate to

            // Fetch the content from the server
            $.ajax({
                url: pageLink,
                type: "GET",
                success: function (response) {
                    // console.log(response)
                    // Assuming 'response' is the HTML content you want to display
                    // Update the part of your page that shows the product list
                    // You might need to extract only the relevant part from 'response'
                    $('#page1').html($(response).find('#page1').html());

                    // Update the pagination links similarly if needed
                    $('.pagination').html($(response).find('.pagination').html());
                },
                error: function (xhr, status, error) {
                    console.error("Error:", status, error);
                }
            });
        });
    });

</script>