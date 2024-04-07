<?php
session_start();

include "db_connection.php";

// $ip_add = getenv("REMOTE_ADDR");
$ip_add = $_SERVER['REMOTE_ADDR'];
$_SESSION['ip_add'] = $ip_add;
if (isset($_POST["category"])) {
	// Prepare to fetch categories
	$category_stmt = $conn->prepare("SELECT * FROM categories");
	$category_stmt->execute();
	$category_result = $category_stmt->get_result();

	echo " <div class='aside'>
            <h3 class='aside-title'>Categories</h3>
            <div class='btn-group-vertical'>";

	if ($category_result->num_rows > 0) {
		while ($category_row = $category_result->fetch_assoc()) {
			$cid = $category_row["cat_id"];
			$cat_name = $category_row["cat_title"];
			// Prepare to fetch product count for each category
			$product_stmt = $conn->prepare("SELECT COUNT(*) AS count_items FROM products WHERE product_cat=?");
			$product_stmt->bind_param("i", $cid);
			$product_stmt->execute();
			$product_result = $product_stmt->get_result();
			$product_row = $product_result->fetch_assoc();
			$count = $product_row["count_items"];

			echo "<div type='button' class='btn navbar-btn category' cid='$cid'>
                    <a href='#'>
                        <span></span>
                        $cat_name
                        <small class='qty'>($count)</small>
                    </a>
                  </div>";
		}
		echo "</div></div>";
	}
}


if (isset($_POST["page"])) {
	// Prepare and execute query to count total products
	$stmt = $conn->prepare("SELECT COUNT(*) as count FROM products");
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	$count = $row['count'];

	// Calculate the total number of pages
	$itemsPerPage = 9; // Set how many items you want per page
	$totalPages = ceil($count / $itemsPerPage);

	// Generate pagination links
	for ($i = 1; $i <= $totalPages; $i++) {
		echo "<li><a href='#product-row' data-page='$i' class='page-link'>$i</a></li>";
	}

}
// <------chatgpt code----->

if (isset($_POST["getProduct"])) {
	$limit = 9;
	$pageno = $_POST["pageNumber"] ?? 1; // Default to the first page
	$start = ($pageno - 1) * $limit;

	$product_query = "SELECT products.*, categories.cat_title FROM products INNER JOIN categories ON products.product_cat=categories.cat_id LIMIT ?, ?";
	$stmt = $conn->prepare($product_query);
	$stmt->bind_param("ii", $start, $limit);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$pro_id = htmlspecialchars($row['product_id']);
			$pro_title = htmlspecialchars($row['product_title']);
			$pro_price = htmlspecialchars($row['product_price']);
			$pro_image = htmlspecialchars($row['product_image']);
			$cat_name = htmlspecialchars($row["cat_title"]);
			$Discount_price = htmlspecialchars($row["Discount_price"]);

			// Assuming you have a folder named 'product_images' at the root of your project
			$imagePath = "./images/product_images/$pro_image";

			// Displaying each product
			echo "
                <div class='col-md-4 col-xs-6'>
                    <a href='product.php?p=$pro_id'>
                        <div class='product'>
                            <div class='product-img'>
                                <img src='$imagePath' style='max-height: 170px;' alt=''>
                                <div class='product-label'>
                                   
                                    <span class='new'>NEW</span>
                                </div>
                            </div>
                    </a>
                    <div class='product-body'>
                        <p class='product-category'>$cat_name</p>
                        <h3 class='product-name header-cart-item-name'>$pro_title</h3>
                        <h4 class='product-price header-cart-item-info'>$Discount_price<del class='product-old-price'>$pro_price</del></h4>
                        <div class='product-rating'>
                            <i class='fa fa-star'></i>
                            <i class='fa fa-star'></i>
                            <i class='fa fa-star'></i>
                            <i class='fa fa-star'></i>
                            <i class='fa fa-star'></i>
                        </div>
                        
                    </div>
                    <div class='add-to-cart'>
                        <button pid='$pro_id' id='product' total_amount='$Discount_price' class='add-to-cart-btn ' href='#'><i class='fa fa-shopping-cart'></i> add to cart</button>
                    </div>
                </div>
            </div>
            ";
		}
	} else {
		echo "<p>No products found.</p>";
	}

}
if (isset($_POST["get_seleted_Category"]) || isset($_POST["selectBrand"]) || isset($_POST["search"])) {
	$sql = ""; // Initialize SQL query variable

	if (isset($_POST["get_seleted_Category"])) {
		$id = intval($_POST["cat_id"]); // Convert to integer to avoid SQL injection
		$sql = "SELECT products.*, categories.cat_title FROM products JOIN categories ON products.product_cat = categories.cat_id WHERE product_cat = ?";
	} elseif (isset($_POST["selectBrand"])) {
		$id = intval($_POST["brand_id"]); // Convert to integer to avoid SQL injection
		$sql = "SELECT products.*, categories.cat_title FROM products JOIN categories ON products.product_cat = categories.cat_id WHERE product_brand = ?";
	} elseif (isset($_POST["search"])) {
		$keyword = $_POST["keyword"];
		$sql = "SELECT products.*, categories.cat_title FROM products JOIN categories ON products.product_cat = categories.cat_id WHERE product_keywords LIKE CONCAT('%', ?, '%')";
	}

	if ($sql) { // Check if SQL query is set
		$stmt = $conn->prepare($sql);
		if (isset($keyword)) {
			$stmt->bind_param("s", $keyword); // Bind parameters for search case
		} else {
			$stmt->bind_param("i", $id); // Bind parameters for category or brand case
		}
		$stmt->execute();
		$result = $stmt->get_result();

		while ($row = $result->fetch_assoc()) {
			// Extract and escape variables to prevent XSS attacks
			$pro_id = htmlspecialchars($row['product_id']);
			$pro_title = htmlspecialchars($row['product_title']);
			$pro_price = htmlspecialchars($row['product_price']);
			$pro_image = htmlspecialchars($row['product_image']);
			$cat_name = htmlspecialchars($row["cat_title"]);
			$Discount_price = htmlspecialchars($row["Discount_price"]);
			// Assuming you have a folder named 'product_images' at the root of your project
			$imagePath = "./images/product_images/$pro_image";
			// Display products
			echo "
                <div class='col-md-4 col-xs-6'>
                    <a href='product.php?p=$pro_id'>
                        <div class='product'>
                            <div class='product-img'>
							<img src='$imagePath' style='max-height: 170px;' alt=''>
                                <div class='product-label'>
                                  
                                    <span class='new'>NEW</span>
                                </div>
                            </div>
                    </a>
                    <div class='product-body'>
                        <p class='product-category'>$cat_name</p>
                        <h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
                        <h4 class='product-price header-cart-item-info'>$Discount_price<del class='product-old-price'>$pro_price</del></h4>
                        <div class='product-rating'>
                            <i class='fa fa-star'></i>
                            <i class='fa fa-star'></i>
                            <i class='fa fa-star'></i>
                            <i class='fa fa-star'></i>
                            <i class='fa fa-star'></i>
                        </div>
                      
                    </div>
                    <div class='add-to-cart'>
                        <button pid='$pro_id' id='product' total_amount='$Discount_price' class='add-to-cart-btn'><i class='fa fa-shopping-cart'></i> add to cart</button>
                    </div>
                </div>
            </div>
            ";
		}

	}
	$conn->close();
}


if (isset($_POST["addToCart"])) {
	$p_id = $_POST["proId"];
	$total_amount = $_POST["total_amount"];

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
			(`p_id`, `ip_add`, `user_id`, `qty`,`Total_amount`) 
			VALUES ('$p_id','$ip_add','$user_id','1','$total_amount')";
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
			(`p_id`, `ip_add`, `user_id`, `qty`,`Total_amount`) 
			VALUES ('$p_id','$ip_add','-1','1','$total_amount')";
		if (mysqli_query($conn, $sql)) {
			echo json_encode(['success' => true, 'message' => 'Product added to cart successfully!']);
			exit();
		}

	}
}


//Count User cart item
if (isset($_POST["count_item"])) {
	// Prepare SQL based on whether the user is logged in or not
	if (isset($_SESSION["uid"])) {
		$sql = "SELECT COUNT(*) AS count_item FROM cart WHERE user_id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("i", $_SESSION['uid']);
	} else {
		$sql = "SELECT COUNT(*) AS count_item FROM cart WHERE ip_add = ? AND user_id < 0";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $ip_add);
	}

	// Execute the query
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	echo $row["count_item"];
	$stmt->close();
	exit();
}
//Count User cart item


//Get Cart Item From Database to Dropdown menu
// Check for common request
if (isset($_POST["Common"])) {
	$userId = isset($_SESSION["uid"]) ? $_SESSION["uid"] : -1;
	$ip_add = $_SESSION['ip_add']; // Get the IP address for guest carts

	// SQL query to fetch cart items for either a logged-in user or a guest based on IP
	$sql = "SELECT a.product_id, a.product_desc,a.product_title, a.Discount_price,a.product_price, a.product_image, b.p_id, b.id, b.qty ,b.Total_amount
            FROM products a 
            JOIN cart b ON a.product_id = b.p_id 
            WHERE (? > 0 AND b.user_id = ?) OR (? <= 0 AND b.ip_add = ?)";

	$stmt = $conn->prepare($sql);
	$stmt->bind_param("isis", $userId, $userId, $userId, $ip_add);
	$stmt->execute();
	$result = $stmt->get_result();

	if (isset($_POST["getCartItem"]) && $result->num_rows > 0) {
		$n = 0;
		$total_price = 0;
		while ($row = $result->fetch_assoc()) {
			$n++;
			$product_id = htmlspecialchars($row["product_id"]);
			$product_title = htmlspecialchars($row["product_title"]);
			$product_desc = htmlspecialchars($row["product_desc"]);
			$product_price = htmlspecialchars($row["product_price"]);
			$product_image = htmlspecialchars($row["product_image"]);
			$cart_item_id = htmlspecialchars($row["id"]);
			$qty = htmlspecialchars($row["qty"]);
			$Discount_price = $row["Discount_price"];
			$total_price += $Discount_price;
			$total_amount = $row['Total_amount'];

			echo '
                <div class="product-widget">
                    <div class="product-img">
                        <img src="../product_images/' . $product_image . '" alt="">
                    </div>
                    <div class="product-body">
                        <h3 class="product-name"><a href="#">' . $product_title . '</a></h3>
                        <h4 class="product-price"><span class="qty">' . $n . '</span>$' . $Discount_price . '</h4>
                    </div>
                </div>
            ';
		}
		echo '
            <div class="cart-summary">
                <small>' . $n . ' Item(s) selected</small>
                <h5>₹' . $total_price . '</h5>
            </div>
        ';
	}

	if (isset($_POST["checkOutDetails"])) {

		if ($result->num_rows > 0) {
			//display user cart item with "Ready to checkout" button if user is not login
			echo '<div class="main ">
			<div class="table-responsive">
			<form method="post" action="userDetail.php">
			
	               <table id="cart" class="table table-hover table-condensed" id="">
    				<thead>
						<tr>
							<th style="width:50%">Product</th>
							<th style="width:10%">Price</th>
							<th style="width:8%">Quantity</th>
							<th style="width:7%" class="text-center">Subtotal</th>
							<th style="width:10%"></th>
						</tr>
					</thead>
					<tbody>
                    ';
			$n = 0;
			while ($row = $result->fetch_assoc()) {
				$n++;
				$product_id = $row["product_id"];
				$product_title = $row["product_title"];
				$product_desc = $row["product_desc"];
				$product_price = $row["product_price"];
				$product_image = $row["product_image"];
				$cart_item_id = $row["id"];
				$Discount_price = $row["Discount_price"];
				$qty = $row["qty"];
				$total_amount = $row['Total_amount'];
				$p_id = $row["p_id"];
				$_SESSION['product_id'] = $p_id;
				$_SESSION['total_price'] = $total_amount;
				$_SESSION['qty'] = $qty;
				echo '<tr>
        <td data-th="Product">
            <div class="row">
                <div class="col-sm-4"><img src="./images/product_images/' . $product_image . '" style="height: 70px;width:75px;"/>
                    <h4 class="nomargin product-name header-cart-item-name"><a href="product.php?p=' . $product_id . '">' . $product_title . '</a></h4>
                </div>
                <div class="col-sm-6">
                    <div style="max-width=50px;">
                        <p>' . $product_desc . '</p>
                    </div>
                </div>
            </div>
        </td>
        <input type="hidden" name="product_id[]" value="' . $product_id . '"/>
        <input type="hidden" name="" value="' . $cart_item_id . '"/>
        <td data-th="Price"><input type="text" class="form-control price" value="' . $Discount_price . '" readonly="readonly"></td>
        <td data-th="Quantity">
		<input type="text" class="form-control qty" value="' . $qty . '" id="quantityInput' . $product_id . '" data-product-id="' . $product_id . '" data-product-price="' . $Discount_price . '" onChange="handleQuantityChange(event);">
        </td>
        <td data-th="Subtotal" class="text-center">
            <input type="text" class="form-control total" value="' . $product_price . '" readonly="readonly"></td>
        <td class="actions" data-th="">
            <a href="#" class="btn btn-info btn-sm update" update_id="' . $product_id . '"><i class="fa fa-refresh"></i></a>
            <a href="#" class="btn btn-danger btn-sm remove" remove_id="' . $product_id . '"><i class="fa fa-trash"></i></a>
        </td>
    </tr>
';

			}

			echo '</tbody>
				<tfoot>
					
					<tr>
						<td><a href="store.php" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
						<td colspan="2" class="hidden-xs"></td>
						<td class="hidden-xs text-center"><b class="net_total" ></b></td>
						<div id="issessionset"></div>
                        <td>
							
							';
			if (!isset($_SESSION["uid"])) {
				echo '
					
							<button type="submit" class="btn btn-success">Ready to Checkout</button></td>
								</tr>
							</tfoot>
				
							</table></div></div>';
			} else if (isset($_SESSION["uid"])) {
				//Paypal checkout form
				echo '
					</form>
					
						<form action="userDetail.php" method="post">
							<input type="hidden" name="cmd" value="_cart">
							<input type="hidden" name="business" value="shoppingcart@puneeth.com">
							<input type="hidden" name="upload" value="1">';

				$x = 0;
				$userId = $_SESSION["uid"];

				// Prepare the SQL statement to fetch cart items for the logged-in user
				$stmt = $conn->prepare("SELECT a.product_id, a.product_title, a.product_price, a.product_image, b.id AS cart_item_id, b.qty FROM products a INNER JOIN cart b ON a.product_id = b.p_id WHERE b.user_id = ?");
				$stmt->bind_param("i", $userId);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$x++;
					echo

						'<input type="hidden" name="total_count" value="' . $x . '">
									<input type="hidden" name="item_name_' . $x . '" value="' . $row["product_title"] . '">
								  	 <input type="hidden" name="item_number_' . $x . '" value="' . $x . '">
								     <input type="hidden" name="amount_' . $x . '" value="' . $row["product_price"] . '">
								     <input type="hidden" name="quantity_' . $x . '" value="' . $row["qty"] . '">';
				}

				echo
					'<input type="hidden" name="return" value="http://localhost/myfiles/public_html/payment_success.php"/>
					                <input type="hidden" name="notify_url" value="http://localhost/myfiles/public_html/payment_success.php">
									<input type="hidden" name="cancel_return" value="http://localhost/myfiles/public_html/cancel.php"/>
									<input type="hidden" name="currency_code" value="USD"/>
									<input type="hidden" name="custom" value="' . $_SESSION["uid"] . '"/>
									<input type="submit" id="submit" name="login_user_with_product" name="submit" class="btn btn-success" value="Ready to Checkout">
									</form></td>
									
									</tr>
									
									</tfoot>
									
							</table></div></div>    
								';
			}
		}
	}


}

// Remove Item From cart
if (isset($_POST["removeItemFromCart"])) {
	$remove_id = $_POST["rid"];
	// Check if user is logged in
	if (isset($_SESSION["uid"])) {
		$user_id = $_SESSION["uid"];
		$sql = "DELETE FROM cart WHERE p_id = ? AND user_id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ii", $remove_id, $user_id);
	} else {
		// When user is not logged in, use a unique identifier stored in session or cookie
		$ip_add = $_SESSION['ip_add']; // Make sure you have a mechanism to assign a unique identifier to each user
		$sql = "DELETE FROM cart WHERE p_id = ? AND ip_add = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("is", $remove_id, $ip_add);
	}

	if ($stmt->execute()) {
		echo "<div class='alert alert-danger'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <b>Product is removed from cart</b>
              </div>";
	} else {
		// Optionally handle the error case if needed
		echo "<div class='alert alert-warning'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <b>There was a problem removing the product from the cart</b>
              </div>";
	}
	$stmt->close();
	exit();
}

// Update Item From Cart
if (isset($_POST["updateCartItem"])) {
	$update_id = $_POST["update_id"];
	$qty = $_POST["qty"];

	$condition = isset($_SESSION["uid"]) ? "user_id = '$_SESSION[uid]'" : "ip_add = '$ip_add'";
	$sql = "UPDATE cart SET qty='$qty' WHERE p_id = '$update_id' AND $condition";

	if (mysqli_query($conn, $sql)) {
		echo "<div class='alert alert-info'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <b>Product is updated</b>
        </div>";
		exit();
	}
}

if (isset($_POST["newQty"])) {
	$qty = $_POST["newQty"];
	$update_id = $_POST['product_id'];
	$total_amount = $_POST['total_amount'];
	$net_total = $total_amount * $qty;
	$condition = isset($_SESSION["uid"]) ? "user_id = '$_SESSION[uid]'" : "ip_add = '$ip_add'";
	$sql = "UPDATE cart SET qty='$qty',Total_amount='$net_total' WHERE p_id = '$update_id' AND $condition";
	if (mysqli_query($conn, $sql)) {
		echo "<div class='alert alert-info'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <b>quantity is updated</b>
        </div>";
		exit();
	}
}



?>