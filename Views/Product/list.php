<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <header>
        <?php //include_once __DIR__ . "/../../navbar.php"; ?>
    </header> 
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

            include(__DIR__ . '/../../navbar.php');
            // Check if $data is defined and not empty
            if (isset($data) && is_array($data) && !empty($data)) {
                foreach ($data as $product) {
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
                        
                        <td><button class="btn btn-primary"><a href="?controller=product&action=edit&id=' . $product['PRODUCT_ID'] . '" class="text-light">Edit</a></button></td>
                        <td><button class="btn btn-danger"><a href="?controller=product&action=remove&id=' . $product['PRODUCT_ID'] . '" class="text-light">Remove</a></button></td>
                    </tr>';
                }
            } else {
                echo '<tr><td colspan="13">No data available</td></tr>';
            }
            ?>
            
            </tbody>
        </table>
        <a href="?controller=product&action=add" class="btn btn-primary my-5">ADD NEW PRODUCT TO CATALOG</a>
    </div>

    <!-- Bootstrap JS (optional, for Bootstrap components) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <footer>
    <?php //include_once __DIR__ . "/../../footer.html"; ?>
    </footer>
</body>

</html>
