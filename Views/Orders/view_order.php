<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <header>
        <?php include('../../navbar.php'); ?>
    </header>
</head>

<body>
    <div class="container my-5">
        <h1>ORDER DETAILS</h1>
        <?php

        include '../../Models/User.php';
        include '../../Models/Order.php';
        include '../../Models/Address.php'; // Include the Address model

        $orderModel = new Order();
        $clientModel = new User();
        $addressModel = new Address(); // Create an instance of the Address model

        if (isset($_GET['order_id'])) {
            $order_id = $_GET['order_id'];
            $order = $orderModel->getByOrderID($order_id); 

            if ($order) {
                echo '<h2>Shipping Details</h2>';

                // Retrieve user info
                $user_id = $order[0]['USER_ID'];
                $userInfo = $clientModel->getById($user_id);
                $addressInfo = $addressModel->getAddressInfo($user_id); // Use the getAddressInfo method from the Address model

                if ($userInfo && $addressInfo) {
                    // Display shipping details
                    echo '<p>' . $userInfo['FNAME'] . ' ' . $userInfo['LNAME'] . '</p>';
                    echo '<p>' . $addressInfo['STREET_ADDRESS'] . '</p>';
                    echo '<p>' . $addressInfo['CITY'] . ', ' . $addressInfo['PROVINCE'] . ', ' . $addressInfo['COUNTRY'] . ', ' . $addressInfo['POSTAL_CODE'] . '</p>';
                    echo '<p>Email: ' . $userInfo['EMAIL'] . '</p>';

                    // Retrieve and display order details
                    $orderDetails = $orderModel->getOrderDetails($order_id);
                    echo '<h2>Order Summary</h2>';
                    if ($orderDetails) {
                        foreach ($orderDetails as $detail) {
                            echo '<p>- [' . $detail['QTY'] . '] X $' . $detail['PRICE'] . ' X ' . $detail['NAME'] . ', ' . $detail['SIZE'] . ', ' . $detail['MATERIAL'] . ', ' . $detail['TYPE'] . ', ' . $detail['COLOR'] . '</p>';
                        }

                        $totalPrice = $orderModel->calculateTotalPrice($orderDetails);
                        echo '<h4>Total: $' . number_format($totalPrice, 2) . '</h4>';
                    } else {
                        echo '<p>Order details not found.</p>';
                    }
                } else {
                    echo '<p>User or address details not found.</p>';
                }
            } else {
                echo '<p>Order not found.</p>';
            }
        } else {
            echo '<p>Order ID not specified.</p>';
        }
        ?>

        <button type="button" class="btn btn-primary" name="return" onclick="window.history.back();">RETURN</button>
    </div>

    <!-- Bootstrap JS (optional, for Bootstrap components) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
<footer>
    <?php
    include_once("../../footer.html");
    ?>
</footer>

</html>
