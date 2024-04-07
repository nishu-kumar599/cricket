<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	require 'header.php';
	require 'head.php'; ?>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
	<link rel="stylesheet" type="text/css"
		href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
	<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<!-- <link rel="stylesheet" href="css/style1.css"> -->
	<script type="text/javascript" src="js/action.js"></script>
	<style>
		li img {
			height: 100px;
			object-fit: cover;
			width: 100%;
		}

		ul.imagespreview img {
			box-shadow: 0px 0px 2px 0px;
			object-fit: contain !important;
			width: 95%;
		}

		#imgpreview {
			height: 320px;
			object-fit: cover;
			width: 100%;
		}

		ul.imagespreview {
			list-style: none;
			padding: 0px;
		}

		.add-to-cart-btn {
			box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .2);
			border: none;
			color: #fff;
			padding: 10px;
		}

		.input-number span {
			display: inline;
			cursor: pointer;
			padding: 10px;
			border: 0px;
			border-radius: 10px;
		}

		.input-number span:hover {
			background: gray;
		}

		.product_description_cart {
			margin-top: 15px;
		}

		.product-name {
			font-family: sans-serif;
			font-weight: 700;
		}

		del.product-old-price {
			font-size: 21px;
			color: darkgray;
		}

		@media only screen and (max-width: 600px) {
			#imgpreview {
				height: 100% !important;
			}
		}
	</style>

	<!-- /BREADCRUMB -->
	<script type="text/javascript">

		jQuery(document).ready(function ($) {
			$(".scroll").click(function (event) {
				event.preventDefault();
				$('html,body').animate({ scrollTop: $(this.hash).offset().top }, 900);
			});
		});	</script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>

		; (function (global) {
			if (typeof (global) === "undefined") {
				throw new Error("window is undefined");
			}
			var _hash = "!";
			var noBackPlease = function () {
				global.location.href += "#";
				// making sure we have the fruit available for juice....
				// 50 milliseconds for just once do not cost much (^__^)
				global.setTimeout(function () {
					global.location.href += "!";
				}, 50);
			};
			// Earlier we had setInerval here....
			global.onhashchange = function () {
				if (global.location.hash !== _hash) {
					global.location.hash = _hash;
				}
			};
			global.onload = function () {
				noBackPlease();
				// disables backspace on page except on input fields and textarea..
				document.body.onkeydown = function (e) {
					var elm = e.target.nodeName.toLowerCase();
					if (e.which === 8 && (elm !== 'input' && elm !== 'textarea')) {
						e.preventDefault();
					}
					// stopping event bubbling up the DOM tree..
					e.stopPropagation();
				};
			};
		})(window);	</script>
	<script type="text/javascript" src="js/main.js"></script>
</head>

<body>
	<!-- SECTION -->
	<div class="section main main-raised">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row" id="product-row">
				<!-- Product main img -->

				<?php
				include 'db_connection.php';
				$product_id = $_GET['p'];
				if (isset($product_id)) {
					$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
					$stmt->bind_param("i", $product_id);
				} else {
					// If no specific product_id is set, select all products
					$stmt = $conn->prepare("SELECT * FROM products");
				}
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						echo '        
                                <div class="col-md-6 col-md-push-2">
									<div>
										<div>
										  <img
											id="imgpreview"
											src="./images/product_images/' . $row['product_image'] . '"
										  />
										</div>
										<div>
										  <ul class="imagespreview" style="display: flex">
											<li>
											  <img
												onclick="changeimages(src)"
												width="200px"
												src="./images/product_images/' . $row['product_image'] . '"
												alt=""
											  />
											</li>
											<li>
											  <img
												onclick="changeimages(src)"
												width="200px"
												src="./images/product_images/' . $row['product_image'] . '"
												alt=""
											  />
											</li>
											<li>
											  <img
												onclick="changeimages(src)"
												width="200px"
												src="./images/product_images/' . $row['product_image'] . '"
												alt=""
											  />
											</li>
										  </ul>
										</div>
									</div>
									</div>
                                 
									';

						?>
						<!-- FlexSlider -->

						<?php
						echo '
									
                                    
                                   
                    <div class="col-md-6">
						<div class="product-details">
							<h2 class="product-name">' . $row['product_title'] . '</h2>
							<div>
								<div class="product-rating">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star-o"></i>
								</div>
								
							</div>
							<div>
								<h3 class="product-price">$' . $row['Discount_price'] . '<del class="product-old-price">' . $row['product_price'] . '</del></h3>
								<span class="product-available">In Stock</span>
							</div>
							<p class="product_description_cart">' . $row['product_desc'] . '</p>

							

							<div class="add-to-cart">
							<div class="input-group quantity mr-3" style="width: 130px;">
    
							<div class="input-group-btn">
							<button class="btn btn-danger btn-minus qty-down">
								<i class="fa fa-minus"></i>
							</button>
						</div>
						
						<input type="text" class=" form-control w-20 text-center text-light bg-secondary quantity"  min="0" max="4" value="1" data-product-id="' . $row['product_id'] . '">
						<div class="input-group-btn">
							<button class="btn btn-danger btn-plus qty-up">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					      </div>
								<div class="btn-group" style="margin-top: 15px">
								<button class="add-to-cart-btn btn btn-danger block2-btn-towishlist" pid="' . $row['product_id'] . '" data-id="' . $row['product_id'] . '" data-product-price="' . $row['Discount_price'] . '" id="product" onclick="productAddToCart(this)">
								<i class="fa fa-shopping-cart"></i> add to cart</button>
                                </div>
							</div>
							
						</div>
						
					</div>
					
				</div>
					
				';
					}
				} ?>
				<!-- /row -->
			</div>

			<!-- /container -->

		</div>

	</div>




	<script>
		// Carousel image
		let mainimage = document.getElementById("imgpreview");
		let previmages = document.getElementsByClassName("imagespreview");

		function changeimages(src) {
			console.log(src);
			mainimage.src = src; // Directly set the src attribute
		}
		console.dir(mainimage);
		console.log(previmages);

		// Count number of product
		const quantityPlus = document.querySelector(".btn-plus"); // Use querySelector for single element
		const quantityMinus = document.querySelector(".btn-minus");
		const quantityInput = document.querySelector(".input-group .quantity"); // Directly target the input

		quantityPlus.addEventListener("click", () => {
			let currentValue = parseInt(quantityInput.value, 10);
			currentValue += 1;
			quantityInput.value = currentValue; // Update the input's value
		});

		quantityMinus.addEventListener("click", () => {
			let currentValue = parseInt(quantityInput.value, 10);
			if (currentValue > 1) { // Ensure count cannot go below 1
				currentValue -= 1;
				quantityInput.value = currentValue; // Update the input's value
			}
		});
		$(document).ready(function () {
			$('.imagespreview').slick({
				dots: true,
				infinite: true,
				speed: 300,
				slidesToShow: 1,
				adaptiveHeight: true,
				autoplay: true,
				autoplaySpeed: 2000,
			});
		});
		function productAddToCart(element) {
			var productId = $(element).data("id");
			var total_amount = $(element).data('product-price');
			var quantityInput = $('.quantity[data-product-id="' + productId + '"]');
			var quantity = quantityInput.val();
			$.ajax({
				url: 'singleAddtoCart.php', // The PHP file that processes the add to cart action
				type: 'POST',
				data: { singleaddToCart: true, proId: productId, total_amount: total_amount, quantity: quantity },
				success: function (response) {
					// Parse the JSON response from the server
					var data = JSON.parse(response);

					// Check if the product was successfully added or if an alert should be shown
					if (data.success) {
						toastr.success(data.message); // Show success message using Toastr
					} else {
						toastr.warning(data.message); // Show warning message using Toastr
					}
				},
				error: function (xhr, status, error) {
					// Handle AJAX errors
					toastr.error('An error occurred: ' + error); // Show error message using Toastr
				}
			});
		}

	</script>

</body>

</html>