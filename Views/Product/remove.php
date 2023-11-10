<?php

include '../../Models/Product.php';

$conn = Product::getConnection();

if (isset($_GET['removeid'])) {
    $id = $_GET['removeid'];

    $productModel = new Product();
    $productModel->product_id = $id;

    $rowsAffected = $productModel->delete();

    if ($rowsAffected > 0) {
        // Deleted successfully
        header("location: display.php");
    } else {
        die("Error deleting product: " . mysqli_error($conn));
    }
}

?>
