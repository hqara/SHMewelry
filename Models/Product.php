<?php

class Product {

    public $product_id;
    public $name;
    public $description;
    public $price;
    public $manufacturer;
    public $color;
    public $material;
    public $type;
    public $size;
    public $stock;
    public $product_image;

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
        $SQL = 'SELECT * FROM PRODUCT';
        $result = self::$_connection->query($SQL);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($product_id) {
        $SQL = 'SELECT * FROM PRODUCT WHERE PRODUCT_ID = ?';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getByType($type) {
        $SQL = 'SELECT * FROM PRODUCT WHERE TYPE = ?';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('s', $type);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByMaterial($material) {
        $SQL = 'SELECT * FROM PRODUCT WHERE MATERIAL = ?';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('s', $material);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByTypeAndMaterial($type, $material) {
        $SQL = 'SELECT * FROM PRODUCT WHERE TYPE = ? AND MATERIAL = ?';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('ss', $type, $material);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create() {
        $SQL = 'INSERT INTO PRODUCT (NAME, DESCRIPTION, PRICE, MANUFACTURER, COLOR, MATERIAL, TYPE, SIZE, STOCK, PRODUCT_IMAGE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('ssdsssssis', $this->name, $this->description, $this->price, $this->manufacturer, $this->color, $this->material, $this->type, $this->size, $this->stock, $this->product_image);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function update() {
        $SQL = 'UPDATE PRODUCT SET NAME = ?, DESCRIPTION = ?, PRICE = ?, MANUFACTURER = ?, COLOR = ?, MATERIAL = ?, TYPE = ?, SIZE = ?, STOCK = ?, PRODUCT_IMAGE = ? WHERE PRODUCT_ID = ?';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('ssdsssssisi', $this->name, $this->description, $this->price, $this->manufacturer, $this->color, $this->material, $this->type, $this->size, $this->stock, $this->product_image, $this->product_id);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function delete() {
        $SQL = 'DELETE FROM PRODUCT WHERE PRODUCT_ID = ?';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('i', $this->product_id);
        $stmt->execute();
        return $stmt->affected_rows;
    }
}

?>
