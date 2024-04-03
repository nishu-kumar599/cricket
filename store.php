<!DOCTYPE html>
<html lang="en">

<head>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/action.js"></script>
    <?php
    require 'head.php'; ?>
    <link rel="stylesheet" href="css/style1.css">

    <style>
        /* Custom styling */

        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }



        .sports-news {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
        }

        .options {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .option {
            background-color: #fd1e50;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .option:hover {
            background-color: #d90c3f;
            color: #fff;
        }

        .main-raised {
            width: 100%;
            margin-top: 30px;
        }

        div#get_product {
            display: contents;
        }

         .store-grid .badge {
            position: absolute;
            right: 18px;
            top: -31px;
            width: 20px;
            height: 20px;
            line-height: 20px;
            text-align: center;
            border-radius: 50%;
            font-size: 10px;
            color: #fff;
            background-color: #d10024;
        }

        .store-grid .fa-shopping-cart {
            margin-top: -14px;
            margin-left: 18px;
            position: absolute;
        }
    </style>
</head>

<body>
    <?php require 'header.php'; ?>
    <div class="main-content">

        <div class="section">
            <!-- container -->
            <div class="container">

                <div class="row">
                    <div class="main main-raised">
                        <!-- row -->
                        <div class="row" style="padding: 10px;">
                            <!-- ASIDE -->
                            <div id="aside" class="col-md-3">
                                <!-- aside Widget -->
                                <div id="get_category" style="display:content;">
                                    <div class="row"></div>
                                </div>

                                <!-- aside Widget -->
                                <div class="aside">
                                    <h3 class="aside-title">Top selling</h3>
                                    <div id="get_product_home">
                                        <!-- product widget -->

                                        <!-- product widget -->
                                    </div>
                                </div>
                                <!-- /aside Widget -->
                            </div>
                            <!-- /ASIDE -->

                            <!-- STORE -->
                            <div id="store" class="col-md-9">
                                <!-- store top filter -->
                                <div class="store-filter clearfix">
                                    <div class="store-sort">
                                        <label>
                                            Sort By:
                                            <select class="input-select">
                                                <option value="0">Popular</option>
                                                <option value="1">Position</option>
                                            </select>
                                        </label>

                                        <label>
                                            Show:
                                            <select class="input-select">
                                                <option value="0">20</option>
                                                <option value="1">50</option>
                                            </select>
                                        </label>
                                    </div>
                                    <ul class="store-grid">
                                        <!-- Cart -->
                                        <div class="header-ctn">


                                            <!-- Cart -->
                                            <a href='cart.php' class="dropdown"
                                                onclick="onClick('cart.php')">
                                                <div class="dropdown">
                                                    <!-- <a class="dropdown" data-toggle="dropdown" aria-expanded="true"
                                                        onClick={this.onClickDoSomething}> -->
                                                    <i class="fa fa-shopping-cart"></i>
                                                    <span>Your Cart</span>
                                                    <div class="badge qty">2</div>

                                                    <!-- </a> -->
                                                </div>
                                            </a>
                                            <!-- /Cart -->

                                            <!-- Menu Toogle -->
                                            <div class="menu-toggle">
                                                <a href="#">
                                                    <i class="fa fa-bars"></i>
                                                    <span>Menu</span>
                                                </a>
                                            </div>
                                            <!-- /Menu Toogle -->
                                        </div>
                                    </ul>
                                </div>


                                <!-- store products -->
                                <div class="row" id="product-row">
                                    <div class="col-md-12 col-xs-12" id="product_msg">
                                    </div>
                                    <!-- product -->
                                    <div id="get_product">
                                        <div class="row">

                                        </div>
                                        <!--Here we get product jquery Ajax Request-->
                                    </div>

                                    <!-- /product -->
                                </div>
                                <!-- /store products -->

                                <!-- store bottom filter -->
                                <div class="store-filter clearfix">
                                    <span class="store-qty">Showing 20-100 products</span>
                                    <ul class="store-pagination" id="pageno">
                                        <li><a class="active" href="#aside">1</a></li>

                                        <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                    </ul>
                                </div>
                                <!-- /store bottom filter -->
                            </div>
                        </div>
                        <!-- /STORE -->
                    </div>
                    <!-- /row -->
                </div>
                <!-- /container -->
            </div>
        </div>
    </div>
    <?php require 'footer.php'; ?>
</body>
<script id="jsbin-javascript">
    (function (global) {
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
    })(window);

    onClick = url => {
        window.location.href = './cart.php';
    }
</script>

</html>