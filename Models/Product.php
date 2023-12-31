<?php

include_once(__DIR__ . '/../db_connection.php');

class Product
{
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

    function __construct($id = -1)
    {
        global $conn;

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

    public static function list()
    {
        global $conn;
        $sql = 'SELECT * FROM `PRODUCT`';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function search()
    {
        global $conn;
    
        $lookupTerm = isset($_POST['lookup']) ? $_POST['lookup'] : '';
        
        if (!empty($lookupTerm)) {
            $sql = "SELECT * FROM `product` WHERE `name` LIKE ? OR `description` LIKE ?";
    
            $lookupTerm = "%$lookupTerm%";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $lookupTerm, $lookupTerm);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
    
            if ($result->num_rows > 0) {
                $rows = array();
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
    
                return $rows;
            }
        }
    
        return null;
    }
    

    public static function view()
    {
        global $conn;
        $id = isset($_GET['id']) ? $_GET['id'] : -1;

        $sql = "SELECT * FROM `PRODUCT` WHERE PRODUCT_ID = ?;";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;
        }

        return null;
    }

    public static function read()
    {
        $row_count = 0;
        $result = array();

        if (isset($_GET['material'])) {
            $result = Product::viewByJewelrySubtype();
        } else {
            $result = Product::viewByJewelryType();
        }

        return $result;
    }

    private static function viewByJewelryType()
    {
        global $conn;
        $type = isset($_GET['type']) ? $_GET['type'] : 'ring';

        $sql = "SELECT * FROM `PRODUCT` WHERE `TYPE` = ?";
        //$result = $conn->query($sql);

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $type);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;
        }

        return null;
    }

    private static function viewByJewelrySubtype()
    {
        global $conn;

        $type = isset($_GET['type']) ? $_GET['type'] : 'ring';
        $material = isset($_GET['material']) ? $_GET['material'] : 'gold';

        $sql = "SELECT * FROM `PRODUCT` WHERE `TYPE` = ? AND `MATERIAL` = ?;";
        //$result = $conn->query($sql);

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $type, $material);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;
        }

        return null;
    }

    public static function create()
    {
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

            // File upload handling
            $targetDirectory = __DIR__ . "/../assets/images/";
            $targetFile = $targetDirectory . basename($_FILES["product_image"]["name"]);

            // Check file type and move the file
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedExtensions = array("jpg", "jpeg", "png");

            if (in_array($imageFileType, $allowedExtensions)) {
                if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
                    // File uploaded successfully

                    // Prepare and execute the SQL query
                    $sql = 'INSERT INTO PRODUCT (NAME, DESCRIPTION, PRICE, MANUFACTURER, COLOR, MATERIAL, TYPE, SIZE, STOCK, PRODUCT_IMAGE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                    $stmt = $conn->prepare($sql);

                    // Check for errors in preparing the statement
                    if (!$stmt) {
                        die('Error preparing statement: ' . $conn->error);
                    }

                    // Bind parameters and execute the statement
                    $stmt->bind_param('ssdsssssis', $name, $description, $price, $manufacturer, $color, $material, $type, $size, $stock, basename($targetFile));
                    $stmt->execute();

                    // Check for errors in executing the statement
                    if ($stmt->error) {
                        // Handle the error (e.g., display an error message or redirect to an error page)
                        die('Error executing statement: ' . $stmt->error);
                    }

                    // Get the ID of the inserted product
                    $insertedProductId = $stmt->insert_id;

                    // Close the statement
                    $stmt->close();

                    // Redirect to a success page or do other post-creation actions
                    header("Location: index.php?controller=product&action=list");
                    exit();
                } else {
                    // File upload failed
                    die('Error uploading file.');
                }
            } else {
                // Invalid file type
                die('Invalid file type. Only JPG, JPEG, and PNG files are allowed.');
            }
        }

        // Return false if the 'create' key is not present in the $_POST array
        return false;
    }

    public static function update()
    {
        global $conn;

        // Check if the 'update' key is set in the POST data
        if (isset($_POST['update'])) {
            // Check if 'product_id' key is set
            if (isset($_POST['product_id'])) {
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

                // File upload handling
                $targetDirectory = __DIR__ . "/../assets/images/";
                $product_image = $_POST['product_image']; // Initialize with the existing value

                if (!empty($_FILES["product_image"]["name"])) {
                    $targetFile = $targetDirectory . basename($_FILES["product_image"]["name"]);
                    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                    $allowedExtensions = array("jpg", "jpeg", "png");

                    if (in_array($imageFileType, $allowedExtensions)) {
                        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
                            // File uploaded successfully
                            $product_image = basename($targetFile);
                        } else {
                            // File upload failed
                            die('Error uploading file.');
                        }
                    } else {
                        // Invalid file type
                        die('Invalid file type. Only JPG, JPEG, and PNG files are allowed.');
                    }
                }

                // Prepare and execute the SQL update statement
                $sql = 'UPDATE PRODUCT SET NAME = ?, DESCRIPTION = ?, PRICE = ?, MANUFACTURER = ?, COLOR = ?, MATERIAL = ?, TYPE = ?, SIZE = ?, STOCK = ?, PRODUCT_IMAGE = ? WHERE PRODUCT_ID = ?';
                $stmt = $conn->prepare($sql);

                // Check if the prepare statement was successful
                if (!$stmt) {
                    // Handle the case when the prepare statement fails
                    return 0;
                }

                $stmt->bind_param('ssdsssssisi', $name, $description, $price, $manufacturer, $color, $material, $type, $size, $stock, $product_image, $product_id);
                $stmt->execute();

                // Check for errors during the execution of the SQL statement
                if ($stmt->errno) {
                    // Handle the case when an error occurs

                    // Close the statement
                    $stmt->close();

                    return 0;
                }

                // Close the statement
                $stmt->close();

                // Redirect 
                header("Location: index.php?controller=Product&action=list");
                exit();
            }
        }
        // Handle the case when 'update' key is not set
        return 0;
    }

    public static function delete()
    {
        global $conn;

        if (isset($_POST['delete'])) {
            // Get product_id from the POST data
            $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;

            // Validate $product_id (ensure it's a positive integer, for example)

            // Get the file name associated with the product_id
            $sql = 'SELECT PRODUCT_IMAGE FROM PRODUCT WHERE PRODUCT_ID = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $product_id);
            $stmt->execute();
            $stmt->bind_result($product_image);

            // Fetch the result
            $stmt->fetch();

            // Close the statement
            $stmt->close();

            // Delete the product from the database
            $sql = 'DELETE FROM PRODUCT WHERE PRODUCT_ID = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $product_id);
            $stmt->execute();

            // Check for errors in executing the statement
            if ($stmt->error) {
                // Handle the error (e.g., display an error message or redirect to an error page)
                die('Error executing statement: ' . $stmt->error);
            }

            // Close the statement
            $stmt->close();

            // Delete the associated image file
            $targetDirectory = __DIR__ . "/../assets/images/";
            $targetFile = $targetDirectory . $product_image;

            if (file_exists($targetFile)) {
                unlink($targetFile);
            }

            // Redirect 
            header("Location: index.php?controller=product&action=list");
            exit();
        }

        // Handle the case when 'delete' key is not set
        return 0;
    }
}
?>