<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>

<body class="justify-content-start">
</header>
    <?php include_once __DIR__ . "/../../navbar.php"; ?>
</header>
    <div class="container my-5">
            <h1 class="py-2 text-center mx-auto">ORDER DETAILS</h1>
            <?php
            // Check if $data is defined and not empty
            if (isset($data) && is_array($data) && !empty($data)) {
                $shippingDetailsDisplayed = false;

                // Display shipping details once
                echo '<h2 class="py-4">Shipping Details</h2>';
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

                foreach ($data as $orderDetails) {
                    // Display order details
                    echo '<p>- [' . $orderDetails['QTY'] . '] X $' . $orderDetails['PRICE'] . ' X ' . $orderDetails['NAME'] . ', ' . $orderDetails['SIZE'] . ', ' . $orderDetails['MATERIAL'] . ', ' . $orderDetails['TYPE'] . ', ' . $orderDetails['COLOR'] . '</p>';
                }

                echo '<h3 class="py-4">Total: $' . $orderDetails['TOTAL_PRICE'] . '</h3>';

            } else {
                // No data available
                echo '<p>No data available</p>';
            }
            ?>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" name="return" onclick="window.history.back();">RETURN</button>
        </div>
    </div>

    <footer>
        <?php include_once __DIR__ . "/../../footer.html"; ?>
    </footer>
</body>
</html>
