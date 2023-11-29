<?php

include_once(__DIR__ . '/../db_connection.php');

class Orders {

    public $orderId;
    public $totalPrice;
    public $orderDate;
    public $orderStatus;
    public $expectedDelivery;
    public $userId;
    
    function __construct($id = -1) {
        global $conn;
    
        if ($id > 0) {
            // fetch order details from the database
            $sql = "SELECT * FROM `ORDERS` WHERE ORDER_ID = ?";
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
                // Fetch the associative array representing the order
                $assocOrder = $res->fetch_assoc();
    
                // set object properties
                $this->orderId = $id;
                $this->totalPrice = $assocOrder['TOTAL_PRICE'];
                $this->orderDate = $assocOrder['ORDER_DATE'];
                $this->orderStatus = $assocOrder['ORDER_STATUS'];
                $this->expectedDelivery = $assocOrder['EXPECTED_DELIVERY'];
                $this->userId = $assocOrder['USER_ID'];
    
                $stmt->close();
            } else {
                // If no rows are found, set default values
                $this->orderId = -1;
                $this->totalPrice = 0;
                $this->orderDate = "";
                $this->orderStatus = "";
                $this->expectedDelivery = "";
                $this->userId = 0;
            }
        } else {
            // If $id is not a positive integer, set default values
            $this->orderId = -1;
            $this->totalPrice = 0;
            $this->orderDate = "";
            $this->orderStatus = "";
            $this->expectedDelivery = "";
            $this->userId = 0;
        }
    }
    
    public static function list() {
        global $conn;
    
        // Check if group ID is present in the session
        $groupId = isset($_SESSION['group_id']) ? $_SESSION['group_id'] : null;
    
        if ($groupId == 1) {
            // For My Orders (group_id = 1)
            $sql = "SELECT * FROM `ORDERS` WHERE USER_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $_SESSION['user_id']);
        } else {
            // For Manage Orders (group_id = 2 or 3)
            $sql = "SELECT * FROM `ORDERS`";
            $stmt = $conn->prepare($sql);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Return the fetched result
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    
    public static function read() {
        global $conn;

        if (isset($_POST['read'])) {
            $orderId = isset($_POST['order_id']) ? $_POST['order_id'] : null;

            $sql = "SELECT * FROM `ORDERS` WHERE ORDER_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $orderId);
            $stmt->execute();
            $result = $stmt->get_result();
    
            // Return the fetched result
            return $result->fetch_all(MYSQLI_ASSOC);
         }else {
            // Handle the case where order_id is not provided
            return null;
        }
    }
    

    public static function view() {
        global $conn;
    
        if (isset($_POST['view'])) {   
            // Get order_id from the POST data       
            $orderId = isset($_POST['order_id']) ? $_POST['order_id'] : null;
            
            // Validate $orderId (ensure it's a positive integer, for example)
    
            // Prepare and execute the SQL query
            $sql = 'SELECT 
                ORDER_PRODUCTS.QTY, 
                PRODUCT.PRICE, 
                PRODUCT.NAME, 
                PRODUCT.SIZE, 
                PRODUCT.MATERIAL, 
                PRODUCT.TYPE, 
                PRODUCT.COLOR,
                USER.FNAME,
                USER.LNAME,
                USER.EMAIL,
                ADDRESS.STREET_ADDRESS,
                ADDRESS.CITY,
                ADDRESS.PROVINCE,
                ADDRESS.POSTAL_CODE,
                ADDRESS.COUNTRY,
                ORDERS.TOTAL_PRICE
            FROM 
                ORDER_PRODUCTS
            JOIN 
                PRODUCT ON ORDER_PRODUCTS.PRODUCT_ID = PRODUCT.PRODUCT_ID
            JOIN
                ORDERS ON ORDER_PRODUCTS.ORDER_ID = ORDERS.ORDER_ID
            JOIN
                USER ON ORDERS.USER_ID = USER.USER_ID
            JOIN
                ADDRESS ON USER.USER_ID = ADDRESS.USER_ID
            WHERE 
                ORDER_PRODUCTS.ORDER_ID = ?';
        
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $orderId);
            $stmt->execute();
            $result = $stmt->get_result();
        
            // Fetch the result
            $data = $result->fetch_all(MYSQLI_ASSOC);
    
            // Return the fetched data
            return $data;
        }
    
        // Return false if no data is fetched
        return 0;
    }
    
   

    // NOTE: create order function method will NEED to be reviewed/modified, considering: 
    // When order is confirmed, delete automatically user_product (cart) values AND also 
    // create new order by insertion along with order_product values (transfer)
    // session will come handy, however i'm not sure. so this might be not necessary

    public static function calculateCartTotal() {
        global $conn;
    
        // Assuming you have stored the user ID in the session
        session_start();
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    
        // Check if the user ID is available
        if (!$userId) {
            // Handle the case when the user ID is not available (e.g., redirect to login) //*UPDATE THIS ONCE HOMECONTROLLER IS SORTED
            // For demonstration purposes, we'll return 0
            return 0;
        }
    
        // Query to calculate total price based on USER_PRODUCT table
        $sql = 'SELECT SUM(QTY * PRICE) AS total FROM USER_PRODUCT
                JOIN PRODUCT ON USER_PRODUCT.PRODUCT_ID = PRODUCT.PRODUCT_ID
                WHERE USER_PRODUCT.USER_ID = ?';
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    
        // Return the total price
        return $row['total'];
    }
    


    //NEED TO REVIEWED
    public static function create() { 
        global $conn;
    
        if (isset($_POST['create'])) {
            // Get form data
            $userId = $_POST['userId'];
    
            // Create an instance of the Order class
            $newOrder = new Order();
    
            // Calculate the total price
            $totalPrice = $newOrder->calculateCartTotal();
    
            // Prepare and execute the SQL query to insert into ORDERS table
            $sql = 'INSERT INTO ORDERS (TOTAL_PRICE, ORDER_DATE, ORDER_STATUS, EXPECTED_DELIVERY, USER_ID) VALUES (?, NOW(), "Processed", DATE_ADD(NOW(), INTERVAL 5 DAY), ?)';
            $stmt = $conn->prepare($sql);
    
            // Check for errors in preparing the statement
            if (!$stmt) {
                die('Error preparing statement: ' . $conn->error);
            }
    
            // Bind parameters and execute the statement
            $stmt->bind_param('di', $totalPrice, $userId); // Assuming TOTAL_PRICE is a decimal field
            $stmt->execute();
    
            // Check for errors in executing the statement
            if ($stmt->error) {
                // Handle the error (e.g., display an error message or redirect to an error page)
                die('Error executing statement: ' . $stmt->error);
            }
    
            // Get the ID of the inserted order
            $insertedOrderId = $stmt->insert_id;
    
            // Close the statement
            $stmt->close();
    
            // Now you need to add products to the order by inserting into ORDER_PRODUCTS table
            // This is a simplified example; you would get product details from the form or elsewhere //*FIX
            $productId = $_POST['productId'];
            $quantity = $_POST['quantity'];
    
            // Insert into ORDER_PRODUCTS table
            $sql = 'INSERT INTO ORDER_PRODUCTS (ORDER_ID, PRODUCT_ID, QTY) VALUES (?, ?, ?)';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iii', $insertedOrderId, $productId, $quantity);
            $stmt->execute();
    
            // Check for errors in executing the statement
            if ($stmt->error) {
                // Handle the error (e.g., display an error message or log the error)
                die('Error executing statement: ' . $stmt->error);
            }
    
            // Close the statement
            $stmt->close();
    
            // Redirect to a success page or do other post-creation actions
            //header("Location: index.php?controller=order&action=list");
            exit();
        }
    
        // Return false if the 'create' key is not present in the $_POST array
        return false;
    }


 public static function delete() {
    global $conn;

    // Check if the delete button is clicked and order_id is set in the POST data
    if (isset($_POST['delete'])) {
        // Get order_id from the POST data
        $orderId = isset($_POST['order_id']) ? $_POST['order_id'] : null;

        // Check if the order status is not 'SHIPPED' or 'DELIVERED' before deleting
        $statusCheckSql = 'SELECT ORDER_STATUS FROM ORDERS WHERE ORDER_ID = ?';
        $statusCheckStmt = $conn->prepare($statusCheckSql);
        $statusCheckStmt->bind_param('i', $orderId);
        $statusCheckStmt->execute();
        $statusCheckResult = $statusCheckStmt->get_result();

        if ($statusCheckResult->num_rows > 0) {
            $orderStatus = $statusCheckResult->fetch_assoc()['ORDER_STATUS'];

            if ($orderStatus === 'Shipped' || $orderStatus === 'Delivered') {
                echo "Order cannot be deleted if the status is 'SHIPPED' or 'DELIVERED'";
                return false;
            }
        }

        // If the order status is not 'SHIPPED' or 'DELIVERED', proceed with deletion
        $sql = 'DELETE FROM ORDERS WHERE ORDER_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $orderId);

        return $stmt->execute();

         // Redirect 
         header("Location: index.php?controller=orders&action=list");
         exit();
    }

    // Return false if delete button is not clicked or order_id is not set in the POST data
    return false;
}


}


?>
