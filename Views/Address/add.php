<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <header>
        <?php //include('../../navbar.php'); ?>
    </header>
</head>

<body>
    <div class="container my-5 text-center">
        <h1 class="py-4">SHIPPING DETAILS</h1>
        <form method="post" action="index.php?controller=address&action=create">

            <div class="form-group row justify-content-center">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="street_address" name="street_address" placeholder="Address Line" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="city" name="city" placeholder="City" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="province" name="province" placeholder="Province" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal Code" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="country" name="country"  placeholder="Country" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center">
                <div class="col-sm-6 py-4 text-left">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="set_default" name="set_default" value="1">
                        <label class="form-check-label" for="set_default">Set as my default address</label>
                    </div>
                </div>
            </div>

            <div class="form-group row justify-content-center">
                <div class="col-sm-6 text-right">
                    <button type="submit" class="btn btn-primary" name="create">NEXT</button>
                </div>
            </div>

        </form>
    </div>
</body>

<footer>
    <?php //include_once("../../footer.html"); ?>
</footer>

</html>
