<?php
// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']);

// Debugging: Dump the entire user object
if ($isLoggedIn) {
    // Retrieve the group_id from the user object in the session
    $groupId = isset($_SESSION['user']->group_id) ? $_SESSION['user']->group_id : null;

    // Now, $groupId contains the value of group_id for the logged-in user
    echo "Group ID: " . $groupId;
} else {
    // User is not logged in
    echo "User is not logged in.";
    // You might want to redirect the user to the login page or handle this case appropriately
    exit;
}
?>

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

<body>

<?php include_once __DIR__ . "/../../navbar.php"; ?>

<div class="container my-5">
    <?php
    switch ($groupId) {
        case 1:
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
            if (!empty($data)) {
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
                // No order has been placed yet
                echo '<tr><td colspan="6">No order has been placed yet.</td></tr>';
            }

            echo '</tbody></table>';
            break;

        case 2:
        case 3:
            echo '<h1 class="py-2">Manage Orders</h1>';
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
            if (!empty($data)) {
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
                echo '<tr><td colspan="7">No data available.</td></tr>';
            }
            echo '</tbody></table>';
            break;

        default:
            // Handle unknown user group or no user in session
            echo '<p>No user information found.</p>';
            break;
    }
    ?>
</div>

<?php include_once __DIR__ . "/../../footer.html"; ?>

</body>

</html>
