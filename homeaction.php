<?php
session_start();
$ip_add = $_SERVER['REMOTE_ADDR'];
$_SESSION['ip_add'] = $ip_add;
include "db_connection.php";

if (isset($_POST["categoryhome"])) {
	// Assuming $con is your database connection
	$category_query = "SELECT * FROM categories WHERE cat_id != 1";

	if ($stmt = $conn->prepare($category_query)) {
		$stmt->execute();
		$result = $stmt->get_result();

		// Start the navigation HTML
		echo "<div id='responsive-nav'>
                <ul class='main-nav nav navbar-nav'>
                    <li class='active'><a href='index.php'>Home</a></li>
                    <li><a href='store.php'>Electronics</a></li>";

		// Loop through categories
		while ($row = $result->fetch_assoc()) {
			$cid = $row["cat_id"];
			$cat_name = htmlspecialchars($row["cat_title"]); // Prevent XSS attacks

			// For each category, find the count of products
			$countQuery = "SELECT COUNT(*) AS count_items FROM products WHERE product_cat=?";
			if ($countStmt = $conn->prepare($countQuery)) {
				$countStmt->bind_param("i", $cid);
				$countStmt->execute();
				$countResult = $countStmt->get_result();
				$countRow = $countResult->fetch_assoc();
				$count = $countRow["count_items"];

				// Output the category with the count of products
				echo "<li class='categoryhome' cid='$cid'><a href='store.php'>$cat_name ($count)</a></li>";
			}
		}

		// Close the list and the navigation HTML
		echo "</ul></div>";

		$stmt->close();
	} else {
		echo "Error: " . $conn->error;
	}
}

// Check if "page" is set
if (isset($_POST["page"])) {
	$sql = "SELECT COUNT(*) AS total FROM products";
	if ($stmt = $con->prepare($sql)) {
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$total = $row["total"];
		$pageno = ceil($total / 2); // Assuming you want to limit to 2 products per page for pagination

		for ($i = 1; $i <= $pageno; $i++) {
			echo "<li><a href='#product-row' page='$i' id='page'>$i</a></li>";
		}
	} else {
		echo "Error preparing statement: " . $conn->error;
	}
}

// Check if "getProducthome" is set
if (isset($_POST["getProducthome"])) {
	$limit = 3;
	$pageno = isset($_POST["setPage"]) ? (int) $_POST["pageNumber"] : 1;
	$start = ($pageno - 1) * $limit;

	$sql = "SELECT p.*, c.cat_title FROM products AS p JOIN categories AS c ON p.product_cat = c.cat_id LIMIT ?, ?";
	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param("ii", $start, $limit);
		$stmt->execute();
		$result = $stmt->get_result();

		while ($row = $result->fetch_assoc()) {
			$pro_id = $row['product_id'];
			$cat_name = htmlspecialchars($row["cat_title"]); // Prevent XSS
			$pro_title = htmlspecialchars($row['product_title']);
			$pro_price = $row['product_price'];
			$Discount_price = $row['Discount_price'];
			$pro_image = htmlspecialchars($row['product_image']);

			echo "
                <div class='product-widget'>
                    <a href='product.php?p=$pro_id'> 
                        <div class='product-img'>
                            <img src='./images/product_images/$pro_image' alt=''>
                        </div>
                        <div class='product-body'>
                            <p class='product-category'>$cat_name</p>
                            <h3 class='product-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
                            <h4 class='product-price'>₹$Discount_price <del class='product-old-price'>₹$pro_price</del></h4>
                        </div>
                    </a>
                </div>
            ";
		}
	} else {
		echo "Error preparing statement: " . $conn->error;
	}
}

if (isset($_POST["gethomeProduct"])) {
	$limit = 9; // Define the number of products per page
	$start = 0; // Default start value

	// Determine the starting point for the query
	if (isset($_POST["setPage"])) {
		$pageno = (int) $_POST["pageNumber"];
		$start = ($pageno * $limit) - $limit;
	}

	// Prepared statement to fetch products in a specific range
	$sql = "SELECT p.*, c.cat_title 
            FROM products AS p 
            JOIN categories AS c ON p.product_cat = c.cat_id 
            WHERE p.product_id BETWEEN 71 AND 74 
            LIMIT ?, ?";

	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param("ii", $start, $limit);
		$stmt->execute();
		$result = $stmt->get_result();

		while ($row = $result->fetch_assoc()) {
			$pro_id = $row['product_id'];
			$cat_name = htmlspecialchars($row["cat_title"]);
			$pro_title = htmlspecialchars($row['product_title']);
			$pro_price = $row['product_price'];
			$pro_image = htmlspecialchars($row['product_image']);
			$Discount_price = $row['Discount_price'];

			// Display the product
			echo "
                <div class='col-md-3 col-xs-6'>
                    <a href='product.php?p=$pro_id'>
                        <div class='product'>
                            <div class='product-img'>
                                <img src='./images/product_images/$pro_image' style='max-height: 170px;' alt=''>
                                <div class='product-label'>
                                   
                                    <span class='new'>NEW</span>
                                </div>
                            </div>
                        </a>
                        <div class='product-body'>
                            <p class='product-category'>$cat_name</p>
                            <h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
                            <h4 class='product-price header-cart-item-info'>₹$Discount_price<del class='product-old-price'>₹$pro_price</del></h4>
                            <div class='product-rating'>
                                <i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i>
                            </div>
                            
                        </div>
                        <div class='add-to-cart'>
                            <button pid='$pro_id' id='product' class='add-to-cart-btn block2-btn-towishlist' href='#'><i class='fa fa-shopping-cart'></i> add to cart</button>
                        </div>
                    </div>
                </div>
            ";
		}
		$stmt->close();
	} else {
		echo "Error preparing statement: " . $conn->error;
	}
}

if (isset($_POST["get_seleted_Category"]) || isset($_POST["search"])) {
	if (isset($_POST["get_seleted_Category"])) {
		$id = (int) $_POST["cat_id"];
		$sql = "SELECT p.*, c.cat_title FROM products AS p JOIN categories AS c ON p.product_cat = c.cat_id WHERE p.product_cat = ?";
	} else {
		$keyword = $_POST["keyword"];
		$sql = "SELECT p.*, c.cat_title FROM products AS p JOIN categories AS c ON p.product_cat = c.cat_id WHERE p.product_keywords LIKE CONCAT('%', ?, '%')";
	}

	if ($stmt = $conn->prepare($sql)) {
		if (isset($_POST["get_seleted_Category"])) {
			$stmt->bind_param("i", $id);
		} else {
			$stmt->bind_param("s", $keyword);
		}

		$stmt->execute();
		$result = $stmt->get_result();

		while ($row = $result->fetch_assoc()) {
			$pro_id = htmlspecialchars($row['product_id']);
			$cat_name = htmlspecialchars($row["cat_title"]);
			$pro_title = htmlspecialchars($row['product_title']);
			$pro_price = htmlspecialchars($row['product_price']);
			$pro_image = htmlspecialchars($row['product_image']);

			// Display the product
			echo "
                <div class='col-md-4 col-xs-6'>
                    <a href='product.php?p=$pro_id'>
                        <div class='product'>
                            <div class='product-img'>
                                <img src='./images/product_images/$pro_image' style='max-height: 170px;' alt=''>
                                <div class='product-label'>
                                   
                                    <span class='new'>NEW</span>
                                </div>
                            </div>
                        </a>
                        <div class='product-body'>
                            <p class='product-category'>$cat_name</p>
                            <h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
                            <h4 class='product-price header-cart-item-info'>₹$Discount_price<del class='product-old-price'>₹$pro_price</del></h4>
                            <div class='product-rating'>
                                <i class='fa fa-star'></i>
                                <i class='fa fa-star'></i>
                                <i class='fa fa-star'></i>
                                <i class='fa fa-star'></i>
                                <i class='fa fa-star'></i>
                            </div>
                            
                        </div>
                        <div class='add-to-cart'>
                            <button pid='$pro_id' id='product' class='add-to-cart-btn'><i class='fa fa-shopping-cart'></i> add to cart</button>
                        </div>
                    </div>
                </div>
            ";
		}
		$stmt->close();
	} else {
		echo "Error preparing statement: " . $conn->error;
	}
}

