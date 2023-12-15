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


    <div class="container my-5">
        <h1 class="py-2" style="padding: 10px; display:flex; justify-content: center;">Add New Product to Catalog</h1>
        <form method="post" action="?controller=product&action=create" enctype="multipart/form-data">

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="name" class="col-sm-2 col-form-label text-left">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="description" class="col-sm-2 col-form-label text-left">Description</label>
                <div class="col-sm-6">
                    <textarea class="form-control" id="description" name="description" autocomplete="off" required></textarea>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="price" class="col-sm-2 col-form-label text-left">Price</label>
                <div class="col-sm-6">
                    <input type="number" step="0.01" class="form-control" id="price" name="price" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="manufacturer" class="col-sm-2 col-form-label text-left">Manufacturer</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="manufacturer" name="manufacturer" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="color" class="col-sm-2 col-form-label text-left">Color</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="color" name="color" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="type" class="col-sm-2 col-form-label text-left">Material</label>
                <div class="col-sm-6">
                    <select id="type" name="material" required class="form-control">
                        <option value="Gold">Gold</option>
                        <option value="Rosegold">Rosegold</option>
                        <option value="Silver">Silver</option>
                        <option value="Copper">Copper</option>
                    </select>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="type" class="col-sm-2 col-form-label text-left">Type</label>
                <div class="col-sm-6">
                    <select id="type" name="type" required class="form-control">
                        <option value="Bracelet">Bracelet</option>
                        <option value="Ring">Ring</option>
                        <option value="Necklace">Necklace</option>
                        <option value="Earring">Earring</option>
                    </select>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="size" class="col-sm-2 col-form-label text-left">Size</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="size" name="size" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="stock" class="col-sm-2 col-form-label text-left">Stock</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" id="stock" name="stock" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <label for="product_image" class="col-sm-2 col-form-label text-left">Product Image</label>
                <div class="col-sm-6">
                    <input type="file" class="form-control-file" id="product_image" name="product_image" accept="image/*" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: space-around;">
                <div class="col-sm-6">
                    <table>
                        <tr>
                            <td> 
                                <button type="button" class="btn btn-primary" style="margin-left:100px;" name="back"  onclick="window.history.back();">GO BACK</button>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary" name="create">CREATE</button>
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
