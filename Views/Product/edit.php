<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/font-awesome.min.css">
</head>

<body>
</header>
    <?php include_once __DIR__ . "/../../navbar.php"; ?>
</header>

    <div class="container my-5 text-center">
        <h1 class="py-2">Edit Product#<?php echo $product->product_id; ?></h1>
        <form method="post" action="index.php?controller=product&action=update">
            <input type="hidden" name="product_id" value="<?php echo $product->product_id; ?>">

            <div class="form-group row justify-content-center">
            <label for="name" class="col-sm-2 col-form-label text-left">Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="name" name="name" autocomplete="off" value="<?php echo $product->name; ?>" required>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label for="description" class="col-sm-2 col-form-label text-left">Description</label>
            <div class="col-sm-6">
                <textarea class="form-control" id="description" name="description" autocomplete="off" required><?php echo $product->description; ?></textarea>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label for="price" class="col-sm-2 col-form-label text-left">Price</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="price" name="price" autocomplete="off" value="<?php echo $product->price; ?>" required>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label for="manufacturer" class="col-sm-2 col-form-label text-left">Manufacturer</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="manufacturer" name="manufacturer" autocomplete="off" value="<?php echo $product->manufacturer; ?>" required>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label for="color" class="col-sm-2 col-form-label text-left">Color</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="color" name="color" autocomplete="off" value="<?php echo $product->color; ?>" required>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label for="material" class="col-sm-2 col-form-label text-left">Material</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="material" name="material" autocomplete="off" value="<?php echo $product->material; ?>" required>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label for="type" class="col-sm-2 col-form-label text-left">Type</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="type" name="type" autocomplete="off" value="<?php echo $product->type; ?>" required>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label for="size" class="col-sm-2 col-form-label text-left">Size</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="size" name="size" autocomplete="off" value="<?php echo $product->size; ?>" required>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label for="stock" class="col-sm-2 col-form-label text-left">Stock</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="stock" name="stock" autocomplete="off" value="<?php echo $product->stock; ?>" required>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label for="product_image" class="col-sm-2 col-form-label text-left">Product Image</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="product_image" name="product_image" autocomplete="off" value="<?php echo $product->product_image; ?>">
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <div class="col-sm-6">
                <button type="submit" class="btn btn-primary" name="update">UPDATE</button>
                <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">GO BACK</button>
            </div>
        </div>

        </form>
    </div>
    <footer>
        <?php include_once __DIR__ . "/../../footer.html"; ?>
    </footer>
</body>
</html>