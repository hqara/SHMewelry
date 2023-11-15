<?php

include_once(__DIR__ . '/../db_connection.php');

class Order {

    public $orderId;
    public $totalPrice;
    public $orderDate;
    public $orderStatus;
    public $expectedDelivery;
    public $userId;

    public function __construct($id = -1) {
        global $conn;

        if ($id < 0) {
            // initialize default values
            $this->orderId = -1;
            $this->totalPrice = 0;
            $this->orderDate = "";
            $this->orderStatus = "";
            $this->expectedDelivery = "";
            $this->userId = 0;
        } else {
            // fetch product details from the database
            $sql = "SELECT * FROM `ORDERS` WHERE ORDER_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $res = $stmt->get_result();
            $assocOrder = $res->fetch_assoc();

             // set object properties
            $this->orderId = $id;
            $this->totalPrice = $assocOrder['TOTAL_PRICE'];
            $this->orderDate = $assocOrder['ORDER_DATE'];
            $this->orderStatus = $assocOrder['ORDER_STATUS'];
            $this->expectedDelivery = $assocOrder['EXPECTED_DELIVERY'];
            $this->userId = $assocOrder['USER_ID'];

            $stmt->close();
        }
    }

    public function getAllOrders() {
        global $conn;
        $sql = 'SELECT * FROM `ORDERS`';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getByOrderID($order_id): ?array {
        global $conn;
        $sql = 'SELECT * FROM `ORDERS` WHERE ORDER_ID = ?'; 
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getByUserID($user_id) {
        global $conn;
        $sql = 'SELECT * FROM `ORDERS` WHERE USER_ID = ?'; 
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrderDetails($order_id): ?array {
        global $conn;
        $sql = 'SELECT ORDER_PRODUCTS.QTY, PRODUCT.PRICE, PRODUCT.NAME, PRODUCT.SIZE, PRODUCT.MATERIAL, PRODUCT.TYPE, PRODUCT.COLOR
                FROM ORDER_PRODUCTS
                JOIN PRODUCT ON ORDER_PRODUCTS.PRODUCT_ID = PRODUCT.PRODUCT_ID
                WHERE ORDER_PRODUCTS.ORDER_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            // Fetch all rows as associative array
            $orderDetails = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $orderDetails;
        } else {
            // No rows found
            $stmt->close();
            return null;
        }
    }
    
    
    public static function listAllOrders() {
        global $conn;
        $list = array();

        $sql = "SELECT * FROM `ORDERS`";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->execute();
            $res = $stmt->get_result();
            $stmt->close();

            while ($row = $res->fetch_assoc()) {
                $order = new Order();
                $order->userId = $row['USER_ID'];
                $order->orderId = $row['ORDER_ID'];
                $order->totalPrice = $row['TOTAL_PRICE'];
                $order->orderDate = $row['ORDER_DATE'];
                $order->orderStatus = $row['ORDER_STATUS'];
                $order->expectedDelivery = $row['EXPECTED_DELIVERY'];

                array_push($list, $order);
            }
        }

        return $list;
    }

    public static function listOrdersByUserID($userId) {
        global $conn;
        $list = array();

        $sql = "SELECT * FROM `ORDERS` WHERE `USER_ID` = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('i', $userId);
            $stmt->execute();

            $res = $stmt->get_result();

            while ($row = $res->fetch_assoc()) {
                $order = new Order();
                $order->orderId = $row['ORDER_ID'];
                $order->totalPrice = $row['TOTAL_PRICE'];
                $order->orderDate = $row['ORDER_DATE'];
                $order->orderStatus = $row['ORDER_STATUS'];
                $order->expectedDelivery = $row['EXPECTED_DELIVERY'];

                array_push($list, $order);
            }
            $stmt->close();
        }
        return $list;
    }

    public function create($totalPrice, $orderDate, $expectedDelivery, $userId) { //NOT TESTED YET 
        global $conn;
        $defaultOrderStatus = 'Processed';
        $sql = 'INSERT INTO `ORDERS` (TOTAL_PRICE, ORDER_DATE, ORDER_STATUS, EXPECTED_DELIVERY, USER_ID) VALUES (?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('dsssi', $totalPrice, $orderDate, $defaultOrderStatus, $expectedDelivery, $userId);
        $stmt->execute();
        $insertedOrderId = $stmt->insert_id;
        $stmt->close();

        return $insertedOrderId;
    }
    

    function update($orderId, $totalPrice, $orderDate, $orderStatus, $expectedDelivery){  // NOT USED
        global $conn;
        $sql = "UPDATE `ORDERS` SET `TOTAL_PRICE` = ?, `ORDER_DATE` = ?, `ORDER_STATUS` = ?, `EXPECTED_DELIVERY` = ? WHERE `ORDER_ID` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dssssi", $totalPrice, $orderDate, $orderStatus, $expectedDelivery, $orderId);
        $stmt->execute();
        $stmt->close();
    }

    public function updateOrderStatus($orderStatus) {
        global $conn;
        $sql = "UPDATE `ORDERS` SET `ORDER_STATUS` = ? WHERE `ORDER_ID` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $orderStatus, $this->orderId);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function delete() {
        global $conn;
        $sql = "DELETE FROM `ORDERS` WHERE `ORDER_ID` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $this->orderId);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function calculateTotalPrice($orderDetails): float {
        $totalPrice = 0;

        foreach ($orderDetails as $detail) {
            $totalPrice += $detail['QTY'] * $detail['PRICE'];
        }

        return $totalPrice;
    }

}

?>
