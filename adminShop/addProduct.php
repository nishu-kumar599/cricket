<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db_connection.php';

$response = [];

$product_name = $_POST['product_name'] ?? '';
$details = $_POST['details'] ?? '';
$price = $_POST['price'] ?? 0;
$product_type = $_POST['product_type'] ?? '';
$Discount_price = $_POST['Discount_price'] ?? 0;

if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
    $picture_name = $_FILES['picture']['name'];
    $picture_tmp_name = $_FILES['picture']['tmp_name'];
    $picture_size = $_FILES['picture']['size'];
    $picture_type = $_FILES['picture']['type'];

    // Validate picture type and size
    $allowed_types = ["image/jpeg", "image/jpg", "image/png", "image/gif"];
    if (in_array($picture_type, $allowed_types)) {
        if ($picture_size <= 50000000) { // 50 MB
            $pic_name = time() . "_" . preg_replace("/\s+/", "_", $picture_name);
            $upload_path = "../images/product_images/" . $pic_name;

            if (move_uploaded_file($picture_tmp_name, $upload_path)) {
                $stmt = $conn->prepare("INSERT INTO `products`(`product_cat`, `product_title`, `product_price`, `Discount_price`, `product_desc`, `product_image`) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("isiiss", $product_type, $product_name, $price, $Discount_price, $details, $pic_name);
                if ($stmt->execute()) {
                    $category_stmt = $conn->prepare("SELECT cat_title FROM categories WHERE cat_id = ?");
                    $category_stmt->bind_param("i", $product_type);
                    $category_stmt->execute();
                    $category_result = $category_stmt->get_result();
                    $category_row = $category_result->fetch_assoc();
                    $cat_title = $category_row['cat_title'];
                    $response['success'] = "Product added successfully.";
                    $response['product'] = [
                        'product_id' => $conn->insert_id,
                        'product_title' => $product_name,
                        'product_price' => $price,
                        'Discount_price' => $Discount_price,
                        'cat_title' => $cat_title, // Assuming this is what you mean by category title; you might need to fetch the actual category title based on $product_type
                        'product_image' => $pic_name
                    ];
                } else {
                    $response['error'] = "Error adding product: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $response['error'] = "Failed to upload image.";
            }
        } else {
            $response['error'] = "Image size should be less than 50MB.";
        }
    } else {
        $response['error'] = "Invalid image type. Only JPEG, JPG, PNG, and GIF are allowed.";
    }
} else {
    $response['error'] = "Please upload an image for the product.";
}

$conn->close();
echo json_encode($response);
?>