<?php

class Order {

    public $order_id;
    public $total_price;
    public $order_date;
    public $order_status;
    public $expected_delivery;
    public $user_id;

    private static $_connection = null;

    public function __construct() {
        if (self::$_connection == null) {
            $host = 'localhost';
            $user = 'root';
            $password = '';
            $dbname = 'shmewelry'; 

            self::$_connection = new mysqli($host, $user, $password, $dbname);

            if (self::$_connection->connect_error) {
                die("Connection failed: " . self::$_connection->connect_error);
            }
        }
    }

    public static function getConnection() {
        return self::$_connection;
    }

    public function getAll() {
        $SQL = 'SELECT * FROM `ORDER`';
        $result = self::$_connection->query($SQL);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($order_id): ?array {
        $SQL = 'SELECT * FROM `ORDER` WHERE ORDER_ID = ?';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) { // no rows found
            return $result->fetch_assoc();
        }

        return null;
    }

    public function getByUserID($user_id) {
        $SQL = 'SELECT * FROM `ORDER` WHERE USER_ID = ?';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create() {
        $SQL = 'INSERT INTO `ORDER` (TOTAL_PRICE, ORDER_DATE, ORDER_STATUS, EXPECTED_DELIVERY, USER_ID) VALUES (?, ?, ?, ?, ?)';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('dsssi', $this->total_price, $this->order_date, $this->order_status, $this->expected_delivery, $this->user_id);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function update() {
        $SQL = 'UPDATE `ORDER` SET TOTAL_PRICE = ?, ORDER_DATE = ?, ORDER_STATUS = ?, EXPECTED_DELIVERY = ?, USER_ID = ? WHERE ORDER_ID = ?';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('dsssi', $this->total_price, $this->order_date, $this->order_status, $this->expected_delivery, $this->user_id, $this->order_id);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function delete() {
        $SQL = 'DELETE FROM `ORDER` WHERE ORDER_ID = ?';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('i', $this->order_id);
        $stmt->execute();
        return $stmt->affected_rows;
    }
}

?>
