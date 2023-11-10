<?php
        session_start();
        include('../../navbar.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud operations</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h1>MANAGE PRODUCTS</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col" class="col-md-3">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Manufacturer</th>
                    <th scope="col">Color</th>
                    <th scope="col">Material</th>
                    <th scope="col">Type</th>
                    <th scope="col">Size</th>
                    <th scope="col">Stock</th>
                    <th scope="col" class="col-md-3">Image</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                include '../../Models/Product.php';
                $conn = Product::getConnection();
                $productModel = new Product();
                $products = $productModel->getAll();

                foreach ($products as $product) {
                    echo '<tr>
                        <th scope="row">' . $product['PRODUCT_ID'] . '</th>
                        <td>' . $product['NAME'] . '</td>
                        <td>' . $product['DESCRIPTION'] . '</td>
                        <td>' . $product['PRICE'] . '</td>
                        <td>' . $product['MANUFACTURER'] . '</td>
                        <td>' . $product['COLOR'] . '</td>
                        <td>' . $product['MATERIAL'] . '</td>
                        <td>' . $product['TYPE'] . '</td>
                        <td>' . $product['SIZE'] . '</td>
                        <td>' . $product['STOCK'] . '</td>
                        <td>' . $product['PRODUCT_IMAGE'] . '</td>
                        <td><button class="btn btn-primary"><a href="edit.php?editid=' . $product['PRODUCT_ID'] . '" class="text-light">Edit</a></button></td>
                        <td><button class="btn btn-danger"><a href="remove.php?removeid=' . $product['PRODUCT_ID'] . '" class="text-light">Remove</a></button></td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
        <button class="btn btn-primary my-5"><a href="add.php" class="text-light">ADD NEW PRODUCT TO CATALOG</a></button>
    </div>

    <!-- Bootstrap JS (optional, for Bootstrap components) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
<footer>
    <?php
        include_once("../../footer.html");
    ?>
</footer>
</html>
