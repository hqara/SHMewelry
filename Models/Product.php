<?php

include_once(__DIR__ . '/../db_connection.php');

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

    public function __construct($id = -1) {
        global $conn;

        if ($id < 0) {
            // initialize default values
            $this->product_id = -1;
            $this->name = "";
            $this->description = "";
            $this->price = 0;
            $this->manufacturer = "";
            $this->color = "";
            $this->material = "";
            $this->type = "";
            $this->size = "";
            $this->stock = 0;
            $this->product_image = "";
        } else {
            // fetch product details from the database
            $sql = "SELECT * FROM `PRODUCT` WHERE PRODUCT_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $res = $stmt->get_result();
            $assocProduct = $res->fetch_assoc();

            // set object properties
            $this->product_id = $id;
            $this->name = $assocProduct['NAME'];
            $this->description = $assocProduct['DESCRIPTION'];
            $this->price = $assocProduct['PRICE'];
            $this->manufacturer = $assocProduct['MANUFACTURER'];
            $this->color = $assocProduct['COLOR'];
            $this->material = $assocProduct['MATERIAL'];
            $this->type = $assocProduct['TYPE'];
            $this->size = $assocProduct['SIZE'];
            $this->stock = $assocProduct['STOCK'];
            $this->product_image = $assocProduct['PRODUCT_IMAGE'];

            $stmt->close();
        }
    }

    public static function getAllProducts() {
        global $conn;
        $sql = 'SELECT * FROM `PRODUCT`';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductById($product_id): ?array {
        global $conn;
        $sql = 'SELECT * FROM `PRODUCT` WHERE PRODUCT_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    public function getByType($type) {
        global $conn;
        $sql = 'SELECT * FROM PRODUCT WHERE TYPE = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $type);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByMaterial($material) {
        global $conn;
        $sql = 'SELECT * FROM PRODUCT WHERE MATERIAL = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $material);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByTypeAndMaterial($type, $material) {
        global $conn;
        $sql = 'SELECT * FROM PRODUCT WHERE TYPE = ? AND MATERIAL = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $type, $material);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($name, $description, $price, $manufacturer, $color, $material, $type, $size, $stock, $product_image) { // NOT TESTED
        global $conn;
        $sql = 'INSERT INTO PRODUCT (NAME, DESCRIPTION, PRICE, MANUFACTURER, COLOR, MATERIAL, TYPE, SIZE, STOCK, PRODUCT_IMAGE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdsssssis', $name, $description, $price, $manufacturer, $color, $material, $type, $size, $stock, $product_image);
        $stmt->execute();
        $insertedProductId = $stmt->insert_id;
        $stmt->close();
        return $insertedProductId;
    }
    

    public function update($product_id, $name, $description, $price, $manufacturer, $color, $material, $type, $size, $stock, $product_image) {
        global $conn;
        $sql = 'UPDATE PRODUCT SET NAME = ?, DESCRIPTION = ?, PRICE = ?, MANUFACTURER = ?, COLOR = ?, MATERIAL = ?, TYPE = ?, SIZE = ?, STOCK = ?, PRODUCT_IMAGE = ? WHERE PRODUCT_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdsssssisi', $name, $description, $price, $manufacturer, $color, $material, $type, $size, $stock, $product_image, $product_id);
        $stmt->execute();
        return $stmt->affected_rows;
    }
    
    public function delete() {
        global $conn;
        $sql = 'DELETE FROM PRODUCT WHERE PRODUCT_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $this->product_id);
        $stmt->execute();
        return $stmt->affected_rows;
    }
}

?>
