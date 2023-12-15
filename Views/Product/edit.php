<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <?php include_once __DIR__ . "/../../navbar.php"; ?>

    <div class="container my-5 text-center">
        <h1 class="py-2" style="padding:10px;">Edit Product#<?php echo $product->product_id; ?></h1>
        <form method="post" action="?controller=product&action=update" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $product->product_id; ?>">

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="name" class="col-sm-2 col-form-label text-left">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="name" name="name" autocomplete="off" value="<?php echo $product->name; ?>" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="description" class="col-sm-2 col-form-label text-left">Description</label>
                <div class="col-sm-6">
                    <textarea class="form-control" id="description" name="description" autocomplete="off" required><?php echo $product->description; ?></textarea>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="price" class="col-sm-2 col-form-label text-left">Price</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="price" name="price" autocomplete="off" value="<?php echo $product->price; ?>" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="manufacturer" class="col-sm-2 col-form-label text-left">Manufacturer</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="manufacturer" name="manufacturer" autocomplete="off" value="<?php echo $product->manufacturer; ?>" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="color" class="col-sm-2 col-form-label text-left">Color</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="color" name="color" autocomplete="off" value="<?php echo $product->color; ?>" required>
                </div>
            </div>


             <!-- Material Dropdown -->
             <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="material" class="col-sm-2 col-form-label text-left">Material</label>
                <div class="col-sm-6">
                    <select id="material" name="material" required class="form-control">
                        <?php
                        // Fetch unique materials from the Product table
                        $sql = "SELECT DISTINCT Material FROM product";
                        $result = $conn->query($sql);

                        // Display the materials as dropdown items
                        $defaultMaterialDisplayed = false; // Flag to track if the default material has been displayed

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $material = $row['Material'];

                                // Check if the material is the default and has not been displayed yet
                                if ($product->material === $material && !$defaultMaterialDisplayed) {
                                    echo "<option value='$material' selected>$material</option>";
                                    $defaultMaterialDisplayed = true;
                                } else {
                                    echo "<option value='$material'>$material</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>


            <!-- Type Dropdown -->
            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="type" class="col-sm-2 col-form-label text-left">Type</label>
                <div class="col-sm-6">
                    <select id="type" name="type" required class="form-control">
                        <?php
                        // Fetch unique types from the Product table
                        $sql = "SELECT DISTINCT Type FROM product";
                        $result = $conn->query($sql);

                        // Display the types as dropdown items
                        $defaultTypeDisplayed = false; // Flag to track if the default type has been displayed

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $type = $row['Type'];

                                // Check if the type is the default and has not been displayed yet
                                if ($product->type === $type && !$defaultTypeDisplayed) {
                                    echo "<option value='$type' selected>$type</option>";
                                    $defaultTypeDisplayed = true;
                                } else {
                                    echo "<option value='$type'>$type</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="size" class="col-sm-2 col-form-label text-left">Size</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="size" name="size" autocomplete="off" value="<?php echo $product->size; ?>" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="stock" class="col-sm-2 col-form-label text-left">Stock</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="stock" name="stock" autocomplete="off" value="<?php echo $product->stock; ?>" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="product_image" class="col-sm-2 col-form-label text-left">Product Image</label>
                <div class="col-sm-6">
                    <input type="file" class="form-control-file" id="product_image" name="product_image" accept="image/*">
                </div>
            </div>
            
            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                    <label for="product_image" class="col-sm-2 col-form-label text-left">Current Image</label>
                    <div class="col-sm-6">
                    <?php
                    if (!empty($product->product_image)) {
                        echo $product->product_image;
                        echo '<img src="/SHMewelry/assets/images/' . $product->product_image . '" alt="' . $product->product_image . '" width="150" style="border: 1px solid #6ac5fe; margin-right: 400px;">';
                    }
                    ?>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <div class="col-sm-6" >
                    <table>
                        <tr>
                            <td>
                                <button type="button" class="btn btn-primary" style="margin-left:40px;" name="back" onclick="window.history.back();">GO BACK</button>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary" name="update">UPDATE</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </form>
    </div>

    <?php include_once __DIR__ . "/../../footer.html"; ?>

</body>

</html>
