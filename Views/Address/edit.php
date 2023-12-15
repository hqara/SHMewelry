<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="CSS/shared.css">
</head>

<body class="justify-content-start">
    <?php include_once(__DIR__ . "/../../navbar.php"); ?>

    <div class="container my-5 text-center">
        <h1 class="py-5" style="padding: 10px;">UPDATE SHIPPING DETAILS</h1>
        <form method="post" action="index.php?controller=address&action=update">
        <input type="hidden" name="address_id" value="<?php echo $address->address_id; ?>">

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="street_address" name="street_address" placeholder="Address Line" autocomplete="off" value="<?php echo $address->street_address; ?>" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="city" name="city" placeholder="City" autocomplete="off" value="<?php echo $address->city; ?>" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="province" name="province" placeholder="Province" autocomplete="off" value="<?php echo $address->province; ?>" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal Code" autocomplete="off" value="<?php echo $address->postal_code; ?>" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="country" name="country"  placeholder="Country" autocomplete="off" value="<?php echo $address->country; ?>" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: space-around;">
                <div class="col-sm-6 text-right">
                    <button type="submit" class="btn btn-primary" name="save">SAVE</button>
                </div>
            </div>

        </form>
    </div>

    <?php include_once(__DIR__ . "/../../footer.html"); ?>
</body>
</html>
