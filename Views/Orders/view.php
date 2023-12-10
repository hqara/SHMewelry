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
    
    <body class="justify-content-start">

<?php include_once __DIR__ . "/../../navbar.php"; ?>

<div class="container my-5">
    <h1 class="py-2 text-center mx-auto">ORDER DETAILS</h1>
    <?php
    // Check if $data is defined and not empty
    if (isset($data) && is_array($data) && !empty($data)) {
        // Display shipping details once
        echo '<h2 class="py-4">Shipping Details</h2>';
        echo '<p>' . $data[0]['FNAME'] . ' ' . $data[0]['LNAME'] . '</p>';
        echo '<p>' . $data[0]['STREET_ADDRESS'] . '</p>';
        echo '<p>' . $data[0]['CITY'] . ', ' . $data[0]['PROVINCE'] . ', ' . $data[0]['COUNTRY'] . ', ' . $data[0]['POSTAL_CODE'] . '</p>';
        echo '<p>' . $data[0]['EMAIL'] . '</p>';

        // Display order summary
        echo '<h2 class="py-4">Order Summary</h2>';
        foreach ($data as $orderDetails) {
            // Display order details
            echo '<p>- [' . $orderDetails['QTY'] . '] X $' . $orderDetails['PRICE'] . ' X ' . $orderDetails['NAME'] . ', ' . $orderDetails['SIZE'] . ', ' . $orderDetails['MATERIAL'] . ', ' . $orderDetails['TYPE'] . ', ' . $orderDetails['COLOR'] . '</p>';
        }

        echo '<h3 class="py-4">Total: $' . $data[0]['TOTAL_PRICE'] . '</h3>';
    } else {
        // No data available
        echo '<p>No data available</p>';
    }
    ?>
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-primary" name="return" onclick="window.history.back();">RETURN</button>
    </div>
</div>
<?php include_once __DIR__ . "/../../footer.html"; ?>
</body>

</html>