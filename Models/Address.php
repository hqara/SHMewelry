<?php

include_once(__DIR__ . '/../db_connection.php');

class Address {
    public $address_id;
    public $street_address;
    public $city;
    public $province;
    public $postal_code;
    public $country;
    public $is_default;
    public $user_id;
  

    function __construct($id = -1) {
        global $conn;

        if ($id > 0) {
            // fetch address details from the database
            $sql = "SELECT * FROM `ADDRESS` WHERE ADDRESS_ID = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error preparing statement: " . $conn->error);
            }

            $stmt->bind_param('i', $id);
            $stmt->execute();
            $res = $stmt->get_result();

            if (!$res) {
                throw new Exception("Error executing statement: " . $stmt->error);
            }

            if ($res->num_rows > 0) {
                $assocAddress = $res->fetch_assoc();

                $this->address_id = $id;
                $this->user_id = $assocAddress['USER_ID'];
                $this->street_address = $assocAddress['STREET_ADDRESS'];
                $this->city = $assocAddress['CITY'];
                $this->province = $assocAddress['PROVINCE'];
                $this->postal_code = $assocAddress['POSTAL_CODE'];
                $this->country = $assocAddress['COUNTRY'];
                $this->is_default = $assocAddress['IS_DEFAULT'];

                $stmt->close();
            } else {
                $this->address_id = -1;
                $this->user_id = -1;
                $this->street_address = "";
                $this->city = "";
                $this->province = "";
                $this->postal_code = "";
                $this->country = "";
                $this->is_default = false;
            }
        } else {
            $this->address_id = -1;
            $this->user_id = -1;
            $this->street_address = "";
            $this->city = "";
            $this->province = "";
            $this->postal_code = "";
            $this->country = "";
            $this->is_default = false;
        }
    }

    public static function create() {
        global $conn;
    
        // Check if the 'create' key is set in the $_POST array
        if (isset($_POST['create'])) {
            // Get form data
            $street_address = $_POST['street_address'];
            $city = $_POST['city'];
            $province = $_POST['province'];
            $postal_code = $_POST['postal_code'];
            $country = $_POST['country'];
            $user_id = $_POST['user_id'];
            
            // Check if the checkbox is checked
            $is_default = isset($_POST['set_default']) ? 1 : 0;
    
            // Prepare and execute the SQL query
            $sql = 'INSERT INTO ADDRESS (STREET_ADDRESS, CITY, PROVINCE, POSTAL_CODE, COUNTRY, USER_ID, IS_DEFAULT) VALUES (?, ?, ?, ?, ?, ?, ?)';
            $stmt = $conn->prepare($sql);
    
            // Check for errors in preparing the statement
            if (!$stmt) {
                die('Error preparing statement: ' . $conn->error);
            }
    
            // Bind parameters and execute the statement
            $stmt->bind_param('ssssssi', $street_address, $city, $province, $postal_code, $country, $user_id, $is_default);
            $stmt->execute();
    
            // Check for errors in executing the statement
            if ($stmt->error) {
                // Handle the error (e.g., display an error message or redirect to an error page)
                die('Error executing statement: ' . $stmt->error);
            }
    
            // Get the ID of the inserted address
            $insertedAddressId = $stmt->insert_id;
    
            // Close the statement
            $stmt->close();
    
            // Redirect
            //header("Location: index.php?controller=address&action=view");
            exit();
        }
    
        // Return false if the 'create' key is not present in the $_POST array
        return false;
    }
    
    public static function update() {

         global $conn;
    
            // Check if the 'update' key is set in the POST data
            if (isset($_POST['update'])) {
                // Check if 'user_id' key is set
                if (isset($_POST['address_id'])) {
                    // Get form data
                    $address_id = $_POST['address_id'];
                    $street_address = $_POST['street_address'];
                    $city = $_POST['city'];
                    $province = $_POST['province'];
                    $postal_code = $_POST['postal_code'];
                    $country = $_POST['country'];
                    $user_id = $_POST['user_id'];
                    $is_default = isset($_POST['is_default']) ? 1 : 0;
    
                    // Prepare and execute the SQL update statement
                    $sql = 'UPDATE ADDRESS SET STREET_ADDRESS = ?, CITY = ?, PROVINCE = ?, POSTAL_CODE = ?, COUNTRY = ?, IS_DEFAULT = ? WHERE ADDRESS_ID = ?';
                    $stmt = $conn->prepare($sql);
    
                    // Check if the prepare statement was successful
                    if (!$stmt) {
                        // Handle the case when the prepare statement fails
                        return 0;
                    }
    
                    $stmt->bind_param('sssssii', $street_address, $city, $province, $postal_code, $country, $is_default, $address_id);
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
                    //header("Location: index.php?controller=address&action=view");
                    exit();
                }
            }
            // Handle the case when 'update' key is not set
            return 0;
        }


        //THIS IS NOT USED ANYWHERE FOR NOW
        public static function delete() {
            global $conn;
    
            if (isset($_POST['delete'])) {
                // Get address_id from the POST data
                $address_id = isset($_POST['address_id']) ? $_POST['address_id'] : null;
    
                // Prepare and execute the SQL query
                $sql = 'DELETE FROM ADDRESS WHERE ADDRESS_ID = ?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $address_id);
                $stmt->execute();
    
                // Check for errors in executing the statement
                if ($stmt->error) {
                    // Handle the error (e.g., display an error message or redirect to an error page)
                    die('Error executing statement: ' . $stmt->error);
                }
    
                // Close the statement
                $stmt->close();
    
                // Redirect
                //header("Location: index.php?controller=address&action=view");
                exit();
            }
    
            // Return false if the 'delete' key is not present in the $_POST array
            return 0;
        }
    }

?>