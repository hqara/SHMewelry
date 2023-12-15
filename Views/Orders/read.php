<!--- NEED REVISION -->
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
        <form method="POST" action="?controller=orders&action=create">
            <input name="order_id" type="hidden" value="<?php echo $order['ORDER_ID']; ?>" disabled>
        <?php
        
        // Check if $order is set and not null
        if (isset($data) && is_array($data) && !empty($data)) {
            // Display order details
            echo '<h2 class="py-4">Order Details:</h2>';
            echo '<p>Order Number: ' . $order['ORDER_ID'] .'</p>';
            echo '<p>Date: ' . $order['ORDER_DATE'] . '</p>';
            echo '<p>Total Amount: $' . $order['TOTAL_PRICE'] . '</p>';

            // Update the form action to use the correct order ID
            echo '<form method="post" action="?controller=orders&action=delete">';
            echo '<input type="hidden" name="order_id" value="' . $order['ORDER_ID'] . '">';
            echo '<div class="d-flex justify-content-end">';
            echo '<button type="submit" class="btn btn-primary" name="delete">CANCEL ORDER</button>';
            echo '</div>';
            echo '</form>';
        } else {
            // No data available
            echo '<p>No data available</p>';
        }
        ?>
    </div>

    <?php include_once __DIR__ . "/../../footer.html"; ?>

</body>

</html>
