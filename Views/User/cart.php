<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Bootstrap 3.2.0 -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="app/scripts/number_input.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="CSS/shared.css">
    <link rel="stylesheet" href="CSS/quantity.css">
</head>

<body>
    <?php include_once __DIR__ . "/../../navbar.php"; ?>
    <div class="container">

        <h2>Shopping Cart</h2>
        
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Items</th>
                    <th scope="col"></th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <?php
                // fetching from the 'cart' action
                if (isset($data) && is_array($data) && !empty($data)) {
                    $items = $data; 
                }

                foreach ($items as $item)
                {
                    echo <<<ECHO
                        <tbody>
                            <tr>
                                <td>
                                    <img src="assets/images/{$item["PRODUCT_IMAGE"]}" alt="ring1.jpg" width="150" style="border: 1px solid #6ac5fe;">
                                </td>
                                <td>
                                    <p style="margin-top: 10px;">
                                        {$item["NAME"]}<br>
                                        {$item["SIZE"]}<br>
                                        {$item["MATERIAL"]}<br>
                                        {$item["TYPE"]}<br>
                                        {$item["COLOR"]}<br>
                                        {$item["MANUFACTURER"]}
                                    </p>
                                </td>
                                <td><p style="margin-top:25px;">\${$item["PRICE"]}</p></td>
                                <td>
                                    <div class="input-group number-spinner" style="width:25%;margin-top:20px;">
                                        <span class="input-group-btn data-dwn">
                                            <button class="btn btn-default btn-info" data-dir="dwn">
                                                <span class="glyphicon glyphicon-minus"></span>
                                            </button>
                                        </span>
                                        <input type="number" class="form-control text-center" style="width:100px;" value="1" min="1" max="10" name="quantity" id="quantity">
                                        <span class="input-group-btn data-up">
                                            <button class="btn btn-default btn-info" data-dir="up">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <button name="remove" style="margin-top:20px;" class="btn btn-danger btn-sm">Remove</button>
                                </td>
                            </tr>
                        </tbody>
                    ECHO;
                }
            ?>
        </table>
                    
        <h4 class="text-right">Total: $39.98</h4>
        <div class="row">
            <div class="col-md-6">
                <button name="clear" class="btn btn-primary" style="margin-bottom:50px;">Clear Cart</button>
            </div>
            <div class="col-md-6 text-right">
                <button name="checkout" class="btn btn-primary" style="margin-bottom:50px;">Checkout</button>
            </div>
        </div>
    </div>
    
    <?php include_once __DIR__ . "/../../footer.html"; ?>
</body>
</html>