<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="CSS/shared.css">
</head>

<body class="justify-content-start">

    <?php include_once __DIR__ . "/../../navbar.php"; ?>

    <div class="container my-5">
        <h1 class="py-2 text-center mx-auto">ORDER CONFIRMATION</h1>

            <?php
            // Check if $data is defined and not empty
            if (isset($data) && is_array($data) && !empty($data)) {
                $shippingDetailsDisplayed = false;

              // Display shipping details once
              echo '<h2 class="py-4">Shipping Details <a href="index.php?controller=address&action=edit" style="font-size: 16px;">Edit</a></h2>';

                foreach ($data as $orderDetails) {
                    if (!$shippingDetailsDisplayed) {
                        echo '<p>' . $orderDetails['FNAME'] . ' ' . $orderDetails['LNAME'] . '</p>';
                        echo '<p>' . $orderDetails['STREET_ADDRESS'] . '</p>';
                        echo '<p>' . $orderDetails['CITY'] . ', ' . $orderDetails['PROVINCE'] . ', ' . $orderDetails['COUNTRY'] . ', ' . $orderDetails['POSTAL_CODE'] . '</p>';
                        echo '<p>' . $orderDetails['EMAIL'] . '</p>';
                        $shippingDetailsDisplayed = true;
                    }
                }

                // Display order summary
                echo '<h2 class="py-4">Order Summary</h2>';


                $total = 0;

                foreach ($data as $orderDetails) {
                    // Display order details
                    echo '<p>- [' . $orderDetails['QTY'] . '] X $' . $orderDetails['PRICE'] . ' X ' . $orderDetails['NAME'] . ', ' . $orderDetails['SIZE'] . ', ' . $orderDetails['MATERIAL'] . ', ' . $orderDetails['TYPE'] . ', ' . $orderDetails['COLOR'] . '</p>';

                    // Update total with the product of quantity and price
                   $total += $orderDetails['QTY'] * $orderDetails['PRICE'];
                }
                //echo '<h3 class="py-4">Total: $' . $data[0]['TOTAL_PRICE'] . '</h3>';
                echo '<h3 class="py-4">Total: $' . $total . '</h3>';
            } else {
                // No data available
                echo '<p>No data available</p>';
            }
            ?>
            <form method="post" action="index.php?controller=orders&action=read">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" style="margin-left:75%;margin-bottom:20px;" name="create">CONFIRM ORDER</button>
                    <input type="hidden" name="order_id" value="<?php echo $order['ORDER_ID']; ?>">
                </div>
            </form>
        </div>

    <?php include_once __DIR__ . "/../../footer.html"; ?>

</body>

</html>

