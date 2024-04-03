<?php
ob_start(); // Start output buffering
include '../db_connection.php';
if (isset ($_POST['product_id'])) {
    $productid = $_POST['product_id'];
    // Prepare to delete the product
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $productid);
    $executed = $stmt->execute();
    header('Content-Type: application/json');
    if ($executed) {
        echo json_encode(["success" => 'product has been deleted']);
    } else {
        echo json_encode(["error" => false, "message" => $stmt->error]);
    }
}
ob_end_flush(); // Flush the output buffer and send to client
exit();
?>