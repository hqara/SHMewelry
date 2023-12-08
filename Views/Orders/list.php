<!--- FIX SESSION THING ONCE WE'VE ESTABLISHED SESSION -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
</header>
    <?php include_once __DIR__ . "/../../navbar.php"; ?>
</header>
    <div class="container my-5">
        <?php
        
        // Replace this with the actual value from the session
        //$_SESSION['group_id']=2;  // 1 for Client, 2 or 3 for Moderator/Admin
        //$_SESSION['user_id']=1;

        // Check the user's group_id
        $userGroupId= $_SESSION['group_id'];

        if ($userGroupId == 1) {
            // Display for group_id = 1 (My Orders)
            echo '<h1 class="py-2">My Orders</h1>';
            echo '<table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Order Status</th>
                            <th scope="col">Expected Delivery</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>';

            // Check if $data is defined and not empty
            if (isset($data) && is_array($data) && !empty($data)) {
                foreach ($data as $order) {
                    echo '<tr>
                            <td>' . $order['ORDER_ID'] . '</td>
                            <td>' . $order['ORDER_DATE'] . '</td>
                            <td>' . $order['ORDER_STATUS'] . '</td>
                            <td>' . $order['EXPECTED_DELIVERY'] . '</td>
                            <td>
                                <form method="post" action="index.php?controller=orders&action=view&id=' . $order['ORDER_ID'] . '">
                                    <input type="hidden" name="order_id" value="' . $order['ORDER_ID'] . '">
                                    <button type="submit" class="btn btn-primary" name="view">View Order Details</button>
                                </form>
                            </td>
                            <td>';

                    if ($order['ORDER_STATUS'] === 'Shipped' || $order['ORDER_STATUS'] === 'Delivered') {
                        // Order is shipped or delivered, render a disabled button
                        echo '<button class="btn btn-secondary" disabled style="background-color: darkgrey; border: 1px solid grey;">Cancel Order</button>';
                    } else {
                        // Order can be canceled, render the original delete form
                        echo '<form method="post" action="index.php?controller=orders&action=delete">
                                    <input type="hidden" name="order_id" value="' . $order['ORDER_ID'] . '">
                                    <button type="submit" class="btn btn-danger" name="delete">Cancel Order</button>
                                </form>';
                    }

                    echo '</td></tr>';
                }
            } else {
                // No data available
                echo '<tr><td colspan="6">No data available</td></tr>';
            }

            echo '</tbody></table>';
        } else {
            // Display for group_id = 2 or 3 (Manage Orders)
            echo '<h1 class="py-2">MANAGE ORDERS</h1>';
            echo '<table class="table">
                    <thead>
                        <tr>
                            <th scope="col">User ID</th>
                            <th scope="col">Order ID</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Order Status</th>
                            <th scope="col">Expected Delivery</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>';

            // Check if $data is defined and not empty
            if (isset($data) && is_array($data) && !empty($data)) {
                foreach ($data as $order) {
                    echo '<tr>
                            <th scope="row">' . $order['USER_ID'] . '</th>
                            <td>' . $order['ORDER_ID'] . '</td>
                            <td>' . $order['ORDER_DATE'] . '</td>
                            <td>' . $order['ORDER_STATUS'] . '</td>
                            <td>' . $order['EXPECTED_DELIVERY'] . '</td>
                            <td>
                                <form method="post" action="index.php?controller=orders&action=view&id=' . $order['ORDER_ID'] . '">
                                    <input type="hidden" name="order_id" value="' . $order['ORDER_ID'] . '">
                                    <button type="submit" class="btn btn-primary" name="view">View Order Details</button>
                                </form>
                            </td>
                            <td>';

                    if ($order['ORDER_STATUS'] === 'Shipped' || $order['ORDER_STATUS'] === 'Delivered') {
                        // Order is shipped or delivered, render a disabled button
                        echo '<button class="btn btn-secondary" disabled style="background-color: darkgrey; border: 1px solid grey;">Cancel Order</button>';
                    } else {
                        // Order can be canceled, render the original delete form
                        echo '<form method="post" action="index.php?controller=orders&action=delete">
                                    <input type="hidden" name="order_id" value="' . $order['ORDER_ID'] . '">
                                    <button type="submit" class="btn btn-danger" name="delete">Cancel Order</button>
                                </form>';
                    }

                    echo '</td></tr>';
                }
            } else {
                // No data available
                echo '<tr><td colspan="7">No data available</td></tr>';
            }
            echo '</tbody></table>';
        }
        ?>
    </div>

    <footer>
        <?php include_once __DIR__ . "/../../footer.html"; ?>
    </footer>
</body>

</html>
