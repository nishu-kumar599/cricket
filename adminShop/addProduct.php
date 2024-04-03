<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db_connection.php';

// Assuming the database connection is established in db_connection.php

$product_name = $_POST['product_name'] ?? '';
$details = $_POST['details'] ?? '';
$price = $_POST['price'] ?? 0;
$product_type = $_POST['product_type'] ?? '';
$Discount_price = $_POST['Discount_price'] ?? 0;
// No brand and tags variable in provided code, ensure these are declared appropriately
$brand = '';
$tags = '';

// Picture processing
if (isset ($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
    $picture_name = $_FILES['picture']['name'];
    $picture_type = $_FILES['picture']['type'];
    $picture_tmp_name = $_FILES['picture']['tmp_name'];
    $picture_size = $_FILES['picture']['size'];

    // Validate picture type and size
    if (in_array($picture_type, ["image/jpeg", "image/jpg", "image/png", "image/gif"])) {
        if ($picture_size <= 50000000) { // 50 MB
            $pic_name = time() . "_" . $picture_name;
            $upload_path = "../images/product_images/" . $pic_name;

            if (move_uploaded_file($picture_tmp_name, $upload_path)) {
                // Prepare an SQL statement to prevent SQL injection
                $stmt = $conn->prepare("INSERT INTO `products`(`product_cat`, `product_title`, `product_price`, `Discount_price`, `product_desc`, `product_image`) VALUES (?, ?, ?, ?, ?, ?)");
                // Bind parameters
                $stmt->bind_param("isiiss", $product_type, $product_name, $price, $Discount_price, $details, $pic_name);

                // Execute the statement
                if ($stmt->execute()) {
                    echo "Product added successfully.";
                } else {
                    echo "Error adding product: " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
            } else {
                echo "Failed to upload image.";
            }
        } else {
            echo "Image size should be less than 50MB.";
        }
    } else {
        echo "Invalid image type. Only JPEG, JPG, PNG, and GIF are allowed.";
    }
} else {
    echo "Please upload an image for the product.";
}

// Close database connection
$conn->close();
?>