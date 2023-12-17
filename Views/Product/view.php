<?php
// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']);

// Debugging: Dump the entire user object
if ($isLoggedIn) {
    // Retrieve the group_id from the user object in the session
    $groupId = isset($_SESSION['user']->group_id) ? $_SESSION['user']->group_id : null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Bootstrap 3.2.0 -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="app/scripts/number_input.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="CSS/product_detail.css">
    <link rel="stylesheet" href="CSS/shared.css">
    <link rel="stylesheet" href="CSS/quantity.css">
</head>

<body>
    <?php include_once __DIR__ . "/../../navbar.php"; ?>

    <div class="container bootdey">
        <div class="col-md-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="col-md-6">
                        <?php
                        // Check if $data is defined and not empty
                        if (isset($data) && is_array($data) && !empty($data)) {
                            $product = $data[0]; // Assuming you want the first product from the array
                            ?>
                            <div class="pro-img-details">
                                <img src="assets/images/<?php echo $product['PRODUCT_IMAGE']; ?>"
                                     alt="<?php echo $product['PRODUCT_IMAGE']; ?>">
                            </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class="pro-d-title">
                            <h2><strong>
                                    <?php echo $product['NAME']; ?>
                                </strong></h2>
                            <h3>$
                                <?php echo $product['PRICE']; ?>
                            </h3>
                            <?php } ?>
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
                                <strong>Color:</strong>
                                <?php echo isset($product['COLOR']) ? $product['COLOR'] : ''; ?>
                            </span>

                            <span class="posted_in">
                                <strong>Material:</strong>
                                <?php if (isset($product['MATERIAL'])): ?>
                                    <a rel="tag"
                                       href="index.php?controller=product&action=read&material=<?php echo $product['MATERIAL']; ?>&type=<?php echo $product['TYPE']; ?>"><?php echo $product['MATERIAL']; ?></a>
                                <?php endif; ?>
                            </span>
                            <span class="posted_in">
                                <strong>Type:</strong>
                                <?php if (isset($product['TYPE'])): ?>
                                    <a rel="tag"
                                       href="index.php?controller=product&action=read&type=<?php echo $product['TYPE']; ?>"><?php echo $product['TYPE']; ?></a>
                                <?php endif; ?>
                            </span>

                            <span class="posted_in">
                                <strong>Manufacturer:</strong>
                                <?php echo isset($product['MANUFACTURER']) ? $product['MANUFACTURER'] : ''; ?>
                            </span>
                        </div>

                        <form action="index.php?controller=user&action=bag&id=<?php echo $_GET['id']; ?>" method="post">
                            <div class="form-group center-content">
                                <div class="tor">
                                    <label for="quantity">Quantity</label>
                                    <div class="container">
                                        <div class="col-xs-3 col-xs-offset-3">
                                            <div class="input-group number-spinner">
                                                <span class="input-group-btn data-dwn">
                                                    <button type="button" class="btn btn-default btn-info" data-dir="dwn"><span
                                                                class="glyphicon glyphicon-minus"></span></button>
                                                </span>
                                                <input onKeyDown="return false" type="number" class="form-control text-center" value="1" min="1"
                                                       max="10" name="quantity" id="quantity">
                                                <span class="input-group-btn data-up">
                                                    <button type="button" class="btn btn-default btn-info" data-dir="up"><span
                                                                class="glyphicon glyphicon-plus"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p>
                                <?php if ($isLoggedIn && $groupId == 1): ?>
                                    <button class="btn btn-round btn-danger" type="submit" name="addToCartBtn">
                                        <i class="fa fa-shopping-cart"></i> Add to Cart
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-secondary" disabled style="background-color: darkgrey; border: 1px solid grey;">
                                        Add to Cart
                                    </button>
                                <?php endif; ?>
                            </p>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php include_once __DIR__ . "/../../footer.html"; ?>
</body>

</html>
