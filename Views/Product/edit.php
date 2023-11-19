

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
        <h1>Edit Product#<?php echo $data[0]['PRODUCT_ID']; ?></h1>
        <form method="post" action="?controller=product&action=update&id=<?php echo $data[0]['PRODUCT_ID']; ?>">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="name"name="name" autocomplete="off" value="<?php echo $data[0]['NAME']; ?>">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" id="description" name="description"><?php echo $data[0]['DESCRIPTION']; ?></textarea>
            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="text" class="form-control" id="price" name="price" autocomplete="off" value="<?php echo $data[0]['PRICE']; ?>">
            </div>

            <div class="form-group">
                <label>Manufacturer</label>
                <input type="text" class="form-control" id="manufacturer" name="manufacturer" autocomplete="off" value="<?php echo $data[0]['MANUFACTURER']; ?>">
            </div>

            <div class="form-group">
                <label>Color</label>
                <input type="text" class="form-control" id="color"  name="color" autocomplete="off" value="<?php echo $data[0]['COLOR']; ?>">
            </div>

            <div class="form-group">
                <label>Material</label>
                <input type="text" class="form-control" id="material" name="material" autocomplete="off" value="<?php echo $data[0]['MATERIAL']; ?>">
            </div>

            <div class="form-group">
                <label>Type</label>
                <input type="text" class="form-control" id="type" name="type" autocomplete="off" value="<?php echo $data[0]['TYPE']; ?>">
            </div>

            <div class="form-group">
                <label>Size</label>
                <input type="text" class="form-control" id="size" name="size" autocomplete="off" value="<?php echo $data[0]['SIZE']; ?>">
            </div>

            <div class="form-group">
                <label>Stock</label>
                <input type="text" class="form-control" id="stock" name="stock" autocomplete="off" value="<?php echo $data[0]['STOCK']; ?>">
            </div>

            <div class="form-group">
                <label>Product Image</label>
                <input type="text" class="form-control" id="product_image" name="product_image" autocomplete="off" value="<?php echo $data[0]['PRODUCT_IMAGE']; ?>">
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
