<?php

include '../../Models/Product.php';

$productModel = new Product(); // Create an instance of the Product model

if (isset($_POST['create'])) {
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

    // Call the create method to insert a new product
    $productModel->name = $name;
    $productModel->description = $description;
    $productModel->price = $price;
    $productModel->manufacturer = $manufacturer;
    $productModel->color = $color;
    $productModel->material = $material;
    $productModel->type = $type;
    $productModel->size = $size;
    $productModel->stock = $stock;
    $productModel->product_image = $product_image;

    $productModel->create();

    header('location: display.php');
    exit();
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
</head>
<body>
<div class="container my-5">
    <h1> Add New Product to Catalog </h1>
    <form method="post">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" id="description" name="description" autocomplete="off" required></textarea>
        </div>

        <div class="form-group">
            <label>Price</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label>Manufacturer</label>
            <input type="text" class="form-control" id="manufacturer" name="manufacturer" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label>Color</label>
            <input type="text" class="form-control" id="color" name="color" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label>Material</label>
            <input type="text" class="form-control" id="material" name="material" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label>Type</label>
            <input type="text" class="form-control" id="type" name="type" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label>Size</label>
            <input type="text" class="form-control" id="size"  name="size" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label>Stock</label>
            <input type="number" class="form-control" id="stock"  name="stock" autocomplete="off" required>
        </div>

        <div class="form-group">
                <label>Product Image</label>
                <input type="text" class="form-control" name="product_image" autocomplete="off" required>
            </div>

           <button type="submit" class="btn btn-primary" name="create">CREATE</button>
           <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">GO BACK</button>
    </form>
</div>
</body>
</html>
