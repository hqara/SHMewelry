<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>My Orders</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Order Status</th>
                    <th scope="col">Expected Delivery</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                include '../../Models/Order.php'; 
                $conn = Order::getConnection(); 
                $orderModel = new Order(); 
                $user_id = 1;  // FOR NOW

                $orders = $orderModel->getByUserID($user_id); // Get orders for a specific user

                foreach ($orders as $order) {
                    echo '<tr>
                        <td>' . $order['ORDER_ID'] . '</td>
                        <td>' . $order['ORDER_DATE'] . '</td>
                        <td>' . $order['ORDER_STATUS'] . '</td>
                        <td>' . $order['EXPECTED_DELIVERY'] . '</td>
                        <td>'; // Open the <td> tag for actions

                    // View Order Details button
                    echo '<button class="btn btn-primary">
                            <a href="view_order.php?order_id=' . $order['ORDER_ID'] . '" class="text-light">View Order Details</a>
                        </button>';

                    // Check if the order status is "Shipped" or "Delivered"
                    if ($order['ORDER_STATUS'] !== 'Shipped' && $order['ORDER_STATUS'] !== 'Delivered') {
                        // Display the cancel button
                        echo '<button class="btn btn-danger">
                                <a href="cancel_order.php?order_id=' . $order['ORDER_ID'] . '" class="text-light">Cancel Order</a>
                            </button>';
                    } else {
                        // Order is shipped or delivered, disable the cancel button with dark grey background
                        echo '<button class="btn btn-disabled" disabled style="background-color: darkgrey; style="background-color: #555; border: 1px solid grey;">
                                Cancel Order
                            </button>';
                    }

                    echo '</td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS (optional, for Bootstrap components) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
