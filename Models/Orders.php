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
        $userId = isset($_SESSION['user']) ? $_SESSION['user']->user_id : -1;
        $groupId = isset($_SESSION['user']) ? $_SESSION['user']->group_id : -1;
    
        if ($groupId === 1) {
            // For My Orders (group_id = 1)
            $sql = "SELECT * FROM `ORDERS` WHERE USER_ID = ?";
            $stmt = $conn->prepare($sql);
    
            if (!$stmt) {
                throw new Exception("Error preparing SQL statement: " . $conn->error);
            }
    
            // Use $_SESSION['user']->user_id directly
            $stmt->bind_param('i', $userId);
        } else if ($groupId === 2 || $groupId === 3) {
            // For Manage Orders (group_id = 2 or 3)
            $sql = "SELECT * FROM `ORDERS`";
            $stmt = $conn->prepare($sql);
    
            if (!$stmt) {
                throw new Exception("Error preparing SQL statement: " . $conn->error);
            }
        } else {
            // Handle unknown group ID or no group ID in session
            throw new Exception("Invalid group ID or no group ID in session.");
        }
    
        $stmt->execute();
    
        if ($stmt->errno) {
            throw new Exception("Error executing SQL statement: " . $stmt->error);
        }
    
        $result = $stmt->get_result();
    
        if (!$result) {
            throw new Exception("Error getting result: " . $stmt->error);
        }
    
        // Fetch the result
        $data = $result->fetch_all(MYSQLI_ASSOC);
    
        // Close the statement
        $stmt->close();
    
        // Return the fetched result
        return $data;
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
        } else {
            // Handle the case where order_id is not provided
            return null;
        }
    }

    public static function view()
    {
        global $conn;
    
        if (isset($_POST['view'])) {
            // Get order_id from the POST data
            $orderId = isset($_POST['order_id']) ? $_POST['order_id'] : null;
    
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
                ADDRESS.ADDRESS_ID,
                ADDRESS.STREET_ADDRESS,
                ADDRESS.CITY,
                ADDRESS.PROVINCE,
                ADDRESS.POSTAL_CODE,
                ADDRESS.COUNTRY,
                ORDERS.ORDER_ID,
                ORDERS.TOTAL_PRICE
            FROM 
                ORDERS
            JOIN 
                USER ON ORDERS.USER_ID = USER.USER_ID
            JOIN
                ADDRESS ON USER.USER_ID = ADDRESS.USER_ID
            JOIN
                ORDER_PRODUCTS ON ORDERS.ORDER_ID = ORDER_PRODUCTS.ORDER_ID
            JOIN
                PRODUCT ON ORDER_PRODUCTS.PRODUCT_ID = PRODUCT.PRODUCT_ID
            WHERE 
                ORDER_PRODUCTS.ORDER_ID = ?';
    
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $orderId);
            $stmt->execute();
            $result = $stmt->get_result();
    
            // Fetch the result
            $data = $result->fetch_all(MYSQLI_ASSOC);
    
            // Close the statement
            $stmt->close();
    
            // Return the fetched data
            return $data;
        }
    
        // Return false if no data is fetched
        return 0;
    }
    
    public static function viewCart()
    {
        global $conn;
    
        if (isset($_SESSION['user']) && isset($_SESSION['user']->user_id)) {
            $userId = $_SESSION['user']->user_id;
    
            $sql = 'SELECT Distinct
                USER_PRODUCT.QTY, 
                PRODUCT.PRODUCT_ID,
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
                ADDRESS.COUNTRY
            FROM 
                USER_PRODUCT
            JOIN 
                PRODUCT ON USER_PRODUCT.PRODUCT_ID = PRODUCT.PRODUCT_ID
            JOIN
                USER ON USER_PRODUCT.USER_ID = USER.USER_ID
            LEFT JOIN
                ADDRESS ON USER.USER_ID = ADDRESS.USER_ID
            WHERE 
                USER_PRODUCT.USER_ID = ?';
    
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result();
    
            // Fetch the result
            $data = $result->fetch_all(MYSQLI_ASSOC);
    
            // Return the fetched data
            return $data;
        }
    
        // Return false if no user in session
        return 0;
    }

    public static function calculateCartTotal() {
        global $conn;

        $userId = isset($_SESSION['user']) ? $_SESSION['user']->user_id : null;

        // Check if the user ID is available
        if (!$userId) {
            die('Error: User ID not available. Please log in.');
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

    public static function create()
    {
        global $conn;
    
        try {
            // Check if the 'create' key is present in the $_POST array
            if (isset($_POST['create'])) {
    
                // Check if the user is logged in
                if (!isset($_SESSION['user']) || !isset($_SESSION['user']->user_id)) {
                    throw new Exception('Error: User not logged in.');
                }
    
                // The current client in session is placing an order
                $userId = $_SESSION['user']->user_id;
    
                // Fetch cart details using the viewCart method
                $newOrder = new Orders();
                $cartDetails = $newOrder->viewCart();
    
                // Calculate the total price
                $totalPrice = $newOrder->calculateCartTotal();
    
                // Prepare and execute the SQL query to insert into ORDERS table
                $sql = 'INSERT INTO ORDERS (TOTAL_PRICE, ORDER_DATE, ORDER_STATUS, EXPECTED_DELIVERY, USER_ID) VALUES (?, NOW(), "Processed", DATE_ADD(NOW(), INTERVAL 5 DAY), ?)';
                $stmt = $conn->prepare($sql);
    
                // Check for errors in preparing the statement
                if (!$stmt) {
                    throw new Exception('Error preparing statement: ' . $conn->error);
                }
    
                // Bind parameters and execute the statement
                $stmt->bind_param('di', $totalPrice, $userId);
                $stmt->execute();
    
                // Check for errors in executing the statement
                if ($stmt->error) {
                    throw new Exception('Error executing statement: ' . $stmt->error);
                }
    
                // Get the ID of the inserted order
                $insertedOrderId = $stmt->insert_id;
    
                // Close the statement
                $stmt->close();
    
                // Insert each cart item into ORDER_PRODUCTS table
                foreach ($cartDetails as $cartItem) {
                    $productId = $cartItem['PRODUCT_ID'];
                    $quantity = $cartItem['QTY'];
    
                    $sql = 'INSERT INTO ORDER_PRODUCTS (ORDER_ID, PRODUCT_ID, QTY) VALUES (?, ?, ?)';
                    $stmt = $conn->prepare($sql);
    
                    // Check for errors in preparing the statement
                    if (!$stmt) {
                        throw new Exception('Error preparing statement: ' . $conn->error);
                    }
    
                    // Bind parameters and execute the statement
                    $stmt->bind_param('iii', $insertedOrderId, $productId, $quantity);
                    $stmt->execute();
    
                    // Check for errors in executing the statement
                    if ($stmt->error) {
                        throw new Exception('Error executing statement: ' . $stmt->error);
                    }
    
                    // Close the statement
                    $stmt->close();
                }
    
                // Delete entries from USER_PRODUCT table for the user
                $sqlDelete = 'DELETE FROM USER_PRODUCT WHERE USER_ID = ?';
                $stmtDelete = $conn->prepare($sqlDelete);
    
                // Check for errors in preparing the delete statement
                if (!$stmtDelete) {
                    throw new Exception('Error preparing delete statement: ' . $conn->error);
                }
    
                // Bind parameters and execute the delete statement
                $stmtDelete->bind_param('i', $userId);
                $stmtDelete->execute();
    
                // Check for errors in executing the delete statement
                if ($stmtDelete->error) {
                    throw new Exception('Error executing delete statement: ' . $stmtDelete->error);
                }
    
                // Close the delete statement
                $stmtDelete->close();
    
                // Redirect to a success page or do other post-creation actions
                header("Location: index.php?controller=orders&action=read");
                exit();
            }
        } catch (Exception $e) {
            //Duplicate key error for Orders Table. Disregard and proceed. 
            
            // Delete entries from USER_PRODUCT table for the user
            $sqlDelete = 'DELETE FROM USER_PRODUCT WHERE USER_ID = ?';
            $stmtDelete = $conn->prepare($sqlDelete);
    
            // Check for errors in preparing the delete statement
            if (!$stmtDelete) {
                throw new Exception('Error preparing delete statement: ' . $conn->error);
            }
    
            // Bind parameters and execute the delete statement
            $stmtDelete->bind_param('i', $userId);
            $stmtDelete->execute();
    
            // Check for errors in executing the delete statement
            if ($stmtDelete->error) {
                throw new Exception('Error executing delete statement: ' . $stmtDelete->error);
            }
    
            // Close the delete statement
            $stmtDelete->close();
            
            header("Location: index.php?controller=orders&action=read");
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

            $success = $stmt->execute();

            // Close the prepared statements
            $stmt->close();
            $statusCheckStmt->close();

            // Redirect 
            if ($success) {
                header("Location: index.php?controller=orders&action=list");
                exit();
            }
        }

        // Return false if delete button is not clicked or order_id is not set in the POST data
        return false;
    }

    public static function deleteOrder()
    {
        global $conn;
    
        // Check if the delete button is clicked and order_id is set in the POST data
        if (isset($_POST['delete'])) {
            // Get order_id from the POST data
            $orderId = isset($_POST['order_id']) ? $_POST['order_id'] : null;
    
            // Prepare and execute the SQL query to delete from ORDERS table
            $sql = 'DELETE FROM ORDERS WHERE ORDER_ID = ?';
            $stmt = $conn->prepare($sql);
    
            // Check for errors in preparing the statement
            if ($stmt) {
                // Bind parameters and execute the statement
                $stmt->bind_param('i', $orderId);
                $success = $stmt->execute();
                $stmt->close();
    
                // Redirect if the deletion is successful
                if ($success) {
                    header("Location: index.php?controller=home&action=index");
                    exit();
                }
            } else {
                // Handle the error (e.g., display an error message or log the error)
                die('Error preparing statement: ' . $conn->error);
            }
        }
    
        // Return false if delete button is not clicked or order_id is not set in the POST data
        return false;
    }
}    