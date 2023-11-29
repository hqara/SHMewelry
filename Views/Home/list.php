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
</head>
<body>
    <?php
        include_once __DIR__ . "/../../navbar.php";
    ?>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="product_listing.css" rel="stylesheet">
    <div class="container">
        <?php
            Product::buildProductPage();
        ?>
    </div>
    <?php
        include_once __DIR__ . "/../../footer.html";
    ?>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript"></script>
    <link href="shared.css" rel="stylesheet">
</body>

</html>