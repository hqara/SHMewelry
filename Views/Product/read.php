<?php
include_once __DIR__ . "/../../Models/Product.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Product Listing</title>
    <!-- From Bootdey.com -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="product_listing.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="app/scripts/number_input.js"></script>
    <script type="text/javascript"></script>
    <link href="shared.css" rel="stylesheet">
</head>

<body>
    <header>
    <?php include_once __DIR__ . "/../../navbar.php"; ?>
    </header>

    <div class="container">
        <?php
        if (Product::buildProductPage() != null) {
            $row_count = 0;
            $result = Product::buildProductPage();


            foreach ($result as $row) {
                if ($row_count % 4 == 0) {
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
                                   {$row['PRICE']}
                               </span>
                               <small class="text-muted">{$row['MATERIAL']}</small>
                               <a href="#" class="product-name">{$row['NAME']}</a>
                               <div class="small m-t-xs">
                                   {$row['DESCRIPTION']}
                               </div>
                               <div class="m-t text-righ">
                                   <a href="index.php?controller=product&action=product_detail&id={$row['PRODUCT_ID']}" class="btn btn-xs btn-blue">Info<i
                                           class="fa fa-long-arrow-right"></i> </a>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               ECHO;


                // this makes sure every row <div> only has a maximum of 4 products.
                // the second condition ensures the div is closed even if the last index is not a multiple of 4.
                if ($row_count % 4 == 3 || $row_count == count($result) - 1) {
                    echo '</div>';
                }


                $row_count++;
            }
        }
        ?>

    </div>
    <footer>
        <?php include_once __DIR__ . "/../../footer.html"; ?>
    </footer>
</body>
</html>