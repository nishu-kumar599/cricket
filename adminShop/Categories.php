<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../db_connection.php'; // Change 'include' to 'require' to ensure the script stops if the file is not found.

// Add category
if (isset ($_POST['add_category'])) {
    $category = $_POST['add_category'];
    $stmt = $conn->prepare("INSERT INTO categories (cat_title) VALUES (?)");
    $stmt->bind_param("s", $category);
    if ($stmt->execute()) {
        echo json_encode(["success" => "Category added successfully."]);
    } else {
        echo json_encode(["error" => "Error adding category: " . $stmt->error]);
    }
    $stmt->close();
    exit();
}

// Delete category
if (isset ($_POST['category_id'])) {
    $categoryId = $_POST['category_id'];
    $stmt = $conn->prepare("DELETE FROM categories WHERE cat_id = ?");
    $stmt->bind_param("i", $categoryId);
    if ($stmt->execute()) {
        echo json_encode(["success" => "Category deleted successfully."]);
    } else {
        echo json_encode(["error" => "Error deleting category: " . $stmt->error]);
    }
    $stmt->close();
    exit();
}
$conn->close();
?>

<div class="container mt-5">
    <div class="col-md-14">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Categories List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive ps">
                    <table class="table tablesorter" id="page1">
                        <thead class="text-primary">
                            <tr>
                                <th>ID</th>
                                <th>Categories</th>
                                <th><button class='btn btn-primary add-btn'>Add new</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../db_connection.php';
                            $stmt = $conn->prepare("SELECT cat_id, cat_title FROM categories");
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                                $cat_id = $row['cat_id'];
                                $cat_title = $row['cat_title'];
                                echo "<tr>
                                        <td>{$cat_id}</td>
                                        <td>{$cat_title}</td>
                                        <td><button class='btn btn-success delete-btn'  data-delete-id='" . $cat_id . "'>Delete</button></td>
                                      </tr>";
                            }
                            $stmt->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryLabel">Add New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Add category</label>
                                    <input type="text" id="add_category" required name="add_category"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
                            </div>
                        </div>
                    </div>
            </div>
            <script>
                $(document).ready(function () {
                    // Event listener for click on edit button
                    $('body').on('click', '.add-btn', function () {
                        // Display the modal
                        $('#addCategory').modal('show');
                    });

                    $('#saveChangesBtn').click(function (e) {
                        e.preventDefault(); // Prevent the default form submission

                        var formData = new FormData();
                        formData.append('add_category', $('#add_category').val());
                        $.ajax({
                            url: "../adminShop/Categories.php",
                            type: "POST",
                            data: formData,
                            contentType: false, // Necessity for FormData
                            processData: false, // Necessity for FormData
                            success: function (response) {
                                console.log(response);
                                $('#addCategory').modal('hide');
                                location.reload();
                            },
                            error: function (xhr, status, error) {
                                console.error("Error:", status, error);
                            }
                        });
                    });
                });
                // Correctly handle the click event on dynamically added elements for deletion
                $('body').on('click', '.delete-btn', function () {
                    var categoryId = $(this).data('delete-id');
                    if (confirm('Are you sure you want to delete this category?')) {
                        $.ajax({
                            url: "../adminShop/Categories.php", // Make sure this URL is correct
                            type: "POST",
                            data: { category_id: categoryId },
                            success: function (response) {
                                console.log(response); // Debugging line
                                let res = JSON.parse(response);
                                if (res.success) {
                                    console.log(res.success);
                                } else {
                                    console.log(res.error || "An unexpected error occurred");
                                }
                                location.reload();
                            },
                            error: function (xhr, status, error) {
                                console.error("AJAX Error:", status, error);
                            }
                        });
                    }
                });
                // });
            </script>