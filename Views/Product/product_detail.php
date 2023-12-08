<?php
include_once __DIR__ . "/../../Models/Product.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Product Detail</title>
    <!-- From Bootdey.com -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="product_detail.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="app/scripts/number_input.js"></script>
    <link href="shared.css" rel="stylesheet">
</head>

<body>
    </header>
    <?php include_once __DIR__ . "/../../navbar.php"; ?>
    </header>
    <?php


    $product = Product::buildProductDetailPage()[0];
    ?>


    <div class="container bootdey">
        <div class="col-md-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="col-md-6">
                        <div class="pro-img-details">
                            <img src="Images/AboutUs.jpg" alt>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class="pro-d-title">
                            <h2>
                                <strong>
                                    <?php echo $product['NAME']; ?>
                                </strong>
                            </h2>
                            <h3>
                                <?php echo $product['PRICE']; ?>
                            </h3>
                        </h4>
                        <hr>
                        <h4><strong>
                                <?php echo $product['SIZE']; ?>
                            </strong></h4>
                        <p>
                            <?php echo $product['DESCRIPTION']; ?>
                        </p>
                        <div class="product_meta">
                            <span class="posted_in">
                                <strong>Material:</strong>
                                <a rel="tag"
                                    href="index.php?controller=product&action=read&material=<?php echo $product['MATERIAL']; ?>&type=<?php echo $product['TYPE']; ?>"><?php echo $product['MATERIAL']; ?></a>
                            </span>
                            <span class="posted_in">
                                <strong>Color:</strong>
                                <a rel="tag"
                                    href="index.php?controller=product&action=read&type=<?php echo $product['TYPE']; ?>"><?php echo $product['TYPE']; ?></a>
                            </span>
                            <span class="posted_in">
                                <strong>Manufacturer:</strong>
                                <p>
                                    <?php echo $product['MANUFACTURER']; ?>
                                    </>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <div class="container">
                                <div class="tor">
                                    <div class="col-xs-3 col-xs-offset-3">
                                        <div class="input-group number-spinner">
                                            <span class="input-group-btn data-dwn">
                                                <button class="btn btn-default btn-info" data-dir="dwn"><span
                                                        class="glyphicon glyphicon-minus"></span></button>
                                            </span>
                                            <input type="text" class="form-control text-center" value="1" min="1"
                                                max="10" name="quantity" id="quantity">
                                            <span class="input-group-btn data-up">
                                                <button class="btn btn-default btn-info" data-dir="up"><span
                                                        class="glyphicon glyphicon-plus"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p>
                            <button class="btn btn-round btn-danger" type="button">
                                <i class="fa fa-shopping-cart"></i>Add to Cart
                            </button>
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </div>
    ECHO;


    <?php include_once __DIR__ . "/../../footer.html"; ?>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript"></script>
</body>

</html>