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
        <h1 class="py-5" style="padding: 10px;">SHIPPING DETAILS</h1>
        <form method="post" action="index.php?controller=address&action=create" class="mx-auto">

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="street_address" name="street_address" placeholder="Address Line" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="city" name="city" placeholder="City" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="province" name="province" placeholder="Province" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal Code" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="country" name="country"  placeholder="Country" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: center;">
                <div class="col-sm-6 py-4 text-left">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="set_default" name="set_default" value="1">
                        <label class="form-check-label" for="set_default">Set as my default address</label>
                    </div>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="display:flex; justify-content: space-around;">
                <div class="col-sm-6 text-right">
                    <input type="hidden" name="user_id" value="<?php echo isset($user['USER_ID']) ? $user['USER_ID'] : ''; ?>">
                    <button type="submit" class="btn btn-primary" name="create">NEXT</button>
                </div>
            </div>

        </form>
    </div>

    <?php include_once(__DIR__ . "/../../footer.html"); ?>
</body>
</html>
