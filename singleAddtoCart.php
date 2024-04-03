<?php
session_start();

include "db_connection.php";
$ip_add = $_SERVER['REMOTE_ADDR'];
$_SESSION['ip_add'] = $ip_add;
if (isset($_POST["singleaddToCart"])) {


    $p_id = $_POST["proId"];


    if (isset($_SESSION["uid"])) {

        $user_id = $_SESSION["uid"];

        $sql = "SELECT * FROM cart WHERE p_id = '$p_id' AND user_id = '$user_id'";
        $run_query = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($run_query);
        if ($count > 0) {
            echo json_encode(['success' => true, 'message' => 'Product is already added into the cart Continue Shopping..!']);
            exit();
        } else {
            $sql = "INSERT INTO `cart`
			(`p_id`, `ip_add`, `user_id`, `qty`) 
			VALUES ('$p_id','$ip_add','$user_id','1')";
            if (mysqli_query($conn, $sql)) {
                echo json_encode(['success' => true, 'message' => 'Product is Added..!']);
                exit();
            }
        }
    } else {
        $sql = "SELECT id FROM cart WHERE ip_add = '$ip_add' AND p_id = '$p_id' AND user_id = -1";
        $query = mysqli_query($conn, $sql);
        if (mysqli_num_rows($query) > 0) {
            echo json_encode(['success' => true, 'message' => 'Product is already added into the cart Continue Shopping..!']);
            exit();

        }
        $sql = "INSERT INTO `cart`
			(`p_id`, `ip_add`, `user_id`, `qty`) 
			VALUES ('$p_id','$ip_add','-1','1')";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['success' => true, 'message' => 'Product added to cart successfully!']);
            exit();
        }

    }




}
?>