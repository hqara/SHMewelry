<?php

include_once(__DIR__ . '/../db_connection.php');

class Login {

    public $user_id;
    public $fname;
    public $lname;
    public $email;
    public $password;
    public $group_id;
    
    public function __construct($id = -1) {
        global $conn;
    
        if ($id > 0) {
            // fetch user details from the database
            $sql = "SELECT * FROM `USER` WHERE USER_ID = ?";
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
                // Fetch the associative array representing the user
                $assocUser = $res->fetch_assoc();
    
                // set object properties
                $this->user_id = $id;
                $this->fname = $assocUser['FNAME'];
                $this->lname = $assocUser['LNAME'];
                $this->email = $assocUser['EMAIL'];
                $this->password = $assocUser['PASSWORD'];
                $this->group_id = $assocUser['GROUP_ID'];
    
                // Assign session values here
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $assocUser['EMAIL'];
                $_SESSION['fname'] = $assocUser['FNAME'];
                $_SESSION['lname'] = $assocUser['LNAME'];
                $_SESSION['group_id'] = $assocUser['GROUP_ID'];
    
                $stmt->close();
            } else {
                // If no rows are found, set default values
                $this->user_id = -1;
                $this->fname = "";
                $this->lname = "";
                $this->email = "";
                $this->password = "";
                $this->group_id = 0;
            }
        } else {
            // If $id is not a positive integer, set default values
            $this->user_id = -1;
            $this->fname = "";
            $this->lname = "";
            $this->email = "";
            $this->password = "";
            $this->group_id = 0;
        }
    }
    
    public static function create() {
        global $conn;
    
        try {
            if (isset($_POST['create'])) {
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $group_id = $_POST['group_id'];
    
                // Check for empty fields
                if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($group_id)) {
                    throw new Exception("All fields are required");
                }
    
                // Check if the email already exists
                $checkQuery = "SELECT USER_ID FROM USER WHERE EMAIL = ?";
                $checkStmt = $conn->prepare($checkQuery);
                $checkStmt->bind_param("s", $email);
                $checkStmt->execute();
                $checkStmt->store_result();
    
                if ($checkStmt->num_rows > 0) {
                    $checkStmt->close();
                    throw new Exception("Email already registered");
                }
    
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
                // Prepare and execute the SQL query
                $query = "INSERT INTO USER (FNAME, LNAME, EMAIL, PASSWORD, GROUP_ID) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
    
                if (!$stmt) {
                    throw new Exception("Error preparing statement: " . $conn->error);
                }
    
                // Bind parameters and execute the statement
                $stmt->bind_param('ssssi', $fname, $lname, $email, $hashedPassword, $group_id);
                $stmt->execute();
    
                if ($stmt->error) {
                    throw new Exception("Error executing statement: " . $stmt->error);
                }
    
                // Registration successful
                $_SESSION['registration_success'] = "Registration successful!";
    
                // Close the statement
                $stmt->close();
    
                // Redirect
                header("Location: index.php?controller=login&action=login");
                exit;
            } else {
                throw new Exception("Invalid form submission");
            }
        } catch (Exception $e) {
            $_SESSION['registration_error'] = $e->getMessage();
            header('Location: index.php?controller=login&action=register');
            exit;
        }
    }
    
    public static function login() {
        global $conn;
        $isLoggedIn = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT USER_ID, FNAME, LNAME, GROUP_ID, PASSWORD FROM USER WHERE EMAIL = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($user_id, $fname, $lname, $group_id, $storedPassword);
                $stmt->fetch();

                if (password_verify($password, $storedPassword)) {
                    // User logged in
                    $isLoggedIn = true;

                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['username'] = $username;
                    $_SESSION['fname'] = $fname;
                    $_SESSION['lname'] = $lname;
                    $_SESSION['group_id'] = $group_id;

                    // Redirect to home page or any other page after successful login
                    header('Location: index.php?controller=home&action=index');
                    exit();
                }
            }

            // If login is not successful, set an error message
            $_SESSION['login_error'] = "Invalid username or password";
            header('Location: index.php?controller=login&action=login');
            exit();
        }
    }

}