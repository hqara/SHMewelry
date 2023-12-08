<?php
include_once __DIR__ . "/../../Models/Product.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Product Listing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="app/scripts/number_input.js"></script>
    <script type="text/javascript"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="CSS/product_listing.css">

</head>


<body>

    <?php include_once __DIR__ . "/../../navbar.php"; ?>

    <div class="container">
    <?php
    // Check if $data is defined and not empty
    if (isset($data) && is_array($data) && !empty($data)) {
        foreach ($data as $key => $product) {
            if ($key % 4 == 0) {
                echo '<div class="row">';
            }
            echo <<<ECHO
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-content product-box">
                        <div class="product-imitation">
                            <img src="Images/AboutUs.jpg" alt="image">
                        </div>
                        <div class="product-desc">
                            <span class="product-price">
                                {$product['PRICE']}
                            </span>
                            <small class="text-muted">{$product['MATERIAL']}</small>
                            <a href="#" class="product-name">{$product['NAME']}</a>
                            <div class="small m-t-xs">
                                {$product['DESCRIPTION']}
                            </div>
                            <div class="m-t text-righ">
                                <a href="index.php?controller=product&action=view&id={$product['PRODUCT_ID']}" class="btn btn-xs btn-blue">Info<i
                                        class="fa fa-long-arrow-right"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ECHO;

            // this makes sure every row <div> only has a maximum of 4 products.
            // the second condition ensures the div is closed even if the last index is not a multiple of 4.
            if ($key % 4 == 3 || $key == count($data) - 1) {
                echo '</div>';
            }
        }
    }
    ?>

    </div>
    <footer>
        <?php include_once __DIR__ . "/../../footer.html"; ?>
    </footer>
</body>
</html>