<?php

include_once(__DIR__ . '/../db_connection.php');

class User {

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

    public static function list() {
        global $conn;
        
        $sql = 'SELECT USER.USER_ID, USER.FNAME, USER.LNAME, USER.EMAIL, USER.GROUP_ID, `GROUP`.GROUP_NAME
                FROM USER INNER JOIN `GROUP` 
                ON USER.GROUP_ID = `GROUP`.GROUP_ID';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    public static function read() {
        global $conn;

        // Check if group ID is present in the session
        $groupId = isset($_SESSION['group_id']) ? $_SESSION['group_id'] : null;

        $sql = "SELECT * FROM `USER` WHERE USER_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $_SESSION['user_id']);
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Return the fetched result
        return $result->fetch_assoc();
    }
    

    public static function register() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $group = $_POST['group'];
    
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
            if ($hashedPassword === false) {
                // Password hashing failed
                $_SESSION['registration_error'] = "Password hashing failed";
                header('Location: index.php?controller=home&action=register'); // FOR NOW
                exit;
            }
    
            $query = "INSERT INTO USER (FNAME, LNAME, EMAIL, PASSWORD, GROUP_ID) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssi", $fname, $lname, $email, $hashedPassword, $group);
    
            if ($stmt->execute()) {
                $_SESSION['registration_success'] = "Registration successful!";
                header('Location: index.php?controller=home&action=login'); // FOR NOW
            } else {
                $_SESSION['registration_error'] = "Error: " . $stmt->error;
                header('Location: index.php?controller=home&action=register');
            }
    
            $stmt->close();
        } else {
            header('Location: index.php?controller=home&action=register');
        }
    }
    
    public static function login() {
        $isLoggedIn = false;
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    
                    $stmt->close();
                    header('Location: index.php?controller=home&action=index');
                } else {
                    $isLoggedIn = false;
                    $stmt->close();
                    $_SESSION['login_error'] = "Invalid username or password";
                    header('Location: index.php?controller=home&action=login');
                }
            } else {
                $isLoggedIn = false;
    
                $stmt->close();
                $_SESSION['login_error'] = "Invalid username or password";
                header('Location: index.php?controller=home&action=login');
            }
        }
    }

    /*
    function getRedirectPage($group_id) {
        if ($group_id === 1) {
            // return '../client/index.php';
            return '../Home/index.php';
        } elseif ($group_id === 2) {
            // return '../moderator/index.php';
            return '../Home/index.php';
        } elseif ($group_id === 3) {
            // return '../admin/index.php';
            return '../Home/index.php';
        } else {
            return 'login.php';
        }
    }
    */

    
    public static function create() {
        global $conn;
    
        if (isset($_POST['create'])) {
            // Get form data
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $group_id = $_POST['group_id'];
    
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
            // Prepare and execute the SQL query
            $sql = 'INSERT INTO USER (FNAME, LNAME, EMAIL, PASSWORD, GROUP_ID) VALUES (?, ?, ?, ?, ?)';
            $stmt = $conn->prepare($sql);
    
            // Check for errors in preparing the statement
            if (!$stmt) {
                die('Error preparing statement: ' . $conn->error);
            }
    
            // Bind parameters and execute the statement
            $stmt->bind_param('ssssi', $fname, $lname, $email, $hashed_password, $group_id);
            $stmt->execute();
    
            // Check for errors in executing the statement
            if ($stmt->error) {
                // Handle the error (e.g., display an error message or redirect to an error page)
                die('Error executing statement: ' . $stmt->error);
            }
    
            // Get the ID of the inserted user
            $insertedUserId = $stmt->insert_id;
    
            // Close the statement
            $stmt->close();
    
            // Redirect
            header("Location: index.php?controller=user&action=list");
            exit();
        }
    
        // Return false if the 'create' key is not present in the $_POST array
        return false;
    }
    
    public static function update() {
        global $conn;
    
        // Check if the 'update' key is set in the POST data
        if (isset($_POST['update'])) {
            // Check if 'user_id' and 'group_id' keys are set
            if (isset($_POST['user_id'])) {
                // Get form data
                $user_id = $_POST['user_id'];
                $group_id = $_POST['group_id'];
    
                // Prepare and execute the SQL update statement
                $sql = 'UPDATE USER SET GROUP_ID = ? WHERE USER_ID = ?';
                $stmt = $conn->prepare($sql);
                
                // Check if the prepare statement was successful
                if (!$stmt) {
                    // Handle the case when the prepare statement fails
                    return 0;
                }
                
                $stmt->bind_param('ii', $group_id, $user_id);
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
                header("Location: index.php?controller=user&action=list");
                exit();
            }
        }
        // Handle the case when 'update' key is not set or required keys are not present
        return 0;
    }    

    
    public static function updateEmail() {
        global $conn;
    
        // Check if the 'updateEmail' key is set in the POST data
        if (isset($_POST['updateEmail'])) {
            // Check if 'user_id' and 'emailInput' keys are set
            if (isset($_POST['user_id'], $_POST['emailInput'])) {
                // Get form data
                $user_id = $_POST['user_id'];
                $new_email = $_POST['emailInput'];
    
                // Prepare and execute the SQL update statement
                $sql = 'UPDATE USER SET EMAIL = ? WHERE USER_ID = ?';
                $stmt = $conn->prepare($sql);
    
                // Check if the prepare statement was successful
                if (!$stmt) {
                    // Handle the case when the prepare statement fails
                    return 0;
                }
    
                $stmt->bind_param('si', $new_email, $user_id);
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
                header("Location: index.php?controller=user&action=list");
                exit();
            }
        }
    
        // Handle the case when 'updateEmail' key is not set or required keys are missing
        return 0;
    }
    
    public static function updatePassword() {
        global $conn;
    
        // Check if the 'updatePassword' key is set in the POST data
        if (isset($_POST['updatePassword'])) {
            // Check if 'user_id' and 'passwordInput' keys are set
            if (isset($_POST['user_id'], $_POST['passwordInput'])) {
                // Get form data
                $user_id = $_POST['user_id'];
                $new_password = password_hash($_POST['passwordInput'], PASSWORD_DEFAULT);
    
                // Prepare and execute the SQL update statement
                $sql = 'UPDATE USER SET PASSWORD = ? WHERE USER_ID = ?';
                $stmt = $conn->prepare($sql);
    
                // Check if the prepare statement was successful
                if (!$stmt) {
                    // Handle the case when the prepare statement fails
                    return 0;
                }
    
                $stmt->bind_param('si', $new_password, $user_id);
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
                header("Location: index.php?controller=user&action=read");
                exit();
            }
        }
    
        // Handle the case when 'updatePassword' key is not set or required keys are missing
        return 0;
    }
    
    public static function delete() {
        global $conn;
    
        // Check if the 'delete' key is present in the $_POST array
        if (isset($_POST['delete']) && isset($_POST['user_id'])) {
    
            // Get form data
            $user_id = $_POST['user_id'];
            $group_id = $_POST['group_id'];
    
            // Validate $user_id (ensure it's a positive integer, for example)
    
            if ($group_id == 3) {
                // Check if there is only one admin left
                $checksql = 'SELECT COUNT(*) as count FROM USER WHERE GROUP_ID = 3';
                $checkResult = $conn->query($checksql);
                $count = $checkResult->fetch_assoc()['count'];

                if ($count <= 1) {
                    // Do not delete the last admin
                    echo "Cannot delete the last admin. Assign a new admin before deleting.";
                    return;
                }
    
                // Delete the admin
                $deletesql = 'DELETE FROM USER WHERE USER_ID = ? AND GROUP_ID = 3';
            } else {
                // Delete a regular user
                $deletesql = 'DELETE FROM USER WHERE USER_ID = ?';
            }
    
            // Prepare and execute the SQL query
            $stmt = $conn->prepare($deletesql);
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
    
            // Check for errors in executing the statement
            if ($stmt->error) {
                // Handle the error (e.g., display an error message or redirect to an error page)
                die('Error executing statement: ' . $stmt->error);
            }
    
            // Close the statement
            $stmt->close();
    
            // Redirect
            header("Location: index.php?controller=user&action=list");
            exit();
        }
    
        // Return false if the 'delete' key is not present in the $_POST array or 'user_id' is not set
        return 0;
    }
    
    

    // WILL WORRY ABOUT LATER
    public static function hasRights($classname, $action) {
        
        $sql = "SELECT rights.RIGHTS_ID, rights.ACTION_NAME, rights.CLASS_NAME FROM `user` 
        inner join `group` using (`GROUP_ID`) 
        inner join group_rights on (group.GROUP_ID = group_rights.GROUP_ID) 
        INNER join rights on (group_rights.RIGHTS_ID = rights.RIGHTS_ID) 
        WHERE rights.ACTION_NAME like '$action' and rights.CLASS_NAME like '$classname' and user.USER_ID=$this->user_id;";

        echo $sql;

        global $conn;

        $res = $conn->query($sql);
        $r = $res->fetch_assoc();

        var_dump($r);

        if($r != NULL) return true;
        else return false;

    }

    
    /*
        static function list(){
        return [];
        }
        
        function edit(){
            $this->hasRights('User',"edit");
        
        }
        
        function delete(){
            $this->hasRights('User',"delete");
        
        }
    */
}

?>
