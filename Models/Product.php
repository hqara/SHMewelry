<?php 

include_once(__DIR__ . '/../db_connection.php');

class Product{

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

function __construct($id = -1) {
    global $conn;

    // Check if $id is a positive integer
    if ($id > 0) {
        // fetch product details from the database
        $sql = "SELECT * FROM `PRODUCT` WHERE PRODUCT_ID = ?";
        $stmt = $conn->prepare($sql);

        // Check if the prepared statement was successful
        if (!$stmt) {
            throw new Exception("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();

        // Check if the execution was successful
        if (!$res) {
            throw new Exception("Error executing statement: " . $stmt->error);
        }

        // Check if there are rows returned
        if ($res->num_rows > 0) {
            // Fetch the associative array representing the product
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
        } else {
            // If no rows are found, set default values
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
        }
    } else {
        // If $id is not a positive integer, set default values
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
    }
}


public static function list(){
    global $conn;
    $sql = 'SELECT * FROM `PRODUCT`';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}



public static function view() {
    global $conn;

    // Check if the 'view' key is present in the $_POST array
    if (isset($_POST['view'])) {
        // Retrieve the product_id from the $_POST array
        $product_id = $_POST['product_id'];

        // Prepare and execute the SQL query
        $sql = 'SELECT * FROM `PRODUCT` WHERE PRODUCT_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are rows returned
        if ($result->num_rows > 0) {
            // Return the associative array representing the product
            return $result->fetch_assoc();
        }

        // Return null if no rows are found
        return null;
    }

    // Return null if the 'view' key is not present in the $_POST array
    return null;
}


public static function create() {
    global $conn;

    if (isset($_POST['create'])) {
        // Get form data
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $manufacturer = $_POST['manufacturer'];
        $color = $_POST['color'];
        $material = $_POST['material'];
        $type = $_POST['type'];
        $size = $_POST['size'];
        $stock = $_POST['stock'];
        $product_image = $_POST['product_image'];

        // Prepare and execute the SQL query
        $sql = 'INSERT INTO PRODUCT (NAME, DESCRIPTION, PRICE, MANUFACTURER, COLOR, MATERIAL, TYPE, SIZE, STOCK, PRODUCT_IMAGE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);

        // Check for errors in preparing the statement
        if (!$stmt) {
            die('Error preparing statement: ' . $conn->error);
        }

        // Bind parameters and execute the statement
        $stmt->bind_param('ssdsssssis', $name, $description, $price, $manufacturer, $color, $material, $type, $size, $stock, $product_image);
        $stmt->execute();

        // Check for errors in executing the statement
        if ($stmt->error) {
            die('Error executing statement: ' . $stmt->error);
        }

        // Get the ID of the inserted product
        $insertedProductId = $stmt->insert_id;

        // Close the statement
        $stmt->close();

        // Return the ID of the inserted product
        return $insertedProductId;
    }

    // Return false if the 'create' key is not present in the $_POST array
    return false;
}

public static function update(){  
    global $conn;

    if (isset($_POST['update'])) {
        // Get form data
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $manufacturer = $_POST['manufacturer'];
        $color = $_POST['color'];
        $material = $_POST['material'];
        $type = $_POST['type'];
        $size = $_POST['size'];
        $stock = $_POST['stock'];
        $product_image = $_POST['product_image'];

        $sql = 'UPDATE PRODUCT SET NAME = ?, DESCRIPTION = ?, PRICE = ?, MANUFACTURER = ?, COLOR = ?, MATERIAL = ?, TYPE = ?, SIZE = ?, STOCK = ?, PRODUCT_IMAGE = ? WHERE PRODUCT_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdsssssisi', $name, $description, $price, $manufacturer, $color, $material, $type, $size, $stock, $product_image, $product_id);
        $stmt->execute();
        return $stmt->affected_rows;
    }
}
/*
public static function update() {
    global $conn;

    // Check if the 'update' key is present in the $_POST array
    if (isset($_POST['update'])) {
        // Get form data
        $product_id = $_POST['product_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $manufacturer = $_POST['manufacturer'];
        $color = $_POST['color'];
        $material = $_POST['material'];
        $type = $_POST['type'];
        $size = $_POST['size'];
        $stock = $_POST['stock'];
        $product_image = $_POST['product_image'];

        // Prepare and execute the SQL query
        $sql = 'UPDATE PRODUCT SET NAME = ?, DESCRIPTION = ?, PRICE = ?, MANUFACTURER = ?, COLOR = ?, MATERIAL = ?, TYPE = ?, SIZE = ?, STOCK = ?, PRODUCT_IMAGE = ? WHERE PRODUCT_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdsssssisi', $name, $description, $price, $manufacturer, $color, $material, $type, $size, $stock, $product_image, $product_id);
        $stmt->execute();

        // Return the number of affected rows
        return $stmt->affected_rows;
    }

    // Return 0 if the 'update' key is not present in the $_POST array
    return 0;
    }*/
}

?>