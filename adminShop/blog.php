<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../db_connection.php'; // Change 'include' to 'require' to ensure the script stops if the file is not found.

// Add category
if (isset($_POST['title']) && isset($_FILES['blogImage'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $editor = $_POST['editor'];

    // Handle file upload
    $image = $_FILES['blogImage'];
    $imgName = $image['name'];
    $imgTmp = $image['tmp_name'];
    $imgSize = $image['size'];
    $imgError = $image['error'];

    $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
    $allowedExts = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($imgExt, $allowedExts)) {
        if ($imgError === 0) {
            if ($imgSize <= 5000000) { // Restrict the file size to 5MB
                $newImgName = uniqid('', true) . '.' . $imgExt;
                $imgDestination = '../images/blog_images/' . $newImgName;
                if (move_uploaded_file($imgTmp, $imgDestination)) {
                    // Insert into database
                    $stmt = $conn->prepare("INSERT INTO blog (title, description, editor, image) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $title, $description, $editor, $newImgName);
                    if ($stmt->execute()) {
                        // echo json_encode(["success" => "Blog added successfully.", "id" => $conn->insert_id]);
                        echo json_encode([
                            "success" => "blog added successfully.",
                            "id" => $conn->insert_id,
                            "title" => $title,
                            "image" => $newImgName,
                            "description" => $description,
                            "editor" => $editor
                        ]);

                    } else {
                        echo json_encode(["error" => "Error adding blog: " . $stmt->error]);
                    }
                    $stmt->close();
                } else {
                    echo json_encode(["error" => "Failed to move uploaded file."]);
                }
            } else {
                echo json_encode(["error" => "Image size is too large. Maximum limit is 5MB."]);
            }
        } else {
            echo json_encode(["error" => "Error uploading image."]);
        }
    } else {
        echo json_encode(["error" => "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed."]);
    }
    exit();
}


// Delete category
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM blog WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(["success" => "blog deleted successfully."]);
    } else {
        echo json_encode(["error" => "Error deleting blog: " . $stmt->error]);
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
                                <th>title</th>
                                <th>image</th>
                                <th>description</th>
                                <th>editor</th>
                                <th><button class='btn btn-primary add-btn'>Add new</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../db_connection.php';
                            $stmt = $conn->prepare("SELECT id,title,description,editor,image FROM blog");
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                                // print_r($row);
                                $id = $row['id'];
                                $title = $row['title'];
                                $description = $row['description'];
                                $editor = $row['editor'];
                                $image = $row['image'];
                                $imagePath = $image ? "../images/blog_images/{$image}" : 'path_to_default_image.jpg';
                                echo "<tr>
                                        <td>{$id}</td>
                                        <td>{$title}</td>
                                        <td><img src='{$imagePath}' style='width:100px; height:auto;'></td>
                                        <td>{$description}</td>
                                        <td>{$editor}</td>
                                        <td><button class='btn btn-success delete-btn'  data-delete-id='" . $id . "'>Delete</button></td>
                                      </tr>";
                            }
                            $stmt->close();
                            ?>
                        </tbody>
                    </table>
                    <div id="pagination-container"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addBlog" tabindex="-1" role="dialog" aria-labelledby="addBlogLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBlogLabel">Add New blog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addBlogForm">
                    <div class="card-body">
                        <form id="addBlogForm" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> Title</label>
                                        <input type="text" id="title" required name="title" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label> Editor</label>
                                        <input type="text" id="Editor" required name="Editor" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" id="blogImage" name="blogImage" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea id="description" name="area2" class="form-control"></textarea>
                                        <!-- <textarea id="description" name="description" class="form-control"></textarea> -->
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="saveChangesBtn">Save
                                        Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
            <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>
            <script>
                $(document).ready(function () {
                    var nicEditorInstance;

                    function setupNicEdit() {
                        // Initialize NicEdit for the textarea if it hasn't been initialized yet
                        if (!nicEditors.findEditor('description')) {
                            nicEditorInstance = new nicEditor().panelInstance('description');
                        }
                    }

                    function setupPagination() {
                        var rowsPerPage = 5;
                        var totalRows = $('#page1 tbody tr').length;
                        var totalPages = Math.ceil(totalRows / rowsPerPage);

                        function displayPage(page) {
                            var start = (page - 1) * rowsPerPage;
                            var end = start + rowsPerPage;
                            $('#page1 tbody tr').hide().slice(start, end).show();
                        }

                        $('#pagination-container').empty(); // Clear previous pagination links
                        for (var i = 1; i <= totalPages; i++) {
                            var link = $('<a href="#" class="page-link">').text(i).on('click', function (e) {
                                e.preventDefault();
                                displayPage($(this).text());
                            });
                            $('#pagination-container').append(link);
                        }

                        if (totalPages > 0) displayPage(1); // Display the first page
                    }

                    setupPagination();
                    // Event listener for click on edit button
                    $('body').on('click', '.add-btn', function () {
                        // Display the modal
                        $('#addBlog').modal('show');
                        $('#addBlog').on('shown.bs.modal', function () {
                            setupNicEdit();  // Initialize NicEdit when the modal is fully shown
                        });
                    });

                    $('#saveChangesBtn').click(function (e) {
                        e.preventDefault();
                        nicEditors.findEditor('description').saveContent();
                        var formData = new FormData();
                        formData.append('title', $('#title').val());
                        formData.append('editor', $('#Editor').val());
                        formData.append('description', $('#description').val());
                        formData.append('blogImage', $('#blogImage')[0].files[0]);
                        $.ajax({
                            url: "../adminShop/blog.php", // Change this URL to your actual handler script
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function (response) {

                                if (response.success) {
                                    // Handle success
                                    $('#addBlog').modal('hide');
                                    var imageSrc = response.image ? "../images/blog_images/" + response.image : 'path_to_default_image.jpg';
                                    var newRow = `<tr>
                                <td>${response.id}</td>
                                <td>${response.title}</td>
                                <td><img src="${imageSrc}" style="width:100px; height:auto;"></td>
                                <td>${response.description}</td>
                                <td>${response.editor}</td>
                                <td><button class='btn btn-success delete-btn' data-delete-id='${response.id}'>Delete</button></td>
                              </tr>`;
                                    $('#page1 tbody').append(newRow);
                                    setupPagination();
                                } else if (response.error) {
                                    alert("Error: " + response.error);
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error("Error:", status, error);
                            }
                        });

                    });
                });

                // Correctly handle the click event on dynamically added elements for deletion


                $('body').on('click', '.delete-btn', function () {
                    var button = $(this);
                    var id = button.data('delete-id');
                    var row = button.closest('tr');


                    $.ajax({
                        url: "../adminShop/blog.php",
                        type: "POST",
                        data: { id: id },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                row.fadeOut(400, function () { row.remove(); });
                                setupPagination();
                            } else {
                                alert("Failed to delete category: " + response.error);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                        }
                    });

                });
            </script>