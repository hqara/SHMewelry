<?php
include '../../Models/Order.php';

$conn = Order::getConnection();

if (isset($_GET['order_id'])) {
    $id = $_GET['order_id'];

    $orderModel = new Order();
    $orderModel->order_id = $id;

    $rowsAffected = $orderModel->delete();

    if ($rowsAffected > 0) {
        // Deleted successfully

        // $group_id represents the user's role
           // 1 for Client
            // 2 for Moderator 
            // 3 for Admin 
        $groupId = "1"; //FOR NOW 

        // Redirect based on user role
        switch ($groupId) {
            case 1:
                header("location: my_orders.php");
                break;
            case 2:
            case 3:
                header("location: manage_orders.php");
                break;
        }

    } else {
        die("Error deleting order: " . mysqli_error($conn));
    }
}
?>
