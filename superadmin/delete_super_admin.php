<?php
session_start();

include '../db_connection.php';

if (isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type'];
    $id = $_GET['id'];

    switch ($type) {
        case 'club':
            $sql = "DELETE FROM clubs WHERE id = $id";
            break;
        case 'player':
            $sql = "DELETE FROM players WHERE id = $id";
            break;
        case 'association_admin':
            $sql = "DELETE FROM association_admins WHERE id = $id";
            break;
        default:
            echo "Invalid type provided.";
            header("Location: super_admin_dashboard.php");
            exit();
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: super_admin_dashboard.php");
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Type and ID parameters are required.";
}

$conn->close();
?>