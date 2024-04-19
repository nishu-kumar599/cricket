<?php
ob_start(); // Start output buffering
include '../db_connection.php';
if (isset($_POST['product_id'])) {
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
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Assuming you have a deletion SQL query
    $sql = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $product_id);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['error'] = "Failed to delete product";
    }

    $stmt->close();
} else {
    $response['error'] = "Product ID not provided";
}
if (isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];
    $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $orderId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => false]);
    }
    $stmt->close();
    $conn->close();
}
ob_end_flush(); // Flush the output buffer and send to client
exit();
?>