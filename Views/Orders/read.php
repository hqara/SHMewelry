<!--- NEED REVISION -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <header>
        <?php //include('../../navbar.php'); ?>
    </header>
</head>

<body class="justify-content-start">
    <div class="container my-5">
        <h1 class="py-4 text-center mx-auto">Thank You for Your Order!</h1>
        <h2 class="py-4 text-center mx-auto">Your Order has been Confirmed</h2>
        <form method="POST" action="index.php?controller=orders&action=create">
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
            echo '<form method="post" action="index.php?controller=orders&action=delete">';
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

    <!-- Bootstrap JS (optional, for Bootstrap components) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>

<footer>
    <?php include_once("../../footer.html"); ?>
</footer>

</html>
