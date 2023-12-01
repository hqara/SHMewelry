<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once __DIR__ . "/../db_connection.php";
include_once '../Models/User.php';


class RegisterController {
    
   private $conn; // Database connection

    public function __construct() {
        $this->connectToDatabase(); // Establish the database connection
    }

    private function connectToDatabase() {
         global $conn; 
        $this->conn = $conn; // Assign the database connection from db_connection.php to this class's $conn
    }

    public function registerUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : 1; // Default to 1 if not set

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            if ($hashedPassword === false) {
                $_SESSION['registration_error'] = "Password hashing failed";
                header('Location: ../Views/Login/register.php');
                exit;
            }

            $query = "INSERT INTO USER (FNAME, LNAME, EMAIL, PASSWORD, GROUP_ID) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                $_SESSION['registration_error'] = "Prepare failed: " . $this->conn->error;
                header('Location: ../Views/Login/register.php');
                exit;
            }
            $stmt->bind_param("ssssi", $fname, $lname, $email, $hashedPassword, $group_id);

            if ($stmt->execute()) {
                $_SESSION['registration_success'] = "Registration successful!";
                header('Location: ../Views/Login/login.php');
                exit;
            } else {
                $_SESSION['registration_error'] = "Error: " . $stmt->error;
                header('Location: ../Views/Login/register.php');
                exit;
            }

            $stmt->close();
        } else {
            header('Location: ../Views/Login/register.php');
            exit;
        }
    }
}

$controller = new RegisterController();
$controller->registerUser();
?>
