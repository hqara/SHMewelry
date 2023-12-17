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
        <h1 class="py-2 text-center mx-auto">Thank You for Your Order!</h1>
        <h2 class="py-2 text-center mx-auto">Your Order has been Confirmed</h2>

        <form method="post" action="index.php?controller=orders&action=list">
            <button type="submit" class="btn btn-primary" style="margin-bottom:20px;" name="view">View Orders</button>
        </form>
             
        <?php


        /* CHANGE OF PLANS
        // Check if $data is set and not empty
        if (isset($data) && is_array($data) && !empty($data)) {
            // Display order details
            echo '<h2 class="py-4">Order Details:</h2>';
            echo '<p>Order Number: ' . $data[0]['ORDER_ID'] . '</p>';
            echo '<p>Date: ' . $data[0]['ORDER_DATE'] . '</p>';
            echo '<p>Total Amount: $' . $data[0]['TOTAL_PRICE'] . '</p>';

            // Update the form action to use the correct order ID
            echo '<form method="post" action="index.php?controller=home&action=index">';
            echo '<input type="hidden" name="order_id" value="' . $data[0]['ORDER_ID'] . '">';
            echo '<div class="d-flex justify-content-end">';
            echo '<button type="submit" style="margin-left: 75%; margin-bottom: 20px;" class="btn btn-primary" name="deleteOrder">CANCEL ORDER</button>';
            echo '</div>';
            echo '</form>';
        } else {
            // No data available
            echo '<p>No data available</p>';
        }
        */
        ?>

    </div>

    <?php include_once __DIR__ . "/../../footer.html"; ?>

</body>

</html>
