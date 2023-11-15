<?php

include '../../Models/Product.php';

$productModel = new Product();

// Check if the product ID is provided in the URL
if (isset($_GET['editid'])) {
    $product_id = $_GET['editid'];

    // Get the current values of the product
    $product = $productModel->getProductById($product_id);

    if (!$product) {
        die("Product not found.");
    }
} else {
    die("Product ID not provided.");
}

if (isset($_POST['update'])) {
    // Get form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $manufacturer = $_POST['manufacturer'];
    $color = $_POST['color'];
    $material = $_POST['material'];
    $type = $_POST['type'];
    $size = $_POST['size'];
    $stock = $_POST['stock'];
    $product_image = $_POST['product_image'];

    // Update the product
    $affected_rows = $productModel->update($product_id, $name, $description, $price, $manufacturer, $color, $material, $type, $size, $stock, $product_image);

    if ($affected_rows > 0) {
        header('location: display.php'); // Redirect after successful update
        exit();
    } else {
        echo "Update failed. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <header>
        <?php include('../../navbar.php'); ?>
    </header>
</head>

<body>
    <div class="container my-5">
        <h1>Edit Product#<?php echo $product['PRODUCT_ID']; ?></h1>
        <form method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="name"name="name" autocomplete="off" value="<?php echo $product['NAME']; ?>">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" id="description" name="description"><?php echo $product['DESCRIPTION']; ?></textarea>
            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="text" class="form-control" id="price" name="price" autocomplete="off" value="<?php echo $product['PRICE']; ?>">
            </div>

            <div class="form-group">
                <label>Manufacturer</label>
                <input type="text" class="form-control" id="manufacturer" name="manufacturer" autocomplete="off" value="<?php echo $product['MANUFACTURER']; ?>">
            </div>

            <div class="form-group">
                <label>Color</label>
                <input type="text" class="form-control" id="color"  name="color" autocomplete="off" value="<?php echo $product['COLOR']; ?>">
            </div>

            <div class="form-group">
                <label>Material</label>
                <input type="text" class="form-control" id="material" name="material" autocomplete="off" value="<?php echo $product['MATERIAL']; ?>">
            </div>

            <div class="form-group">
                <label>Type</label>
                <input type="text" class="form-control" id="type" name="type" autocomplete="off" value="<?php echo $product['TYPE']; ?>">
            </div>

            <div class="form-group">
                <label>Size</label>
                <input type="text" class="form-control" id="size" name="size" autocomplete="off" value="<?php echo $product['SIZE']; ?>">
            </div>

            <div class="form-group">
                <label>Stock</label>
                <input type="text" class="form-control" id="stock" name="stock" autocomplete="off" value="<?php echo $product['STOCK']; ?>">
            </div>

            <div class="form-group">
                <label>Product Image</label>
                <input type="text" class="form-control" id="product_image" name="product_image" autocomplete="off" value="<?php echo $product['PRODUCT_IMAGE']; ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="update">UPDATE</button>
            <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">GO BACK</button>
        </form>
    </div>
</body>

<footer>
    <?php
        include_once("../../footer.html");
    ?>
</footer>

</html>
