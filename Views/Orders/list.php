<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <header>
        <?php include('../../navbar.php'); ?>
    </header>
</head>

<body>
    <div class="container my-5">
        <h1 class="py-4">MANAGE ORDERS</h1>
        <table class="table">
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
            <tbody>
                <?php
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
                            </td>';

                        echo '<td>
                                <form method="post" action="index.php?controller=orders&action=delete">
                                    <input type="hidden" name="order_id" value="' . $order['ORDER_ID'] . '">';
                        
                        if ($order['ORDER_STATUS'] === 'Shipped' || $order['ORDER_STATUS'] === 'Delivered') {
                            // Order is shipped or delivered, render a disabled button
                            echo '<button class="btn btn-secondary" disabled style="background-color: darkgrey; border: 1px solid grey;">Cancel Order</button>';
                        } else {
                            // Order can be canceled, render the original delete form
                            echo '<button type="submit" class="btn btn-danger" name="delete">Cancel Order</button>
                                </form>
                            </td>';
                        }
                        echo '</tr>';
                    }
                } else {
                    // No data available
                    echo '<tr><td colspan="7">No data available</td></tr>';
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

<footer>
    <?php include_once("../../footer.html"); ?>
</footer>

</html>
