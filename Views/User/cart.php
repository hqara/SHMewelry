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
            <tbody>
            <?php
                // fetching from the 'cart' action
                if (isset($data) && is_array($data) && !empty($data)) {
                    $items = $data; 

                    foreach ($items as $item)
                    {
                        $runningTotalSingleProduct =  $item["QTY"] * $item['PRICE'];
                        echo <<<ECHO
                            <tr id="product{$item['PRODUCT_ID']}" name="{$item['PRODUCT_ID']}">
                                <td>
                                    <a href="index.php?controller=product&action=view&id={$item["PRODUCT_ID"]}">
                                        <img src="assets/images/{$item["PRODUCT_IMAGE"]}" alt="ring1.jpg" width="150" style="border: 1px solid #6ac5fe;">
                                    </a>
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
                                <td>
                                    <p style="margin-top:25px;" id="runningPriceProduct{$item["PRODUCT_ID"]}">\$$runningTotalSingleProduct</p>
                                    <p hidden id="fullPriceProduct{$item["PRODUCT_ID"]}">{$item["PRICE"]}</p>
                                </td>
                                <td>
                                    <form method="post" action="index.php?controller=user&action=updateQty&id={$item['PRODUCT_ID']}">
                                    <div class="input-group number-spinner" style="width:25%;margin-top:20px;">
                                        <span class="input-group-btn data-dwn">
                                            <button type="submit" id="btnUp{$item["PRODUCT_ID"]}" name="btnUp{$item["PRODUCT_ID"]}" class="btn btn-default btn-info" data-dir="dwn">
                                                <span class="glyphicon glyphicon-minus"></span>
                                            </button>
                                        </span>
                                        <input onKeyDown="return false" type="number" class="form-control text-center" style="width:100px;" value="{$item['QTY']}" min="1" max="10" name="quantity{$item['PRODUCT_ID']}" id="quantity{$item['PRODUCT_ID']}">
                                        <span class="input-group-btn data-up">
                                            <button type="submit" id="btnDown{$item["PRODUCT_ID"]}" name="btnDown{$item["PRODUCT_ID"]}" class="btn btn-default btn-info" data-dir="up">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </span>
                                    </div>
                                    </form>
                                </td>
                                <td>
                                    <button name="remove{$item['PRODUCT_ID']}" id="remove{$item['PRODUCT_ID']}" style="margin-top:20px;" class="btn btn-danger btn-sm">Remove</button>
                                </td>
                            </tr>
                        ECHO;
                    }
                }
                else
                {
                    echo <<<ECHO
                    <center>
                    <table style="background-color: #e6f3f8; width: 100%; height: auto; margin-bottom:50px;">
                        <tr>
                            <td style="padding:25px">
                                <h5 style="text-align:center;">You have no items in the cart.</h5>
                            </td>
                        </tr>
                    </table>
                    </center>
                    ECHO;
                }
            ?>
            </tbody>
        </table>
                    
        
        <h4 id="totalLabel" class="text-right">Total: $0</h4> <!-- WHERE THE TOTAL IS DISPLAYED-->
        <p hidden id="total" name="total"></p>
       

        <div class="row">
            <div class="col-md-6">
                <form action="index.php?controller=user&action=clear" method="post">
                    <button name="clear" type="submit" id="clear" class="btn btn-primary" style="margin-bottom:50px;">Clear Cart</button>
                </form>
            </div>
            
            <div class="col-md-6 text-right">
                <form action="index.php?controller=address&action=add" method="post">
                    <?php
                    // Check if there are items in the cart
                    if (!empty($items)) {
                        echo '<button name="checkout" type="submit" class="btn btn-primary" style="margin-bottom:50px;">Checkout</button>';
                    } else {
                        echo '<button name="checkout" type="submit" class="btn btn-primary" style="margin-bottom:50px;" disabled>Checkout</button>';
                    }
                    ?>
                </form>
            </div>
            
            
        </div>
        
    </div>
    
    <?php include_once __DIR__ . "/../../footer.html"; ?>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="app/scripts/cart.js"></script>
</body>
</html>