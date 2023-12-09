<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>

<body>
</header>
    <?php include_once __DIR__ . "/../../navbar.php"; ?>
</header>

    <div class="container">
        <h1 class="py-2">MANAGE PRODUCTS</h1>

        </br>
        <form method="post" action="index.php?controller=product&action=add">
            <button type="submit" class="btn btn-primary" name="add">ADD NEW PRODUCT TO CATALOG</button>
        </form>
        </br>

        <table class="table" style="width:100%;">
            <thead>
                <tr>
                    <th scope="col" class="col-md-3">ID</th>
                    <th scope="col" class="col-md-3">Name</th>
                    <th scope="col" class="col-md-3">Description</th>
                    <th scope="col" class="col-md-3">Price</th>
                    <th scope="col" class="col-md-3">Manufacturer</th>
                    <th scope="col" class="col-md-3">Color</th>
                    <th scope="col" class="col-md-3">Material</th>
                    <th scope="col" class="col-md-3">Type</th>
                    <th scope="col" class="col-md-3">Size</th>
                    <th scope="col" class="col-md-3">Stock</th>
                    <th scope="col" class="col-md-3">Image</th>
                    <th scope="col" class="col-md-3"></th>
                    <th scope="col" class="col-md-3"></th>
                </tr>
            </thead>
            <tbody>
                
                <?php
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
                            <td>' . $product['STOCK'] . '</td>';

                            if (empty($product['PRODUCT_IMAGE'])) {
                                // If no image is found, display a message
                                echo '<td>'.$product['PRODUCT_IMAGE'].'</td>';
                            } else {
                                // If an image is found, display it
                                echo '<td><img src="/SHMewelry/assets/images/' . $product['PRODUCT_IMAGE'] . '" alt="' . $product['PRODUCT_IMAGE'] . '" width="150" style="border: 1px solid #6ac5fe;"></td>';
                            }
                            
                            echo '<td>

                            <form method="post" action="index.php?controller=product&action=edit&id=' . $product['PRODUCT_ID'] . '">
                                <input type="hidden" name="product_id" value="' . $product['PRODUCT_ID'] . '">
                                <button type="submit" class="btn btn-primary" name="edit">Edit</button>
                            </form>
                            </td>

                            <td>
                            <form method="post" action="index.php?controller=product&action=delete">
                                <input type="hidden" name="product_id" value="' . $product['PRODUCT_ID'] . '">
                                <button type="submit" class="btn btn-danger" name="delete">Remove</button>
                            </form>
                            </td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="13">No data available</td></tr>';
                }
                ?>
            </tbody>
        </table>
        
    </div>

   
    <?php include_once __DIR__ . "/../../footer.html"; ?>

</body>

</html>
